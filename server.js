var io = require('socket.io').listen(8000);
var mysql = require('mysql');
var request = require('request');
var rooms = [];

var pool  = mysql.createPool({
	host     : 'localhost',
	user : 'collab',
	password: '',
	database : 'projects'
});

var deltas = [];
var i = 0;

function log(s) {
	console.log(s);
}

io.sockets.on('connection', function(socket) {
	socket.on('init', function(session_id, file_id) {
		console.log('Init received');
        socket.username = session_id;
        socket.room = file_id;
        socket.join(file_id);
		
		var code = null;
		
		var foundAccount = false;
		var valid = false;
		
		pool.getConnection(function (err, connection) {
			accountQuery = connection.query('SELECT * FROM accounts WHERE session_id = ?', session_id);
			accountQuery.on('result', function(data) {
				log('Account result: ' + data['id']);
				
				var user_id = data['id'];
				foundAccount = true;
				
				//Remove room query and store room as id instead of name. reduce 1 query call
				fileQuery = connection.query('SELECT * FROM files WHERE id = ?', socket.room);
				fileQuery.on('result', function(fileResult) {
					rooms[file_id] = fileResult;
					log('Room result: ' + fileResult['id']);
					
					var hasAuth = false;
					var authLevel = 0;
					
					authQuery = connection.query('SELECT * FROM file_auths WHERE user_id = ? and file_id = ?', [user_id, fileResult['id']]);
					authQuery.on('result', function(authResult) {
						log('Auth result: ' + authResult['id']);
						hasAuth = true;
						authLevel = authResult['level'];
					});
					
					authQuery.on('error', function() {
						log('auth error');
						if (!hasAuth) {
							if (fileResult['private'] != 1) {
								log('room is open');
								connection.query('INSERT INTO file_auths(user_id, file_id, level) VALUES(?, ?, ?)', [user_id, fileResult['id'], 0]);
							} else {
								socket.emit('fail');
							}
						}
					});
					
					authQuery.on('end', function() {
						log('auth end');
						if (!hasAuth) {
							log('no auths');
							if (fileResult['private'] != 1) {
								log('room is open');
								connection.query('INSERT INTO file_auths(user_id, file_id, level) VALUES(?, ?, ?)', [user_id, fileResult['id'], 0]);
								socket.emit('create_editor', fileResult['language'], fileResult['edit_level'] <= 0);
								socket.emit('initial_code', fileResult['code'], fileResult['syncAfter']);
								if (deltas[socket.room] != null) {
									socket.emit('update', deltas[socket.room]);
								}
							} else {
								log('auth failure');
								socket.emit('fail');
							}
						} else {
							socket.emit('create_editor', fileResult['language'], fileResult['edit_level'] <= authLevel);
							socket.emit('initial_code', fileResult['code'], fileResult['syncAfter']);
							if (deltas[socket.room] != null) {
								socket.emit('update', deltas[socket.room]);
							}
						}
					});
				});
				
				fileQuery.on('error', function() {
					log('room failure');
					socket.emit('fail');
				});
			});
			
			accountQuery.on('end', function() {
				if (!foundAccount) {
					console.log('account failure');
					socket.emit('fail');
				}
			});
			
			connection.release();
		});
    });
	
	socket.on('change', function(obj, session_id) {
		pool.getConnection(function (err, connection) {
			var foundAccount = false;
			
			accountQuery = connection.query('SELECT * FROM accounts WHERE session_id = ?', session_id);
			var user_id = null;
			accountQuery.on('result', function(data) {
				log('account query');
				user_id = data['id'];
				foundAccount = true;
			});
			
			accountQuery.on('end', function() {
				if (!foundAccount) {
					socket.emit('fail');
				} else {
					if (rooms[socket.room] != null) {
						if (rooms[socket.room]['private'] == 1 || rooms[socket.room]['edit_level'] > 0) {
							pool.getConnection(function (err, connection2) {
								authQuery = connection2.query('SELECT * FROM file_auths WHERE user_id = ? and file_id = ?', [user_id, socket.room]);
								var hasAuth = false;
								
								authQuery.on('result', function(authResult) {
									hasAuth = true;
									authLevel = authResult['level'];
								});
								
								authQuery.on('end', function() {
									if (!hasAuth && rooms[socket.room]['private'] == 1) {
										socket.emit('fail');
									} else if (!hasAuth) {
										socket.emit('readonly', true);
									} else {
										if (authLevel >= rooms[socket.room]['edit_level']) {
											log('update send');
											socket.broadcast.to(socket.room).emit('update', [obj]);
											if (deltas[socket.room] == null) {
												deltas[socket.room] = [];
											}
											deltas[socket.room][deltas[socket.room].length] = obj;
											console.log('Delta log: ' + deltas[socket.room]);
										} else {
											socket.emit('readonly', true);
										}
									}
								});
								connection2.release();
							});
						} else {
							socket.broadcast.to(socket.room).emit('update', [obj]);
							if (deltas[socket.room] == null) {
								deltas[socket.room] = [];
							}
							deltas[socket.room][deltas[socket.room].length] = obj;
						}
					} else {
						socket.emit('fail');
					}
				}
			});
			connection.release();
		});
    });
	
	socket.on('sync', function(code) {
		pool.getConnection(function (err, connection) {
			var hasBackups = rooms[socket.room]['hasBackups'] == 1;
			if (rooms[socket.room]['lastSync'] == null)
				rooms[socket.room]['lastSync'] = 1;
			else
				rooms[socket.room]['lastSync']++;
			
			if (hasBackups && rooms[socket.room]['lastSync'] % rooms[socket.room]['backupAfterSyncs'] == 0) {
				countQuery = connection.query('SELECT count(*) as count FROM file_backups WHERE file_id = ?', socket.room);
				countQuery.on('result', function(countResult) {				
					if (countResult['count'] < rooms[socket.room]['numberOfBackups']) {
						connection.query('INSERT INTO file_backups(file_id, code, date) VALUES(?, ?, ?)', [socket.room, code, new Date().getTime()]);
					} else {
						connection.query('DELETE FROM file_backups WHERE file_id = ? ORDER BY id ASC LIMIT 1', socket.room);
						connection.query('INSERT INTO file_backups(file_id, code, date) VALUES(?, ?, ?)', [socket.room, code, new Date().getTime()]);
					}
				});
				
				countQuery.on('error', function() {
					console.log('backup count error');
				});
			}
			
			console.log('sync init: ' + code);
			connection.query('UPDATE files SET code = ? WHERE id = ?', [code, socket.room]);
			deltas[socket.room] = [];
			connection.release();
		});
	});
	
	socket.on('disconnect', function() {
		console.log('Client disconnect');
		file_id = socket.room;
        socket.leave(socket.room);
    });
});
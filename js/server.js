var rooms = ['conn'];

io.sockets.on('connection', function(socket) {
	
	socket.on('adduser', function(username) {
        socket.username = username;
        socket.room = 'conn';
        socket.join('conn');
        //socket.emit('updatechat', 'SERVER', 'you have connected to Lobby');
        socket.broadcast.to('Lobby').emit('updatechat', 'SERVER', username + ' has connected to this room');
        socket.emit('updaterooms', rooms, 'Lobby');
    });
	
	socket.on('create', function(room) {
        rooms.push(room);
        socket.emit('updaterooms', rooms, socket.room);
    });
	
	socket.on('disconnect', function() {
        socket.leave(socket.room);
    });
});
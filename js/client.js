function runCode() {
	try {
		var result = eval(editor.getValue());
		if (result != null) {
			console.log(result);
		}
	} catch(e) {
		// report error...
		console.log(e);
	}
}

var socket = null
var insert = false;
var lastsync = 0;
var editor = null;
var noReconnect = false;
var syncAfter = 25;
var currentFile = 0;

function setType(type) {
	$('#file-type-span').html(type + ' ');
	$('#file-type').val(type);
}
function setTitle(element) {
	$('#file-title').html($(element).html());
}

function openFile(file_id) {
	if (currentFile == file_id) {
		return;
	}
	
	currentFile = file_id;
	
	if (editor != null) {
		editor.destroy();
		$('#code-line').fadeOut('fast').remove();
		$('#code-container').append($('<pre id = "code-line"></pre>').hide().fadeIn('fast'));
		editor = null;
	}

	if (socket != null) {
		socket.close();
	}
	
	socket = io.connect('http://localhost:8000');
	
	socket.on('connect', function(){
		console.log('Open file request: ' + file_id);
		if (file_id != '' && file_id != null) {
			socket.emit('init', session_id, file_id);
		} else {
			socket.close();
		}
	});
	
	socket.on('disconnect', function() {
		socket.close();
		socket = io.connect('http://localhost:8000');
	});
	
	socket.on('fail', function() {
		console.log('we failed');
		if (editor != null) 
			editor.destroy();
		$('#code-line').remove();
		$('#codeRun').remove();
		$('#error').show();
		noReconnect = true;
		socket.close();
	});
	
	socket.on('create_editor', function(lang, canEdit) {
		console.log('create editor');
		if (editor == null) {
			console.log('editor is null');
			editor = ace.edit("code-line");
			editor.setTheme("ace/theme/twilight");
			editor.getSession().setMode("ace/mode/" + lang);
			editor.setHighlightActiveLine(true);
			editor.setReadOnly(!canEdit);
			editor.getSession().on('change', function(e) {
				if (!insert) {
					console.log('emit change');
					socket.emit('change', e.data, session_id);
					lastsync++;
					if (lastsync > syncAfter) {
						socket.emit('sync', editor.getValue());
						lastsync = 0;
					}
				}
			});
		}
	});
	
	socket.on('readonly', function(readonly) {
		if (editor != null) 
			editor.setReadOnly(readonly);
	});

	socket.on('update', function(obj){
		insert = true;
		console.log(obj);
		if (editor != null) 
			editor.getSession().getDocument().applyDeltas(obj);
		insert = false;
	});

	socket.on('initial_code', function(code, syncs) {
		insert = true;
		syncAfter = syncs;
		console.log(code);
		if (editor != null) 
			editor.setValue(code);
		insert = false;
	});
}
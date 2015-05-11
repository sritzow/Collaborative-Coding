/*
		$('#code-line').on('mousemove', function(e) {
			console.log(this.selectionStart + ' -- ' + this.selectionEnd);
			if (this.selectionStart != this.selectionEnd) {
				$('#code-overlay').html(parseSyntax($('#code-line').val()));
				$('#code-overlay')[0].contenteditable = true;
				$('#code-overlay')[0].selectionStart = this.selectionStart;
				$('#code-overlay')[0].selectionEnd = this.selectionEnd;
				console.log($('#code-overlay')[0].selectionStart + ' ~~ ' + $('#code-overlay')[0].selectionEnd);
			}
		});

		$('#code-line').on('keydown', function(e) { 
			var keyCode = e.keyCode || e.which; 

			if (keyCode == 9) { 
				e.preventDefault(); 
				
				var start = $(this).get(0).selectionStart;
				var end = $(this).get(0).selectionEnd;
				
				if (start === end) {
					$(this).val($(this).val().substring(0, start)
								+ "\t"
								+ $(this).val().substring(end));
					$(this).get(0).selectionStart =
					$(this).get(0).selectionEnd = start + 1;
				} else {
					var sel = $(this).val().substring(start, end),
						find = /\n/g,
						count = sel.match(find) ? sel.match(find).length : 0;
					$(this).val($(this).val().substring(0, start)
								+ "\t"
								+ sel.replace(find, "\n\t")
								+ $(this).val().substring(end, $(this).val().length));
					$(this).get(0).selectionStart = start + count - 1;
					$(this).get(0).selectionEnd = end+count+1;
				}
				
				$('#code-overlay').html(parseSyntax($('#code-line').val()));
				Prism.highlightAll();
			} 
		});
		
		var syntax = {'function' : '#5F9EA0', 'var' : '#00FFFF', 'if' : '#1E90FF', 'for' : '#228B22', 'while' : '#483D8B'};
		
		function parseSyntax(code) {
			var codeLines = code.split('\n');
			
			/*var newText = "";
			
			var start = $('#code-line').get(0).selectionStart;
			var end = $('#code-line').get(0).selectionEnd;
				
			var current = 0;
			for (var i in codeLines) {
				var lineWords = codeLines[i].split(' ');
				for (var w in lineWords) {
					var word = lineWords[w];
					for (var l in word) {
						if (start != end) {
							if (current == start) {
								newText += '<span style = "background-color: rgba(0, 0, 0, 0.5);">';
							} else if (current == end) {
								newText += '</span>';
							}
							current++;	
							if (word[l] == '	') {
								newText += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
							} else {
								newText += word[l];
							}
						} else {
							if (word[l] == '	') {
								newText += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
							}
						}
					}
					word = word.replace(/^\t+/g, '');
					if (word != null) {
						if ($.inArray(word, syntax)) {
							newText += '<span style = "color: ' + syntax[word] + '">' + word + '</span> '; 
						} else {
							newText += syntax[word] + ' '; 
						}
						console.log(word);
					}
				}
				newText += "<br>";
			}*
			return '<pre><code class="language-javascript">' + code + '</code></pre>';
			return newText;
		}*/
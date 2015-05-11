var defaultText = "Over fact all son tell this any his. No insisted confined of weddings to returned to debating rendered. Keeps order fully so do party means young. Table nay him jokes quick. In felicity up to graceful mistaken horrible consider. Abode never think to at. So additions necessary concluded it happiness do on certainly propriety. On in green taken do offer witty of.";
			
		function getTextWidth(text, font) {
			// re-use canvas object for better performance
			var canvas = getTextWidth.canvas || (getTextWidth.canvas = document.createElement("canvas"));
			var context = canvas.getContext("2d");
			context.font = font;
			var metrics = context.measureText(text);
			return metrics.width;
		};
		var start = null;
		function verify() {
			if (start == null) {
				start = new Date().getTime();
			}
			var time = new Date().getTime() - start;
			
			var input = $('#text').val();
			var newHTML = "";
			var correct = ""
			var wrong = ""
			
			var correctWords = 0;
			var errorWords = 0;
			
			var leftOverText = defaultText;
			for (i in defaultText.split(' ')) {
				var inputWords = input.split(' ');
				var defaultWords = defaultText.split(' ');
				
				if (inputWords.length > i) {
					if (inputWords[i] === defaultWords[i]) {
						newHTML += '<span style = "color: green; ">' + inputWords[i] + ' </span>';
						correctWords++;
					} else {
						var error = false;
						if (inputWords[i].length > defaultWords[i].length) {
							newHTML += '<span style = "color:red;">' + defaultWords[i] + '</span>';
							errorWords++;
						} else {
							for (l in defaultWords[i]) {
								if (inputWords[i].length > l) {
									if (inputWords[i][l] == [defaultWords[i][l]]) {
										newHTML += '<span style = "color: green;">' + inputWords[i][l] + "</span>";
									} else {
										newHTML += '<span style = "color:red;">' + defaultWords[i][l] + '</span>';
										if (!error) {
											errorWords++;
											error = true;
										}
									}
								} else {
									if (inputWords[i].length < defaultWords[i].length && inputWords.length - 1 > i) {
										if (!error) {
											errorWords++;
											error = true;
										}
										newHTML += '<span style = "color:red;">' + defaultWords[i][l] + '</span>';
									} else {
										newHTML += '<span style = "opacity:0.4;">' + defaultWords[i][l] + '</span>';
									}
								}
							}
						}
						
						newHTML += ' ';
					}
				} else {
					newHTML += '<span style = "opacity:0.4;">' + defaultWords[i] + '</span> ';
				}
			}
			
			var width = getTextWidth(input, '21px Helvetica Neue,Helvetica,Arial,sans-serif');
			$('#background').scrollLeft(-300 + width);
			$('#background').html(newHTML);
			
			
			var text = "Correct words: " + correctWords + " - Error Words: " + errorWords;
			console.log(time);
			$('#wpm').html(text + "<br>WPM: " + Math.round(correctWords / (time / 1000 / 60)));
		}
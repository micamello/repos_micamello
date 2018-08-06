jQuery(document).ready(function () {
				var img_zone = document.getElementById('img-zone'),		
				collect = {
					filereader: typeof FileReader != 'undefined',
					zone: 'draggable' in document.createElement('span'),
					formdata: !!window.FormData
				}, 
				acceptedTypes = {
					'image/png': true,
					'image/jpeg': true,
					'image/jpg': true,
					'image/gif': true
				};
				
				// Function to show messages
				function ajax_msg(status, msg) {
					var the_msg = '<div class="alert alert-'+ (status ? 'success' : 'danger') +'">';
					the_msg += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
					the_msg += msg;
					the_msg += '</div>';
					$(the_msg).insertBefore(img_zone);
				}
				
				// Function to upload image through AJAX
				function ajax_upload(files) {					
					$('.progress').removeClass('hidden');
					$('.progress-bar').css({ "width": "0%" });
					$('.progress-bar span').html('0% complete');	
										
					var formData = new FormData();					
					//formData.append('any_var', 'any value');
					for (var i = 0; i < files.length; i++) {
						//formData.append('img_file_' + i, files[i]); 
						formData.append('img_file[]', files[i]);
					}						
			
					$.ajax({
						url : "assets/js/upload.php",
						type : 'post',
						data : formData,
						dataType : 'json',						
						processData: false,
						contentType: false,
						error : function(request){
							ajax_msg(false, 'An error has occured while uploading photo.'); 								
						},
						success : function(json){
							var img_preview = $('#img-preview');
							var col = '.col-sm-2';
							$('.progress').addClass('hidden');	
							var photos = $('<div class="photos"></div>');
							$(photos).html(json.img);								
							var lt = $(col, photos).length;
							$('col', photos).hide();
							$(img_preview).prepend(photos.html());
							$(col + ':lt('+lt+')', img_preview).fadeIn(2000);																
							if(json.error != '') 
								ajax_msg(false, json.error);
						},
						progress: function(e) {
							if(e.lengthComputable) {
								var pct = (e.loaded / e.total) * 100;
								$('.progress-bar').css({ "width": pct + "%" });	
								$('.progress-bar span').html(pct + '% complete');							
							}
							else {
								console.warn('Content Length not reported!');
							}
						}
					});					
				}
				
				// Call AJAX upload function on drag and drop event
				function dragHandle(element) {
					element.ondragover = function () { return false; };
					element.ondragend = function () { return false; };
					element.ondrop = function (e) { 
						e.preventDefault();
						ajax_upload(e.dataTransfer.files);
					}  		
				}
				
				if (collect.zone) {  		
					dragHandle(img_zone);
				} 
				else {
					alert("Drag & Drop isn't supported, use Open File Browser to upload photos.");			
				}
			
				// Call AJAX upload function on image selection using file browser button
				$(document).on('change', '.btn-file :file', function() {
					ajax_upload(this.files);			
				});
				
				// File upload progress event listener
				(function($, window, undefined) {
					var hasOnProgress = ("onprogress" in $.ajaxSettings.xhr());
				
					if (!hasOnProgress) {
						return;
					}
					
					var oldXHR = $.ajaxSettings.xhr;
					$.ajaxSettings.xhr = function() {
						var xhr = oldXHR();
						if(xhr instanceof window.XMLHttpRequest) {
							xhr.addEventListener('progress', this.progress, false);
						}
						
						if(xhr.upload) {
							xhr.upload.addEventListener('progress', this.progress, false);
						}
						
						return xhr;
					};
				})(jQuery, window);	
			});
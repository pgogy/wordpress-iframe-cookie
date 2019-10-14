// The "Upload" button

$(document).ready(
	function(){

		$('.upload_image_button')
			.each(
				function(index,value){
					$(value)
						.click(function() {
    							var send_attachment_bkp = wp.media.editor.send.attachment;
    							var button = $(this);
    							wp.media.editor.send.attachment = function(props, attachment) {
        							$(button).parent().prev().children().first().attr('src', attachment.url);
        							$(button).prev().val(attachment.id);
        							wp.media.editor.send.attachment = send_attachment_bkp;
    							}
    							wp.media.editor.open(button);
    							return false;
						}
					)
				}
			);
		

		
		$('.remove_image_button')
			.each(
				function(index,value){
					$(value)
						.click(function() {
    							var answer = confirm('Are you sure?');

    							if (answer == true) {
								
        							var src = $(this).parent().prev().children().first().attr('data-src');
								console.log($(this));
        							$(this).parent().prev().children().first().attr('src', src);
        							$(this).prev().prev().children().first().val('');
							}
							return false;
						}
    					)
					
				}	
			
			);	
    		
	
	}

);
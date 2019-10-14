jQuery(document)
	.ready(
		function(){
			jQuery("img[youtubesrc]")
				.each(
					function(index, value){
						jQuery(value)
							.click(
								function(ev){
									console.log(ev.currentTarget);
									html = "<iframe ";
									jQuery(ev.currentTarget).each(function() {
 										jQuery.each(this.attributes, function() {
    											if(this.specified) {
												if(this.name!="src"){
													attr = this.name;
													if(attr=="youtubesrc"){
														attr = "src";
													}
      													html = html + attr + "='" + this.value + "' ";
												}
    											}
  										});
									});
									html = html + '></iframe>';
									jQuery(html).insertBefore(ev.currentTarget);
									jQuery(ev.currentTarget).remove();
									jQuery(ev.currentTarget).next().remove();
								}
							);	
					}
				);
		}
	
	);
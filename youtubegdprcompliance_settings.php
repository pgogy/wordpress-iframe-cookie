<?php

	class youtubegdprcompliance_settings{
	
		function __construct(){
			add_action("admin_init", array($this, "settings_page"));
			add_action("admin_menu", array($this, "menu_item"));
			add_action( 'admin_enqueue_scripts', array($this, 'load_scripts_admin') );

		}

		function load_scripts_admin() {
			wp_enqueue_media();
			wp_enqueue_script( 'youtubegdprcompliance_media', plugin_dir_url(__FILE__) . '/js/media.js', array( 'jquery' ) );
			wp_enqueue_style( 'youtubegdprcompliance_css', plugin_dir_url(__FILE__) . '/css/admin.css' );
		}

		function settings_page(){
			add_settings_section("iframeconsent", "iframeconsent", array($this, "intro"), "iframeconsentsettings");
			
			add_settings_field("iframeconsenton", __("Whether or not to enable to the iframe replacement"), array($this, "enabled"), "iframeconsentsettings", "iframeconsent");

			add_settings_field("iframeconsentdefaultfile", __("Default Image to show if an image is not available"), array($this, "defaultFile"), "iframeconsentsettings", "iframeconsent");  

			add_settings_field("iframeconsentsoundcloudfile", __("Image to show for SoundCloud"), array($this, "soundcloudFile"), "iframeconsentsettings", "iframeconsent");  

			add_settings_field("iframeconsentlibsynfile", __("Default Image to for Libsyn"), array($this, "libsynFile"), "iframeconsentsettings", "iframeconsent");  

			add_settings_field("iframeconsentalttext", __("ALT text for the image"), array($this, "alttext"), "iframeconsentsettings", "iframeconsent");  
			add_settings_field("iframeconsentcookiewarning", __("Cookie warning and instructions"), array($this, "cookiewarning"), "iframeconsentsettings", "iframeconsent");  
			
			register_setting("iframeconsent", "iframeconsenton");
			register_setting("iframeconsent", "iframeconsentdefaultfile");
			register_setting("iframeconsent", "iframeconsentsoundcloudfile");
			register_setting("iframeconsent", "iframeconsentlibsynfile");
			register_setting("iframeconsent", "iframeconsentalttext");
			register_setting("iframeconsent", "iframeconsentcookiewarning");

		}

		function intro(){
			?><p><?PHP echo __("These are the settings for iframe Consent"); ?></p><?PHP
		}

		function enabled(){

  			$option = get_option( 'iframeconsenton' );

    			echo '<input name="iframeconsenton" id="iframeconsenton" type="checkbox" ';
			if($option == "on"){
				echo ' checked ';
			}
			echo ' value="on" />';
	
		}


		function alttext(){

  			$option = get_option( 'iframeconsentalttext' );

    			echo '<textarea name="iframeconsentalttext" id="iframeconsentalttext" placeholder="' . __("Enter ALT text for the holding image") . '">' . $option . '</textarea>';	   
	
		}

		function cookiewarning(){

  			$option = get_option( 'iframeconsentcookiewarning' );

    			echo '<textarea name="iframeconsentcookiewarning" id="iframeconsentcookiewarning" placeholder="' . __("Enter the text for warning about cookies") . '">' . $option . '</textarea>';	   
	
		}
	

		function defaultFile(){

  			$options = get_option( 'iframeconsentdefaultfile' );

   			$default_image = plugins_url('img/no-image.png', __FILE__);

    			if ( !empty( $options ) ) {
       		 		$image_attributes = wp_get_attachment_image_src( $options, array( 200, 200 ) );
        			$src = $image_attributes[0];
        			$value = $options;
    			} else {
        			$src = $default_image;
        			$value = '';
    			}

    			$text = __( 'Upload' );

    			// Print HTML field
    			echo '
        			<div class="upload">
            				<div class="defaultImage">
						<img data-src="' . $default_image . '" src="' . $src . '" height="200" width="200" />
         				</div>
					<div class="defaultImageButtons">
     	           				<input type="hidden" name="iframeconsentdefaultfile" id="iframeconsentdefaultfile" value="' . $value . '" />
    		            			<button type="submit" class="upload_image_button button">' . $text . '</button>
                				<button type="submit" class="remove_image_button button">&times;</button>
            				</div>
        			</div>
    				';		   
	
		}

		function soundcloudFile(){

  			$options = get_option( 'iframeconsentsoundcloudfile' );

   			$default_image = plugins_url('img/no-image.png', __FILE__);

    			if ( !empty( $options ) ) {
       		 		$image_attributes = wp_get_attachment_image_src( $options, array( 200, 200 ) );
        			$src = $image_attributes[0];
        			$value = $options;
    			} else {
        			$src = $default_image;
        			$value = '';
    			}

    			$text = __( 'Upload' );

    			// Print HTML field
    			echo '
        			<div class="upload">
            				<div class="defaultImage">
						<img data-src="' . $default_image . '" src="' . $src . '" height="200" width="200" />
         				</div>
					<div class="defaultImageButtons">
     	           				<input type="hidden" name="iframeconsentsoundcloudfile" id="iframeconsentsoundcloudfile" value="' . $value . '" />
    		            			<button type="submit" class="upload_image_button button">' . $text . '</button>
                				<button type="submit" class="remove_image_button button">&times;</button>
            				</div>
        			</div>
    				';		   
	
		}

		function libsynFile(){

  			$options = get_option( 'iframeconsentlibsynfile' );

   			$default_image = plugins_url('img/no-image.png', __FILE__);

    			if ( !empty( $options ) ) {
       		 		$image_attributes = wp_get_attachment_image_src( $options, array( 200, 200 ) );
        			$src = $image_attributes[0];
        			$value = $options;
    			} else {
        			$src = $default_image;
        			$value = '';
    			}

    			$text = __( 'Upload' );

    			// Print HTML field
    			echo '
        			<div class="upload">
            				<div class="defaultImage">
						<img data-src="' . $default_image . '" src="' . $src . '" height="200" width="200" />
         				</div>
					<div class="defaultImageButtons">
     	           				<input type="hidden" name="iframeconsentlibsynfile" id="iframeconsentlibsynfile" value="' . $value . '" />
    		            			<button type="submit" class="upload_image_button button">' . $text . '</button>
                				<button type="submit" class="remove_image_button button">&times;</button>
            				</div>
        			</div>
    				';		   
	
		}


		function options_page(){
		  ?>
			  <div class="wrap">
				 <h1><?PHP echo __("iframe consent options"); ?></h1>
		 
				 <form method="post" action="options.php">
					<?php
					   settings_fields("iframeconsent");
		 
					   do_settings_sections("iframeconsentsettings");
						 
					   submit_button();
					?>
				 </form>
			  </div>
		   <?php
		}

		function menu_item(){
		  	add_menu_page( __("Iframe Consent Options"), __("Iframe Consent Options"), "manage_options", 'iframeconsentsettings', array($this,"options_page"));
		}
		 
	}
	
	$youtubegdprcompliance_settings = new youtubegdprcompliance_settings();
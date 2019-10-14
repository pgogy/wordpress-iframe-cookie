<?PHP

/**
 * Plugin Name: Youtube GDPR compliance
 * Version : 0.1
 * Author : Pgogy
 */


class youtubegdprcompliance{

	function __construct(){
		if(get_option("iframeconsenton")=="on"){
			add_filter("the_content", array($this, "content"));
			add_action("wp_enqueue_scripts", array($this, "scripts"));
		}
	}

	function scripts(){
		wp_enqueue_script( 'youtubegdprcompliance', plugin_dir_url(__FILE__) . '/js/youtubegdprcompliance.js', array( 'jquery' ) );
	}

	function content($content){

		if ( (is_single() || is_page()) && in_the_loop() && is_main_query() ) {

			$doc = new DOMDocument();
			@$doc->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));

			$selector = new DOMXPath($doc);

			foreach($selector->query('//iframe') as $iframe) {

				$url = $iframe->getAttribute('src');

				if($url==false || trim($url)==""){
					$parent = $iframe->parentNode;
					$parent->removeChild($iframe);
				}

				if(strpos($url, "soundcloud.com")!==FALSE){

					$replaceHTML = $doc->saveHTML($iframe);
				
					$img = $doc->createElement('img', '');
					if($iframe->hasAttributes()){
						foreach ($iframe->attributes as $attr) {
							if($attr->nodeName == "src"){
								$attribute = "youtubesrc";
							}else{
								$attribute = $attr->nodeName;
							}
							$img->setAttribute($attribute, $attr->nodeValue);
						}
					}

					$imageID = get_option("iframeconsentdefaultfile");

					if($imageID!=""){
						$image = get_post($imageID);
						$image = $image->guid;
					}

					$img->setAttribute("alt", get_option('iframeconsentalttext'));
					$img->setAttribute("src", $image);

					$p = $doc->createElement('p', get_option('iframeconsentcookiewarning'));

					$parent = $iframe->parentNode;

					$firstSibling = $iframe->parentNode->firstChild;

					if($iframe == $firstSibling){

						$parent->insertBefore($img, $firstSibling);
						$parent->insertBefore($p, $firstSibling);
						$parent->removeChild($iframe);
						

					}else{

						$parent->removeChild($iframe);
						$parent->appendChild($img);
						$parent->appendChild($p);

					}

				}

				if(strpos($url,"youtube.com")!==FALSE){

					$id = substr($url, strpos($url, "/embed/")+7, 11);
					$replaceHTML = $doc->saveHTML($iframe);
				
					$img = $doc->createElement('img', '');
					if($iframe->hasAttributes()){
						foreach ($iframe->attributes as $attr) {
							if($attr->nodeName == "src"){
								$attribute = "youtubesrc";
							}else{
								$attribute = $attr->nodeName ;

							}
							$img->setAttribute($attribute, $attr->nodeValue);
						}
					}

					
					$img->setAttribute("alt", get_option('iframeconsentalttext'));
					$img->setAttribute("src", "https://img.youtube.com/vi/" . $id . "/0.jpg");
					$p = $doc->createElement('p', get_option('iframeconsentcookiewarning'));

					$parent = $iframe->parentNode;

					$parent->removeChild($iframe);
					$parent->appendChild($img);
					$parent->appendChild($p);

				}

				if(strpos($url, "slideshare.net")!==FALSE){

					$replaceHTML = $doc->saveHTML($iframe);
			
					$img = $doc->createElement('img', '');
					if($iframe->hasAttributes()){
						foreach ($iframe->attributes as $attr) {
							if($attr->nodeName == "src"){
								$attribute = "youtubesrc";
							}else{
								$attribute = $attr->nodeName ;

							}	
							$img->setAttribute($attribute, $attr->nodeValue);
						}
					}

					
					$img->setAttribute("alt", get_option('iframeconsentalttext'));

					$imgContent = get_transient("slideshareImageURL" . urlencode($url));

					if($imgContent==false){

						$imgContentData = wp_remote_get("https://www.slideshare.net/api/oembed/2?url=" . $url . "&format=json");

						if(isset($imgContentData['response'])){
							if(isset($imgContentData['response']['code'])){
								if($imgContentData['response']['code']=="200"){

									$imgContentURL = json_decode($imgContentData['body']);

									set_transient("slideshareImageURL" . urlencode($url), $imgContentURL->thumbnail_url, 86400);

									$imgContent = $imgContentURL->thumbnail_url;
				
								}
							}
						}

					}

					$img->setAttribute("src", $imgContent);
					$p = $doc->createElement('p', get_option('iframeconsentcookiewarning'));

					$parent = $iframe->parentNode;

					$parent->removeChild($iframe);
					$parent->appendChild($img);
					$parent->appendChild($p);

				}


				if(strpos($url, "vimeo.com")!==FALSE){

					$start = strpos($url, "/video/") + 7;
					$end = 	strpos($url, "?");

					$id = substr($url, $start, $end-$start );
					$replaceHTML = $doc->saveHTML($iframe);
			
					$img = $doc->createElement('img', '');
					if($iframe->hasAttributes()){
						foreach ($iframe->attributes as $attr) {
							if($attr->nodeName == "src"){
								$attribute = "youtubesrc";
							}else{
								$attribute = $attr->nodeName ;

							}	
							$img->setAttribute($attribute, $attr->nodeValue);
						}
					}

					
					$img->setAttribute("alt", get_option('iframeconsentalttext'));

					$imgContent = get_transient("vimeoImageURL" . $id);

					if($imgContent==false){

						echo "getting image <br />";

						$imgContentData = wp_remote_get("http://vimeo.com/api/v2/video/" . $id . ".json");

						if(isset($imgContentData['response'])){
							if(isset($imgContentData['response']['code'])){
								if($imgContentData['response']['code']=="200"){

									$imgContentURL = json_decode($imgContentData['body']);

									set_transient("vimeoImageURL" . $id, $imgContentURL[0]->thumbnail_large, 86400);

									$imgContent = $imgContentURL[0]->thumbnail_large;
				
								}
							}
						}

					}

					$img->setAttribute("src", $imgContent);
					$p = $doc->createElement('p', get_option('iframeconsentcookiewarning'));

					$parent = $iframe->parentNode;

					$parent->removeChild($iframe);
					$parent->appendChild($img);
					$parent->appendChild($p);

				}

			}			

			$content = $doc->saveHTML();

		}

		return $content;

	}

}

$youtubegdprcompliance = new youtubegdprcompliance();
require_once("youtubegdprcompliance_settings.php");

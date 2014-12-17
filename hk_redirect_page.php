<?php
/**
 * Template Name: Enkel adress till sida
 * Description: Skickar vidare användaren direkt till adressen som står i sidinnehållet. Om innehållet är tomt så skickas man till startsidan.
 */
define('WP_USE_THEMES', false);
require('./wp-blog-header.php');

if ($post) { 
	setup_postdata($post); 
	$text = "";
	if (function_exists("get_field")) {
		$url = get_field("hk_redirect_link");
		$text = get_field("hk_redirect_text");
	}
	else {
		$url = strip_tags(get_the_content(""));
	}
	if (substr($url, 0, 1) == "/") {
		$url = get_site_url() . $url;
	}


} ?>
<?php if ($url != "") : 
	//header("Location: $url");
	//echo "<meta http-equiv='refresh' content='0;url=$url'>";
endif;

if ($url != "") : ?>
<html><head><?php echo "<meta http-equiv='refresh' content='0;url=$url'>"; ?></head><body><?php echo $text; ?><br /><br />Du skickas nu vidare till <?php echo $url; ?>.</body></html>
<?php else : ?>
<html><head></head><body>Ingen enkel adress hittades.</body></html>
<?php
endif;

/*if ($url != "") : wp_redirect( $url, 301 ); exit; else : echo "Ingen enkel adress hittades."; endif;*/?>
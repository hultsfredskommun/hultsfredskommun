<?php
/**
 * Template Name: Enkel adress till sida
 * Description: Skickar vidare användaren direkt till adressen som står i sidinnehållet. Om innehållet är tomt så skickas man till startsidan.
 */
define('WP_USE_THEMES', false);
require('./wp-blog-header.php');
if ($post) { 
   setup_postdata($post); 
   $url = strip_tags(get_the_content(""));
   if ($url == "") {
   		$url = "/";
   }
} 
?><meta http-equiv="refresh" content="0;url=<?php echo $url; ?>">

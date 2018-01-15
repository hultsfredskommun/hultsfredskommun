= HULTSFREDSKOMMUN =

* by the Hultsfred team, http://hultsfred.se/

== ABOUT HULTSFREDSKOMMUN THEME ==

=== Functionality ===
* Added page type hk_contacts to view contacts
* Added page type hk_slideshow to get slideshow functionality
 * shortcode to add [kontakt] to post
* Custom meta to add related contacts, documents, posts and links
* Special featured image using ACF repeater to add more than one image, is slideshow if more than one
* The theme properties are in most cases depending on the plugin Advanced Custom Fields by Elliot Condon
* and the additional plugins ACF Repeater. ACF fields are created in inc/hk-acf-fields.php.
* Filter by editor dropdown in admin list view.
* Settings page with
 * Set news tag
 * Set protocol category
 * Set "not visible" category
 * Top image
 * Footer image
 * Logo
 * Logo 2 (with link and alt-text settings)
 * Logo in footer
 * Infinite scroll option for category list
* Shortcode to add [karta] to post.
* Google analytics if id added in settings
* Widget areas
 * Startpage topcontent
 * Startpage content
 * Startpage sidebar
 * Startpage pre-footer
 * Footer 1-4 (dynamic width set depend of how many footers are active)
 * Second Footer 1-4 (dynamic width set depend of how many footers are active)
 * Important (placed on top of all pages)
 * Right-top-menu-item
* hk_pre_search, hk_post_search, hk_pre_ajax_search and hk_post_ajax_search action hooks to add extra search in child theme
* include_tag, ignore_cat and ignore_tag added as html get variable, i.e. http://yourdomain/category/the_category/?ignore_cat=12 to ignore the category with id 12
* Contact Form 7 support
* EU cookie bar, settings is in Theme settings.
* FAQ attribute in post to add "visible" question in post and searchable. Searchable is setting to enable in Theme setting.
* AJAX search with Wordpress standard search, Relevanssi plugin and Google Custom Site Search (deprecated).
* Möjlighet att lägga till ett lokalt javascript på ett inlägg.

=== Recommended widget setup ===
* Startsida toppinnehåll
 * hk_slideshow
* Startsida sidofält
 * hk förstasidans kontakt
 * hk genväg widget
* Startsida innehåll
 * hk förstasidans innehåll
* Startsida sidofält 2
 * övriga widgets, i.e. hk protocol, aditrorecruit
* Startsidan före sidfot
 * T.ex. extra ingångar med bildlänkar
* Sidfot 1-4
 * Valfria widgets i sidfot
* Andra sidfot 1-4
 * Valfria widgets i sidfot (underst, med annan bakgrundsfärg)
* Viktigt toppinnehåll
 * Valfria widgets som hamnar högst upp på alla sidor.
* Högerställd i huvudmeny
 * Widget som hamnar till höger i menyn
* Högerställd i huvudmenyns andra nivå
 * Widget som hamnar till höger i menyns andranivå


=== Optional functionality ===
Use WP-PostViews by Lester 'GaMerZ' Chan to enable most viewed sort order in theme, is default sort order when enabled.
Use Tag Select Meta Box by Jacob Buck to get a nice tag handling.
Advanced Custom Fields - Location Field add-on 1.0 is used as a Location field on the contact post type.
Intuitive Category Checklist by Dave Bergschneider to get collapsible catogories in edit.
MCE Table Buttons to add table buttons to editor.
wpDirAuth by Paul Gilzow to get AD-intagrated login.
Adritrorecruit by Jonas Hjalmarsson to get available jobs from adritrorecruit.com
CBIS widget by Jonas Hjalmarsson to get CBIS search widgets
Contact Form 7 by Takayuki Miyoshi to get forms
AMP by Automatic to get AMP support, style added to follow this theme
HK search and filter by Hultsfredskommun to get CSV-ajax-search and search-content-filter (filter is moved from hultsfredskommun-theme).
Max Mega Menu (by Tom Hemsley) - The theme has support for this plugin with two different themes included (Hultsfreds kommun and Visit Hultsfred), clone one of the themes to make your own style.
Relevanssi (by Mikko Saari) - Support for search and also ajax search with Relevanssi plugin enabled.

=== Handy tools ===
Simple Image Size by Rahe to handle thumbnail regeneration when needed.
WP Smush.it by Dialect to get smaller image sizes.
Enable Media Replace by mungobbq to get a replace this file in Media Library.
Force User Login to hide site from public view before release.


Iconset used: 
http://www.icondeposit.com/theicondeposit:113
http://adamwhitcroft.com/batch/

Fix sortorder if not correct collate from start
http://wpquicktips.wordpress.com/2011/03/24/fix-sortorder-with-post_title-for-international-characters/

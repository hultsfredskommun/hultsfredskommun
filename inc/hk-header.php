
<?php
	global $hk_options, $firstpageClass, $printpageClass;
?>

<header id="branding" class="branding" role="banner">
	<?php /* IMPORTANT DYNAMIC TOP WIDGET CONTENT */ ?>
	<?php dynamic_sidebar('important-top-content'); ?>

	<?php /* top right navigation */ ?>
		<aside id='topmenu-mobile' class='top-menu-wrapper palm'>
			<nav>

				<ul class='top-menu'><?php
					$logo_link = isset($hk_options["logo_link"]) ? $hk_options["logo_link"] : "";
					if (empty($logo_link)) {
						$logo_link = site_url('/');
					}
					?>
					<li><span id="logo" class="logo"><a href="<?php echo $logo_link; ?>"><img class="js-svg-image" src="<?php echo isset($hk_options["logo_mobile_image"]) ? $hk_options["logo_mobile_image"] : ''; ?>" data-svg-src="<?php echo isset($hk_options["logo_mobile_image_svg"]) ? $hk_options["logo_mobile_image_svg"] : ''; ?>" alt="<?php bloginfo( 'name' ); ?>" title="<?php bloginfo( 'name' ); ?>" /></a></span></li>
                    <?php if ( !(function_exists('max_mega_menu_is_enabled') && max_mega_menu_is_enabled('primary')) ) : // show max mega menu ?>
					<li class="float--right"><a class="js-show-menu" href="#"><span class="menu-icon"></span></a></li>
					<?php endif; ?>
                    <li class="float--right"><a class="js-show-search" href="#"><span class="search-icon"></span></a></li>
					<li class="float--right"><a href="https://translate.google.com/translate?hl=sv&sl=sv&tl=en&u=<?php echo (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]; ?>"><span class="translate-small-icon"></span></a></li>
				</ul>
			</nav>

		</aside>
	<?php
		if ( ( $locations = get_nav_menu_locations() ) && isset( $locations['topmenu'] ) && $locations['topmenu'] > 0 ) : ?>
			<aside id='topmenu' class='top-menu-wrapper desk'><div class='content--center'>

				<?php if ( (($locations = get_nav_menu_locations()) && isset( $locations['topmenu'] ) && $locations['topmenu'] > 0 ) ||
						 (!empty($hk_options["translate_url"]) && $hk_options["translate_url"] != "") ||
						 (!empty($hk_options["readspeaker_id"]) && $hk_options["readspeaker_id"] != "") ) : ?>
					<nav>

					<ul class='top-menu'>
					<?php /* show google translate if set */ ?>
					<?php if (!empty($hk_options["topmenu_google_translate"])) : ?>
						<li class="pre-top-menu"><a href="https://translate.google.com/translate?hl=sv&sl=sv&tl=en&u=<?php echo (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]; ?>"><span class="translate-small-icon"></span>Google Translate</a></li>
					<?php endif; ?>

					<?php
					if (($locations = get_nav_menu_locations()) && isset( $locations['topmenu'] ) && $locations['topmenu'] > 0 ) :
					wp_nav_menu( array(
						'theme_location' => 'topmenu',
						'container' 	=> '',
						'items_wrap'	=> '%3$s',
						'depth' 		=> 2,
						'echo' 			=> true
					));
					endif;
					 ?>
					</ul></nav>
				<?php endif; ?>

			</div></aside>
		<?php endif; ?>
	<div id="topwrapper" class="content--center"><div class="top-wrapper">
		<span id="logo" class="logo"><a href="<?php echo site_url('/'); ?>"><img class="js-svg-image" src="<?php echo isset($hk_options["logo_image"]) ? $hk_options["logo_image"] : ''; ?>" data-svg-src="<?php echo isset($hk_options["logo_image_svg"]) ? $hk_options["logo_image_svg"] : ''; ?>" alt="<?php bloginfo( 'name' ); ?>" title="<?php bloginfo( 'name' ); ?>" /></a></span>
		<div class="site-title">
			<div id="site-title"><span><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span></div>
			<?php /* <h2 id="site-description"><?php bloginfo( 'description' ); ?></h2> */ ?>
		</div>

		<?php /* search form*/ ?>
		<div id="searchnavigation" class="searchnavigation" role="search">
			<?php get_search_form(); ?>
		</div>

	</div>
	<?php
        // if ajax-sökning
        if (isset($hk_options["gcse_ajax"]) && $hk_options["gcse_ajax"] != "") {
            $column_class = " no-hook";
            if((isset($hk_options["gcse_enable_faq_search"]) && $hk_options["gcse_enable_faq_search"] != "") || has_action('hk_pre_ajax_search') || has_action('hk_post_ajax_search')) { $column_class = " has-hook"; } ?>
	<div class="hk-gcse-ajax-searchresults-wrapper" style='display:none'>
		<div class="hk-gcse-ajax-searchresults<?php echo $column_class; ?>">
			<div class="hk-gcse-hook-results">
				<div class="islet">V&auml;ntar p&aring; s&ouml;kresultat...<span style="display:inline-block" class="spinner"></span></div>
			</div>
			<div class="hk-gcse-googleresults">
				<div class="gcse-searchresults"><div class="islet">V&auml;ntar p&aring; s&ouml;kresultat...<span style="display:inline-block" class="spinner"></span></div></div>
			</div>
		</div>
	</div>
	<?php } // end ajax-sökning ?>

	</div><?php // end div topwrapper ?>
	<!--googleoff: all-->

    <?php if ( function_exists('max_mega_menu_is_enabled') && max_mega_menu_is_enabled('primary') ) : // show max mega menu ?>

    <nav id="menu" class="menu-wrapper" role="navigation">
	<?php wp_nav_menu( array( 'theme_location' => 'primary') ); ?>
    </nav>

    <?php else: // show normal menu, if no max mega menu is used ?>

	<?php if (!is_search()) : ?>
	<nav id="menu" class="menu-wrapper" role="navigation">
		<?php
			if (!(($locations = get_nav_menu_locations()) && isset( $locations['primary'] ) && $locations['primary'] > 0 )) {
				echo "<div class='important-widget'>&nbsp;Du m&aring;ste s&auml;tta meny under <i>Utseende -> Menyer</i>.</div>";
			}
			$unhidden_class = (is_sub_category_firstpage())?"unhidden":"";
			hk_mobile_navmenu_navigation("primary", $cat, "primarymenu", $unhidden_class);
			hk_navmenu_old_navigation("primary", $cat, "primarymenu");
		?>
	</nav>
	<?php endif; // not is search ?>
	<?php endif; // end else normal menu ?>

</header><!-- #branding -->

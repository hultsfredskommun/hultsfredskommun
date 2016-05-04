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
					$logo_link = $hk_options["logo_link"];
					if (empty($logo_link)) {
						$logo_link = site_url('/');
					}
					?>
					<li><span id="logo" class="logo"><a href="<?php echo $logo_link; ?>"><img class="js-svg-image" src="<?php echo $hk_options["logo_mobile_image"]; ?>" data-svg-src="<?php echo $hk_options["logo_mobile_image_svg"]; ?>" alt="<?php bloginfo( 'name' ); ?>" title="<?php bloginfo( 'name' ); ?>" /></a></span></li>
					<li class="float--right"><a class="js-show-menu" href="#"><span class="menu-icon"></span></a></li>
					<li class="float--right"><a class="js-show-search" href="#"><span class="search-icon"></span></a></li>
					<li class="float--right"><a href="http://translate.google.com/translate?hl=sv&sl=sv&tl=en&u=<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]; ?>"><span class="translate-small-icon"></span></a></li>
				</ul>
			</nav>
				
		</aside>
	<?php 
		if ( ((($locations = get_nav_menu_locations()) && isset( $locations['topmenu'] ) && $locations['topmenu'] > 0) || 
			(!empty($hk_options["pre_topmenu_html"]) && $hk_options["pre_topmenu_html"] != "") || 
			(!empty($hk_options["post_topmenu_html"]) && $hk_options["post_topmenu_html"] != "") ) ) : ?>
			<aside id='topmenu' class='top-menu-wrapper desk'><div class='content--center'>
				
				<?php if ( (($locations = get_nav_menu_locations()) && isset( $locations['topmenu'] ) && $locations['topmenu'] > 0 ) || 
						 (!empty($hk_options["translate_url"]) && $hk_options["translate_url"] != "") || 
						 (!empty($hk_options["readspeaker_id"]) && $hk_options["readspeaker_id"] != "") ) : ?>
					<nav>
					
					<ul class='top-menu'>
					<?php /* pre html if any in options */ ?>
					<?php if (!empty($hk_options["pre_topmenu_html"]) && $hk_options["pre_topmenu_html"] != "") : ?>
						<li class="pre-top-menu"><?php echo $hk_options["pre_topmenu_html"]; ?></li>
					<?php endif; ?>
					<?php /* show google translate if set */ ?>
					<?php if (!empty($hk_options["topmenu_google_translate"])) : ?>
						<li class="pre-top-menu"><a href="http://translate.google.com/translate?hl=sv&sl=sv&tl=en&u=<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]; ?>"><span class="translate-small-icon"></span>Google Translate</a></li>
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
					<?php /* post html if any in options */ ?>
					<?php if (!empty($hk_options["post_topmenu_html"]) && $hk_options["post_topmenu_html"] != "") : ?>
						<li class="post-top-menu"><?php echo $hk_options["post_topmenu_html"]; ?></li>
					<?php endif; ?>
					</ul></nav>
				<?php endif; ?>
					
			</div></aside>
		<?php endif; ?>
	<div id="topwrapper" class="content--center"><div class="top-wrapper">
		<span id="logo" class="logo"><a href="<?php echo site_url('/'); ?>"><img class="js-svg-image" src="<?php echo $hk_options["logo_image"]; ?>" data-svg-src="<?php echo $hk_options["logo_image_svg"]; ?>" alt="<?php bloginfo( 'name' ); ?>" title="<?php bloginfo( 'name' ); ?>" /></a></span>
		<div class="site-title">
			<h1 id="site-title"><span><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span></h1>
			<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
		</div>
			
		<?php /* search form*/ ?>
		<?php if ($hk_options["hide_search"] != 1) : ?>
		<div id="searchnavigation" class="searchnavigation" role="search">			
			<?php get_search_form(); ?>
		</div>
		<?php endif; // end if hide_search?>
		
		
		<?php if (($hk_options["logo2_image"] != "") || ($hk_options["logo3_image"] != "") || (!empty($hk_options["right_logo_html"]) && $hk_options["right_logo_html"] != "")) : ?>
		<div id="logo2" class="logo2">
			<?php /* right logo html if any in options */ ?>
			<?php if (!empty($hk_options["right_logo_html"]) && $hk_options["right_logo_html"] != "") : ?>
				<?php echo $hk_options["right_logo_html"]; ?>
			<?php endif; ?>
			<?php if ($hk_options["logo2_image"] != "") : ?>
			<a target="_blank" href="<?php echo $hk_options["logo2_link"]; ?>" title="<?php echo $hk_options["logo2_descr"]; ?>"><img src="<?php echo $hk_options["logo2_image"]; ?>" alt="<?php echo $hk_options["logo2_descr"]; ?>" title="<?php echo $hk_options["logo2_descr"]; ?>" /></a>
			<?php endif; ?>
			<?php if ($hk_options["logo3_image"] != "") : ?>
			<a target="_blank" href="<?php echo $hk_options["logo3_link"]; ?>" title="<?php echo $hk_options["logo3_descr"]; ?>"><img src="<?php echo $hk_options["logo3_image"]; ?>" alt="<?php echo $hk_options["logo3_descr"]; ?>" title="<?php echo $hk_options["logo3_descr"]; ?>"/></a>
			<?php endif; ?>
		</div>
		<?php endif; ?>

	</div>
	<?php if ($hk_options["gcse_id"] != "" && $hk_options["gcse_ajax"] != "") { ?>
	<?php $column_class = " no-hook"; if($hk_options["gcse_enable_kontakter_search"] != "" || has_action('hk_pre_ajax_search') || has_action('hk_post_ajax_search')) { $column_class = " has-hook"; } ?>
	<div class="hk-gcse-ajax-searchresults-wrapper">
		<div class="hk-gcse-ajax-searchresults<?php echo $column_class; ?>">
			<div class="hk-gcse-hook-results">
				<div class="islet">Väntar på sökresultat...<span style="display:inline-block" class="spinner"></span></div>
			</div>
			<div class="hk-gcse-googleresults">
				<div class="gcse-searchresults"><div class="islet">Väntar på sökresultat...<span style="display:inline-block" class="spinner"></span></div></div>
			</div>
		</div>
	</div>
	<?php }  ?>
	</div>
	<!--googleoff: all-->
	<?php if (is_sub_category_firstpage()) : ?>
		<div class="responsive-menu">
			<ul class="main-sub-menu"><li><a class="js-show-main-menu" href="#">Vem &auml;r du?<span class="expand-icon">+</span></a></li></ul>
			<?php /* <a class="js-show-search" href="#"><span class="search-icon"></span></a> */ ?>
		</div>
	<?php endif; ?>

	<?php if (!is_search()) : ?>
	<nav id="menu" class="menu-wrapper" role="navigation">
		<?php
			if (!(($locations = get_nav_menu_locations()) && isset( $locations['primary'] ) && $locations['primary'] > 0 )) {
				echo "<div class='important-widget'>&nbsp;Du m&aring;ste s&auml;tta meny under <i>Utseende -> Menyer</i>.</div>";
			}
			$unhidden_class = (is_sub_category_firstpage())?"unhidden":"";
			hk_navmenu_navigation("primary", $cat, "primarymenu", $unhidden_class);
		?>
	</nav>
	<?php endif; // not is search ?>
	
	<?php if (false) : // TEMP REMOVED is_sub_category_firstpage()) /*!is_search() && get_query_var("tag") == "")*/ : ?>
		<div class="responsive-menu">
			<ul class="main-sub-menu"><li><a class="js-show-tag-menu" href="#">Visa bara<span class="expand-icon">+</span></a></li></ul>
			<?php /* <a class="js-show-search" href="#"><span class="search-icon"></span></a> */ ?>
		</div>
		<nav id="tag-menu" class="tag-menu-wrapper">
		<?php
			displayTagFilter(false, "main-sub-menu");
		?>
		</nav>
	<?php endif; ?>

</header><!-- #branding -->

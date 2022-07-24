<?php
	/**
	 * Single content, used in content.php (if is_single) and in post_load.php for dynamic load of post
	 */
?>

<article class="category-article" id="post-<?php the_ID(); ?>" <?php post_class((is_sticky())?"sticky single full":"single full"); ?>>

	<?php custom_breadcrumbs(); ?>

	<?php global $options; ?>

	<div class="category-article__utility-bar category-article-utility-bar cf">

		<div class="category-article-utility-bar__left">

			<?php if (isset($options['readspeaker_id'])) : ?>
			<div class="category-article-utility-bar__item">

				<button class="category-article-utility-bar__button">
					<svg width="18" height="16" viewBox="0 0 18 16" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Canvas" transform="translate(-2347 435)"><g id="android-volume-up"><g id="Vector"><use xlink:href="#android-volume-up-path" transform="translate(2347 -435)" fill="#A22033"/></g></g></g><defs><path id="android-volume-up-path" d="M 0 5.33333L 0 10.6667L 4.00003 10.6667L 9 15.3143L 9 0.68575L 4.00003 5.33333L 0 5.33333ZM 13.5 8C 13.5 6.40004 12.5 4.98304 11 4.29737L 11 11.6572C 12.5 11.017 13.5 9.6 13.5 8ZM 11 0L 11 1.87408C 13.8999 2.65133 16 5.12008 16 8C 16 10.88 13.8999 13.3487 11 14.1259L 11 16C 15 15.1772 18 11.8857 18 8C 18 4.11433 15 0.82275 11 0Z"/></defs></svg>
					<span class="category-article-utility-bar__heading">Lyssna</span>
				</button>

				<ul class="category-article-utility-bar__dropdown">			 
					<li class="readspeaker">
						<div id="readspeaker_button1" class="readspeaker_toolbox rs_skip rsbtn rs_preserve rsbtn_compactskin">
							<a class="rsbtn_play" accesskey="L" title="Lyssna p&aring; artikel" href="http://app.eu.readspeaker.com/cgi-bin/rsent?customerid=<?php echo $options['readspeaker_id']; ?>&amp;lang=sv_se&amp;readid=content-<?php the_ID(); ?>&amp;url=<?php the_permalink(); ?>">
							<span class="rsbtn_left rsimg rspart"><span class="rsbtn_text"><span>Lyssna</span></span></span>
							<span class="rsbtn_right rsimg rsplay rspart"></span></a>
						</div>
					</li>
				</ul>

			</div>
			<?php endif; ?>

		</div>

	</div>

	<div class="category-article__slider category-article-slider">
		<?php echo hk_get_the_post_thumbnail(get_the_ID(), 'article-image'); ?>
	</div>

	<div class="category-article__main cf" role="main">

		<div class="category-article__content category-article-content">

			<h1 class="category-article-content__title"><?php echo $post->post_title ?></h1>

			<?php 
				the_content();
			?>

			<div class="category-article__map">
				<!-- <?php the_field('post_google_map'); ?> -->
			</div>
		</div>

		<aside class="category-article__aside">

			<?php 

				$facts_content = get_field('facts_content');
				$facts_email = get_field('facts_email');

				$facts_phone_number = get_field('facts_phone');
				if (!empty($facts_phone_number)) $trimmed_facts_phone_number = preg_replace('/[^0-9]/', '', $phone_number);

				$facts_website = get_field('facts_website');
				$facts_book = get_field('facts_book');

				$hide_facts = false;

				if (empty($facts_content) && empty($facts_email) && empty($facts_phone_number) && empty($facts_website) && empty($facts_book)) $hide_facts = true;

			?>
			
			<?php if (!$hide_facts) : ?>
			<div class="category-article__facts category-article-facts">
				<h3 class="category-article-facts__title">Faktaruta</h3>
				<p class="category-article-facts__body"><?php echo $facts_content ?></p>

				<?php if(!empty($facts_content) && (!empty($facts_email) || !empty($facts_phone_number) || !empty($facts_website) || !empty($facts_book))) : ?>
					<hr class="category-article-facts__divider">
				<?php endif; ?>

				<div class="category-article-facts__contact">

					<?php if (!empty($facts_email)) : ?>
						<a href="mailto:<?php echo $facts_email ?>" class="category-article-facts__email">
							<span class="category-article-facts__svg-wrapper"><svg width="23" height="15" viewBox="0 0 23 15" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Canvas" transform="translate(-3190 -244)"><g id="ios-email"><g id="Group"><g id="Vector"><use xlink:href="#path97_fill" transform="translate(3190 244.809)" fill="#A22033"/></g><g id="Vector"><use xlink:href="#path98_fill" transform="translate(3190.47 244)" fill="#A22033"/></g></g></g></g><defs><path id="path97_fill" d="M 22.5 14.1914L 22.5 1.78814e-07L 14.8184 5.84766L 18.8086 10.3828L 18.6914 10.5L 14.0684 6.42187L 11.25 8.56641L 8.43164 6.42187L 3.80859 10.5L 3.69141 10.3828L 7.67578 5.84766L 0 0.0117188L 0 14.1914L 22.5 14.1914Z"/><path id="path98_fill" d="M 21.5449 0L 0 0L 10.7812 8.19727L 21.5449 0Z"/></defs></svg></span>
							<span><?php echo $facts_email ?></span>
						</a>
					<?php endif; ?>

					<?php if (!empty($facts_phone_number)) : ?>
						<a href="tel:<?php echo $trimmed_facts_phone_number ?>" class="category-article-facts__phone">
							<span class="category-article-facts__svg-wrapper"><svg width="16" height="16" viewBox="0 0 16 16" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Canvas" transform="translate(-3193 -271)"><g id="android-call"><g id="Vector"><use xlink:href="#path99_fill" transform="translate(3193 271)" fill="#A22033"/></g></g></g><defs><path id="path99_fill" d="M 15.1111 11.1111C 14 11.1111 12.9331 10.9332 11.9557 10.6224C 11.6445 10.5334 11.289 10.5777 11.0669 10.8446L 9.11108 12.8C 6.57767 11.5113 4.53342 9.46663 3.24433 6.93317L 5.20012 4.97787C 5.42229 4.75567 5.51104 4.40021 5.42229 4.089C 5.06658 3.06687 4.88887 2 4.88887 0.888875C 4.88887 0.400167 4.48892 0 4 0L 0.888875 0C 0.399958 0 0 0.400167 0 0.888875C 0 9.24433 6.75567 16 15.1111 16C 15.5998 16 16 15.5998 16 15.1111L 16 12C 16 11.5113 15.5998 11.1111 15.1111 11.1111Z"/></defs></svg></span>
							<span><?php echo $facts_phone_number ?></span>
						</a>
					<?php endif; ?>

				</div>

				<div class="category-article-facts__ctas cf">
					<?php if (!empty($facts_website)) : ?>
						<a target="_blank" href="<?php echo $facts_website ?>" class="category-article-facts__cta <?php if(empty($facts_book)): echo 'category-article-facts__cta--full-width'; endif; ?>" href="">Besök hemsida</a>
					<?php endif; ?>
					
					<?php if (!empty($facts_book)) : ?>
						<a target="_blank" href="<?php echo $facts_book ?>" class="category-article-facts__cta <?php if(empty($facts_website)): echo 'category-article-facts__cta--full-width'; endif; ?>" href="">Boka</a>
					<?php endif; ?>
				</div>
			</div>
			<?php endif; ?>

			<div class="category-article__article-meta category-article-article-meta">
				<?php 
				
					$href = get_field('hk_external_link_url');
					$bitly_link = wp_get_shortlink();

					$time = get_post_meta( $post->ID, 'hk_last_reviewed', true );
					if (isset($time) && $time != "") $time = "<time datetime='$time' class='updated created-date'>" . hk_theme_nicedate($time) . "</time>";// (skapad: <span class='created-date'>" . get_the_date() . "</span>)";
					else $time = "<span class='created-date'>" . get_the_date() . "</span>";

					$category = get_the_category()[0];
				
				?>
				<ul class="category-article-article-meta__list">
					<li><span>Tillhör: </span><a href="<?php echo get_category_link($category->term_taxonomy_id) ?>"><?php echo $category->name ?></a></li>
					<li><span>Granskad: </span><?php echo $time ?></li>
					<li><span>Länk: </span> <a href="<?php echo $qr_link ?>"><?php echo $bitly_link ?></a></li>
					<li><img src="https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=<?php echo urlencode($bitly_link) ?>" alt=""></li>
				</ul>
			</div>

		</aside>

	</div>


	<div class="category-article__related category-article-related cf">

		<?php 

			$related_posts = [];
			array_push($related_posts, get_next_post());
			array_push($related_posts, get_previous_post());
			
			foreach ($related_posts as $key => $related_post):
				
				$related_post->thumbnail = hk_get_first_slideshow_image_source($related_post->ID);
				$related_post->permalink = get_permalink($related_post->ID);

		?>
		
					<a href="<?php echo $related_post->permalink ?>" class="category-article-related__article category-article-related__previous">
						<?php if ($key === 0) : ?>
							<h3 class="category-article-related__heading"><svg width="21" height="8" viewBox="0 0 21 8" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Canvas" transform="translate(-2345 -1083)"><g id="hk_arrow"><use xlink:href="#hk_arrow_stroke" transform="matrix(-1 1.22465e-16 -1.22465e-16 -1 2366 1087)" fill="#A22033"/></g></g><defs><path id="hk_arrow_stroke" d="M 20.3536 0.353553C 20.5488 0.158291 20.5488 -0.158291 20.3536 -0.353553L 17.1716 -3.53553C 16.9763 -3.7308 16.6597 -3.7308 16.4645 -3.53553C 16.2692 -3.34027 16.2692 -3.02369 16.4645 -2.82843L 19.2929 0L 16.4645 2.82843C 16.2692 3.02369 16.2692 3.34027 16.4645 3.53553C 16.6597 3.7308 16.9763 3.7308 17.1716 3.53553L 20.3536 0.353553ZM 0 0.5L 20 0.5L 20 -0.5L 0 -0.5L 0 0.5Z"/></defs></svg>Föregående artikel</h3>
						<?php elseif ($key === 1) : ?>
							<h3 class="category-article-related__heading">Nästa artikel<svg width="21" height="8" viewBox="0 0 21 8" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Canvas" transform="translate(-2345 -1083)"><g id="hk_arrow"><use xlink:href="#hk_arrow_stroke" transform="matrix(-1 1.22465e-16 -1.22465e-16 -1 2366 1087)" fill="#A22033"/></g></g><defs><path id="hk_arrow_stroke" d="M 20.3536 0.353553C 20.5488 0.158291 20.5488 -0.158291 20.3536 -0.353553L 17.1716 -3.53553C 16.9763 -3.7308 16.6597 -3.7308 16.4645 -3.53553C 16.2692 -3.34027 16.2692 -3.02369 16.4645 -2.82843L 19.2929 0L 16.4645 2.82843C 16.2692 3.02369 16.2692 3.34027 16.4645 3.53553C 16.6597 3.7308 16.9763 3.7308 17.1716 3.53553L 20.3536 0.353553ZM 0 0.5L 20 0.5L 20 -0.5L 0 -0.5L 0 0.5Z"/></defs></svg></h3>					
						<?php endif; ?>
						<div class="category-article-related__inner-wrapper" style="background-image: linear-gradient(rgba(0, 0, 0, 0) 65%, rgba(0, 0, 0, 0.6)), url(<?php echo $related_post->thumbnail ?>)" role="img">
							<h2 class="category-article-related__title"><?php echo $related_post->post_title ?></h2>
						</div>
					</a>

		<?php 
		
			endforeach;
		
		?>
		

	</div>

	<!-- <pre>
		<?php // print_r($post) ?>
	</pre> -->

</article>


<?php 

	/**
	 * Gets first image source url from the ACF slideshow field.
	 */
	function hk_get_first_slideshow_image_source($id) {
		if( function_exists('get_field') && get_field('hk_featured_images', $id) ) :
			while( has_sub_field('hk_featured_images', $id)) : // only once if not showAll
				$image = get_sub_field('hk_featured_image')['sizes']['featured-image'];
				return $image;
			endwhile;
		endif; 
	}

?>
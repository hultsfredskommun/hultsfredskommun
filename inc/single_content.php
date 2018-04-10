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

			<?php if ($options['addthis_pubid'] != "") : ?>
			<div class="category-article-utility-bar__item">

				<button class="category-article-utility-bar__button">
					<svg width="15" height="16" viewBox="0 0 15 16" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Canvas" transform="translate(-2449 435)"><g id="android-share-alt"><g id="Icon 33"><g id="Group"><g id="Vector"><use xlink:href="#android-share-alt-path" transform="translate(2449 -435)" fill="#A22033"/></g></g></g></g></g><defs><path id="android-share-alt-path" d="M 12.0687 11.3368C 11.4633 11.3368 10.898 11.5378 10.4944 11.9398L 4.7224 8.60322C 4.76282 8.40217 4.80323 8.24123 4.80323 8.04024C 4.80323 7.83919 4.76282 7.67825 4.7224 7.47726L 10.4139 4.18105C 10.8578 4.58305 11.423 4.8241 12.0687 4.8241C 13.4006 4.8241 14.4905 3.73859 14.4905 2.41203C 14.4905 1.08554 13.4006 0 12.0687 0C 10.7368 0 9.64688 1.08554 9.64688 2.41207C 9.64688 2.61309 9.68707 2.77407 9.72771 2.97505L 4.03637 6.27127C 3.59233 5.86923 3.02728 5.62821 2.38143 5.62821C 1.04951 5.62821 -1.07251e-15 6.71372 -1.07251e-15 8.04028C -1.07251e-15 9.36681 1.0897 10.4524 2.42181 10.4524C 3.06765 10.4524 3.63271 10.2113 4.07675 9.80926L 9.80847 13.1459C 9.76786 13.3065 9.72768 13.4674 9.72768 13.6684C 9.72768 14.955 10.777 16 12.0687 16C 13.3603 16 14.4097 14.955 14.4097 13.6684C 14.4097 12.3819 13.3604 11.3368 12.0687 11.3368Z"/></defs></svg>
					<span class="category-article-utility-bar__heading">Dela</span>
				</button>

				<ul class="category-article-utility-bar__dropdown category-article-utility-bar__dropdown--addthis">
					<li class="addthis">
						<div class="addthis_toolbox addthis_32x32_style" addthis:url="<?php echo the_permalink(); ?>" addthis:title="<?php the_title(); ?>" addthis:description="Kolla den h&auml;r sidan.">
							<a class="addthis_button_facebook"></a>
							<a class="addthis_button_twitter"></a>
							<a class="addthis_button_google_plusone_share"></a>
							<a class="addthis_button_email"></a>
							<a class="addthis_button_print"></a>
							<a class="addthis_button_compact"></a>
							<!--a class="addthis_counter addthis_bubble_style"></a-->
						</div>
					</li>
				</ul>

			</div>
			<?php endif; ?>

		</div>

		<div class="category-article-utility-bar__right">
			<a class="category-article-utility-bar__button">
				<svg width="26" height="16" viewBox="0 0 26 16" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Canvas" transform="translate(-3274 435)"><g id="email"><g id="Group"><g id="Vector"><use xlink:href="#email-path" transform="translate(3274.35 -435)" fill="#A22033"/></g><g id="Vector"><use xlink:href="#email-path-2" transform="translate(3274 -433.533)" fill="#A22033"/></g></g></g></g><defs><path id="email-path" d="M 0.837619 1.29375C 1.52512 1.65625 11.0751 6.8625 11.4314 7.05C 11.7876 7.2375 12.1501 7.325 12.7126 7.325C 13.2751 7.325 13.6376 7.2375 13.9939 7.05C 14.3501 6.8625 23.9001 1.65625 24.5876 1.29375C 24.8439 1.1625 25.2751 0.925 25.3689 0.65625C 25.5314 0.18125 25.3564 0 24.6626 0L 12.7126 0L 0.762619 0C 0.0688695 0 -0.106131 0.1875 0.0563693 0.65625C 0.150119 0.93125 0.581369 1.1625 0.837619 1.29375Z"/><path id="email-path-2" d="M 25.4813 0.108401C 24.9688 0.370901 20.3688 3.6459 17.325 5.61465L 22.4625 11.3959C 22.5875 11.5209 22.6438 11.6709 22.575 11.7459C 22.5 11.8146 22.3375 11.7772 22.2063 11.6584L 16.0438 6.4584C 15.1125 7.0584 14.4563 7.4709 14.3438 7.5334C 13.8625 7.77715 13.525 7.8084 13.0625 7.8084C 12.6 7.8084 12.2625 7.77715 11.7813 7.5334C 11.6625 7.4709 11.0125 7.0584 10.0813 6.4584L 3.91875 11.6584C 3.79375 11.7834 3.625 11.8209 3.55 11.7459C 3.475 11.6771 3.53125 11.5209 3.65625 11.3959L 8.7875 5.61465C 5.74375 3.6459 1.09375 0.370901 0.58125 0.108401C 0.0312499 -0.172849 -4.44089e-15 0.158401 -4.44089e-15 0.414651C -4.44089e-15 0.670901 -4.44089e-15 13.2271 -4.44089e-15 13.2271C -4.44089e-15 13.8084 0.85625 14.5334 1.46875 14.5334L 13.0625 14.5334L 24.6563 14.5334C 25.2688 14.5334 26 13.8021 26 13.2271C 26 13.2271 26 0.664651 26 0.414651C 26 0.152151 26.0375 -0.172849 25.4813 0.108401Z"/></defs></svg>
				<span class="category-article-utility-bar__heading">Kontakta kommunen</span>
			</a>
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
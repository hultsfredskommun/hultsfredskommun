<?php
	define('WP_USE_THEMES', false);
	require('../../../../wp-blog-header.php');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	$href = $_POST['href'];
	$retString = "";
	if ($href != "") :

		/* get category from url */
		$next = false;
		foreach (explode("/",$href) as $hrefitem)
		{
			if ($next) {
				$cat = $hrefitem;
				break;
			}
			if ($hrefitem == "category")
				$next = true;
		}
		if ($cat != "") {

			/* get category id */
			$catObj = get_category_by_slug($cat); 
	  		$cat = $catObj->term_id;




			$retArray = array();

			/* get most visited pages */
			$query = array(	'category__in' => $cat, 'posts_per_page' => 5 );
			$dyn_query = new WP_Query();
			$dyn_query->query($query);
			$retString .= "<h4>Mest bes&ouml;kta sidor</h4>";
			$retString = "<ul>";
			while ( $dyn_query->have_posts() ) : $dyn_query->the_post();
				$retString .= "<li><a href='" . get_permalink(get_the_ID()) . "'>" . get_the_title() . "</a></li>";
			endwhile;
			$retString .= "</ul>";


			$args=array(
			  'orderby' => 'name',
			  'order' => 'ASC'
			  );
			$categories=get_categories($args);
			  foreach($categories as $category) { 
			    echo '<p>Category: <a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.'</a> </p> ';
			    echo '<p> Description:'. $category->description . '</p>';
			    echo '<p> Post Count: '. $category->count . '</p>';  } 


			echo $retString;
		}
	endif;
?>
<?php
/* 
 * Description: Add text-widget widgets with support for title, color, link and image. 
 *  */


/* WIDGET */
class HK_text_widget extends WP_Widget {


    public function __construct() {
		parent::__construct(
	 		'HK_text_widget', // Base ID
			'HK_Text_Widget', // Name
			array( 'description' => __( 'Text Widget with ex. color setting', 'hk_text_domain' ), ) // Args
		);
	}

 	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		if ( isset( $instance[ 'text' ] ) ) {
			$text = $instance[ 'text' ];
		}
		if ( isset( $instance[ 'menu' ] ) ) {
			$menu = $instance[ 'menu' ];
		}
		if ( isset( $instance[ 'color' ] ) ) {
			$color = $instance[ 'color' ];
		}
		if ( isset( $instance[ 'link' ] ) ) {
			$link = $instance[ 'link' ];
		}
		if ( isset( $instance[ 'target' ] ) ) {
			$target = $instance[ 'target' ];
		}
		if ( isset( $instance[ 'imageurl' ] ) ) {
			$imageurl = $instance[ 'imageurl' ];
		}
		if ( isset( $instance[ 'onclick' ] ) ) {
			$onclick = $instance[ 'onclick' ];
		}
		if ( isset( $instance[ 'height' ] ) ) {
			$height = $instance[ 'height' ];
		} else {
			$height = auto;
		}
		if ( isset( $instance[ 'lineheight' ] ) ) {
			$lineheight = $instance[ 'lineheight' ];
		} else {
			$lineheight = auto;
		}
		if ( isset( $instance[ 'width' ] ) ) {
			$width = $instance[ 'width' ];
		} else {
			$width = auto;
		}
		
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Titel:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Text:' ); ?></label> 
		<textarea class="widefat" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>" type="text"><?php echo $text; ?></textarea>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'menu' ); ?>"><?php _e( 'Meny:' ); ?></label> 
		<textarea class="widefat" id="<?php echo $this->get_field_id( 'menu' ); ?>" name="<?php echo $this->get_field_name( 'menu' ); ?>" type="text"><?php echo $menu; ?></textarea>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e( 'H&ouml;jd:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" type="text" value="<?php echo esc_attr( $height); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'lineheight' ); ?>"><?php _e( 'Radh&ouml;jd:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'lineheight' ); ?>" name="<?php echo $this->get_field_name( 'lineheight' ); ?>" type="text" value="<?php echo esc_attr( $lineheight); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e( 'Bredd:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" type="text" value="<?php echo esc_attr( $width); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'color' ); ?>"><?php _e( 'F&auml;rg:' ); ?></label> 
		<select class="widefat" id="<?php echo $this->get_field_id( 'color' ); ?>" name="<?php echo $this->get_field_name( 'color' ); ?>" type="text">
			<?php
			$cssClassName = 'hultsfred';
			$input = file_get_contents(get_stylesheet_directory_uri() . "/style.css");
			preg_match_all('/(.?'.addcslashes($cssClassName, '-').'.*?)\s?\{/', $input, $matches);
			foreach ($matches[1] as $key => $value) { ?>
				<?php $value = ltrim($value,"."); ?>
				<option <?php if ($color == $value) echo "selected"; ?>><?php echo $value; ?></option>	
			<?php } ?>
		</select>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'L&auml;nk:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr($link); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'target' ); ?>"><?php _e( '&Ouml;ppna i:' ); ?></label> 
		<select class="widefat" id="<?php echo $this->get_field_id( 'target' ); ?>" name="<?php echo $this->get_field_name( 'target' ); ?>" type="text">
			<option value="_top" <?php if ($target == "_top") echo "selected"; ?>>Samma f&ouml;nster</option>	
			<option value="_blank" <?php if ($target == "_blank") echo "selected"; ?>>Nytt f&ouml;nster</option>	
		</select>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'imageurl' ); ?>"><?php _e( 'Bild:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'imageurl' ); ?>" name="<?php echo $this->get_field_name( 'imageurl' ); ?>" type="text" value="<?php echo esc_attr($imageurl); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'onclick' ); ?>"><?php _e( 'onclick javascript:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'onclick' ); ?>" name="<?php echo $this->get_field_name( 'onclick' ); ?>" type="text" value="<?php echo esc_attr($onclick); ?>" />
		</p>
		<?php 
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['text'] = $new_instance['text'];
		$instance['menu'] = $new_instance['menu'];
		$instance['color'] = strip_tags( $new_instance['color'] );
		$instance['height'] = strip_tags( $new_instance['height'] );
		$instance['lineheight'] = strip_tags( $new_instance['lineheight'] );
		$instance['width'] = strip_tags( $new_instance['width'] );
		$instance['link'] = strip_tags( $new_instance['link'] );
		$instance['target'] = strip_tags( $new_instance['target'] );
		$instance['imageurl'] = strip_tags( $new_instance['imageurl'] );
		$instance['onclick'] = strip_tags( $new_instance['onclick'] );

		return $instance;
	}
	
	public function widget( $args, $instance ) {
		extract( $args );
		$title = $instance['title'];
		$text = $instance['text'];
		$menu = $instance['menu'];
		$color = $instance['color'];
		$height = $instance['height'];
		$lineheight = $instance['lineheight'];
		$width = $instance['width'];
		$link = $instance['link'];
		$target = $instance['target'];
		$imageurl = $instance['imageurl'];
		$onclick = $instance['onclick'];
		if (empty($title))
			$title ="&nbsp;";
		if ($onclick != "") {
			$onclick = "onclick='javascript:$onclick'";
			$link = "#";
		}

		$heightstyle = "height: ".$height."; line-height:".$lineheight.";";
		$widthstyle = ($width!=null)?"width: ".$width.";":"";
		$bgstyle = ($imageurl!=null)?"background-image: url($imageurl)":"";

		if ($link != "") $link = "href='$link'";
		if ($target != "") $target = "target='$target'";
		
		echo str_replace("aside", "aside style='$widthstyle'", $before_widget);

		echo "<div class='$color' style='$heightstyle $bgstyle'>";
		echo "<div class='text'>";
		echo "<div class='transp-background $color'></div>";
		echo "<a class='$color' $onclick $link $target>$title</a>";
		echo "</div>";
		echo "<div class='textarea'>" . str_replace("\n","<br>",$text) . "</div>";
		echo "<div class='menu'>";
			if ($menu) {
				echo "<aside><nav>";
				wp_nav_menu( array(
					'menu' => $menu, 
					'container' => '',							
					'items_wrap' => '<ul>%3$s</ul>',
					'depth' => 1,
					'echo' => true
				)); 
				echo "</nav></aside>";
			}
		echo "</div>";
		echo "</div>";
		
		echo $after_widget;
	}

}

add_action( 'widgets_init', create_function( '', 'register_widget( "HK_Text_Widget" );' ) );
?>	
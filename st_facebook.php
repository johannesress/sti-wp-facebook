<?php
error_reporting(E_ALL);
/**
 * Plugin Name: ST Widgets - Facebook
 * Plugin URI: http://stinformatik.eu
 * Description: Displays Facebook Like Box
 * Version: 0.5
 * Author: Johannes Reß
 * Author URI: http://johannesress.com
 * License: No licensing
 */

class ST_Facebook extends WP_Widget {

	function __construct() {
		$params = array(
			'description' => 'Anzeigen der Facebook Like Box.',
			'classname' => 'st-facebook-widget',
			'name' => 'Facebook Feed'
		);

		parent::__construct('ST_Facebook', '', $params);
	}

	public function form($instance) {
		extract($instance);
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Titel</label>
			<input type="text"
				class="widefat" 
				id="<?php echo $this->get_field_id('title'); ?>"
				name="<?php echo $this->get_field_name('title'); ?>"
				value="<?php if(isset($title)) echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('facebook_username'); ?>">Facebook Page Name</label>
			<input type="text"
				class="widefat" 
				id="<?php echo $this->get_field_id('facebook_username'); ?>"
				name="<?php echo $this->get_field_name('facebook_username'); ?>"
				value="<?php if(isset($facebook_username)) echo esc_attr($facebook_username); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('facebook_width'); ?>">Breite der Box in px</label>
			<input type="text"
				class="widefat" 
				id="<?php echo $this->get_field_id('facebook_width'); ?>"
				name="<?php echo $this->get_field_name('facebook_width'); ?>"
				value="<?php if(isset($facebook_width)) echo esc_attr($facebook_width); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('facebook_height'); ?>">Höhe der Box in px</label>
			<input type="text"
				class="widefat" 
				id="<?php echo $this->get_field_id('facebook_height'); ?>"
				name="<?php echo $this->get_field_name('facebook_height'); ?>"
				value="<?php if(isset($facebook_height)) echo esc_attr($facebook_height); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('facebook_color'); ?>">Hintergrundfarbe</label>
			<input type="text"
				class="widefat" 
				id="<?php echo $this->get_field_id('facebook_color'); ?>"
				name="<?php echo $this->get_field_name('facebook_color'); ?>"
				value="<?php if(isset($facebook_color)) echo esc_attr($facebook_color); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('facebook_faces'); ?>">
				<input type="checkbox" 
					id="<?php echo $this->get_field_id('facebook_faces'); ?>"
					name="<?php echo $this->get_field_name('facebook_faces'); ?>" 
					<?php echo ($facebook_faces) ? "checked" : ""; ?>
					/>
					Gesichter anzeigen?
			</label>
		</p>

		<?php
	}

	public function widget($args, $instance) {
		extract($args);
		extract($instance);

		/* SDK */
		echo '<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/de_DE/all.js#xfbml=1&appId=206927852692814";
  fjs.parentNode.insertBefore(js, fjs);
}(document, "script", "facebook-jssdk"));</script>';

		/* */

		$title = apply_filters('widget_title', $title);
		$facebook_username = apply_filters('widget_facebook_username', $facebook_username);

		if( empty($facebook_username) ) $facebook_username = 'kilkennyknights';

		if( empty($facebook_color) ) $facebook_color = 'white';

		if($facebook_faces) {
			$faces = "true";
		} else {
			$faces = "false";
		}

		echo $before_widget . "<div class='st-facebook-widget'>" ;

		if( !empty($title) ) {
			echo $before_title . $title . $after_title;
		}
			echo '<div style="background-color: '.$facebook_color.'; padding-right: 5px;">';
				echo '<div class="fb-like-box" data-href="http://www.facebook.com/'.$facebook_username.'" data-width="'.$facebook_width.'" data-height="'.$facebook_height.'" data-colorscheme="light" data-show-faces="'.$faces.'" data-header="false" data-stream="false" data-show-border="false"></div>';
			echo '</div>';
		echo "</div>".$after_widget;
	}

}

add_action('widgets_init', 'jr_register_st_facebook');

function jr_register_st_facebook() {
	register_widget('ST_facebook');
}
<?php

/**
* WPBakery Page Builder Ohio Google Maps shortcode view
*/

?>
<div class="ohio-google-maps-sc google-maps" id="<?php echo esc_attr( $google_maps_uniqid ); ?>" 
data-google-map="true" data-google-map-zoom="<?php echo esc_attr( $map_zoom ); ?>"
<?php if($map_zoom_enable) { ?> data-google-map-zoom-enable="true" <?php } ?>
<?php if($map_street_enable) { ?> data-google-map-steet-enable="true" <?php } ?>
<?php if($map_type_enable) { ?> data-google-map-type-enable="true" <?php } ?>
<?php if($map_fullscreen_enable) { ?> data-google-map-fullscreen-enable="true" <?php } ?>
data-google-map-marker="<?php echo esc_attr( $map_marker ); ?>"
data-google-map-style="<?php echo esc_attr( $map_style ); ?>"

>
	<?php
		echo esc_html($ohio_api_key == '' ? 'Please enter API key': '');
	?>
	<div class="google-maps-wrap"></div>
	<div class="hidden" data-google-map-markers="true"><?php echo esc_attr( $marker_locations ); ?></div>

</div>
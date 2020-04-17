<?php

/**
* WPBakery Page Builder Ohio Contact Form shortcode view
*/

?>
<div class="ohio-contact-from-sc contact-form <?php echo $contact_form_class; ?><?php echo $css_class; ?>"
	id="<?php echo esc_attr( $contact_form_uniqid ); ?>" 
	<?php if ( $appearance_effect != 'none' ) { echo ' data-aos="' . $appearance_effect . '"'; } ?> 
	<?php if ( $appearance_duration ) { echo ' data-aos-duration="' . $appearance_duration . '"'; } ?>
	<?php if ( $appearance_delay ) echo ' data-aos-delay="' . $appearance_delay . '"'; ?>>

	<?php echo do_shortcode( '[contact-form-7 id="' . esc_attr( $form_id ) . '" title=""]' ); ?>

	<div class="hidden" data-contact-btn="true">
		<button class="btn <?php echo $button_css['classes']; ?>">
			<span class="btn-load"></span>
			<span class="text"></span>
		</button>
	</div>
</div>
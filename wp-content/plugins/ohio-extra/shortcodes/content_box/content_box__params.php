<?php

/**
* WPBakery Page Builder Ohio Accordion shortcode params
*/

vc_lean_map( 'ohio_content_box', 'ohio_content_box_sc_map' );

function ohio_content_box_sc_map() {
	return array(
		'name' => __( 'Content Box', 'ohio-extra' ),
		'description' => __( 'Content box block', 'ohio-extra' ),
		'base' => 'ohio_content_box',
		'category' => __( 'Ohio', 'ohio-extra' ),
		"content_element" => true,
		"is_container" => true,
		"js_view" => 'VcColumnView',
		'icon' => plugin_dir_url( __FILE__ ) . 'images/icon.svg',
		'params' => array(
			array(
				'type' => 'css_editor',
				'heading' => __( 'Css', 'ohio_content_box' ),
				'param_name' => 'content_styles',
				'group' => __( 'Design options', 'ohio-extra' ),
			),
			// Color settings
			array(
				'type' => 'ohio_divider',
				'group' => __( 'Styles & Colors', 'ohio-extra' ),
				'param_name' => 'style_card_title',
				'value' => __( 'Color settings', 'ohio-extra' ),
			),
			array(
				'type' => 'ohio_colorpicker',
				'group' => __( 'Styles & Colors', 'ohio-extra' ),
				'heading' => __( 'Border hover color', 'ohio-extra' ),
				'param_name' => 'border_hover_color'
			),

			// Custom CSS Class
			array(
				'type' => 'ohio_divider',
				'group' => __( 'Styles & Colors', 'ohio-extra' ),
				'param_name' => 'other_settings_title',
				'value' => __( 'Other', 'ohio-extra' ),
			),
			array(
				'type' => 'textfield',
				'group' => __( 'Styles & Colors', 'ohio-extra' ),
				'heading' => __( 'Custom CSS class', 'ohio-extra' ),
				'param_name' => 'css_class',
				'description' => __( 'If you want to add own styles to a specific unit, use this field to add custom CSS class.', 'ohio-extra' )
			),

			// Appear Effect
			array(
				'type' => 'dropdown',
				'group' => __( 'Appear Effect', 'ohio-extra' ),
				'heading' => __( 'Appear effect', 'ohio-extra' ),
				'param_name' => 'appearance_effect',
				'value' => array(
					__( 'None', 'ohio-extra' ) => 'none',
					__( 'Fade up', 'ohio-extra' ) => 'fade-up',
					__( 'Fade left', 'ohio-extra' ) => 'fade-left',
					__( 'Fade right', 'ohio-extra' ) => 'fade-right',
					__( 'Slide up', 'ohio-extra' ) => 'slide-up',
					__( 'Flip up', 'ohio-extra' ) => 'flip-up',
					__( 'Zoom in', 'ohio-extra' ) => 'zoom-in'
				)
			),
			array(
				'type' => 'textfield',
				'group' => __( 'Appear Effect', 'ohio-extra' ),
				'heading' => __( 'Animation duration', 'ohio-extra' ),
				'param_name' => 'appearance_duration',
				'description' => __( 'Duration accept values from 50 to 3000 (ms), with step 50.', 'ohio-extra' ),
			),
			array(
				'type' => 'textfield',
				'group' => __( 'Appear Effect', 'ohio-extra' ),
				'heading' => __( 'Animation delay', 'ohio-extra' ),
				'param_name' => 'appearance_delay',
				'description' => __( 'A delay before animation, accepted values are in range from 50 to 3000 (ms), with a step of 50.', 'ohio-extra' ),
			)
		)
	);
}


if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_Ohio_Content_Box extends WPBakeryShortCodesContainer {
		
	}
}
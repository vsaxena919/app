<?php 

/**
* WPBakery Page Builder Ohio Accordion shortcode
*/

add_shortcode( 'ohio_accordion', 'ohio_accordion_func' );

function ohio_accordion_func( $atts, $content = null ) {
	if ( isset( $atts ) && is_array( $atts ) ) extract( $atts );

	// Default values, parsing and filtering
	$accordion_tabs_type = isset( $accordion_tabs_type ) ? NorExtraFilter::string( $accordion_tabs_type, 'string', 'default' ) : 'default';
	$tab_bg_color = isset( $tab_bg_color ) ? NorExtraFilter::string( $tab_bg_color ) : false;
	$tab_border_color = isset( $tab_border_color ) ? NorExtraFilter::string( $tab_border_color ) : false;
	$tab_color = isset( $tab_color ) ? NorExtraFilter::string( $tab_color ) : false;
	$active_color = isset( $active_color ) ? NorExtraFilter::string( $active_color ) : false;
	$tab_content_color = isset( $tab_content_color ) ? NorExtraFilter::string( $tab_content_color ) : false;
	$accordion_tabs_title_typo = isset( $accordion_tabs_title_typo ) ? NorExtraFilter::string( $accordion_tabs_title_typo ) : false;
	$accordion_tabs_content_typo = isset( $accordion_tabs_content_typo ) ? NorExtraFilter::string( $accordion_tabs_content_typo ) : false;

	$appearance_effect = isset( $appearance_effect ) ? NorExtraFilter::string( $appearance_effect, 'attr', 'none' )  : 'none';
	$appearance_duration = isset( $appearance_duration ) ? NorExtraFilter::string( $appearance_duration, 'attr', false )  : false;
	$appearance_delay = isset( $appearance_delay ) ? NorExtraFilter::string( $appearance_delay, 'attr', false ) : false;
	$appearance_delay = intval( str_replace( 'ms', '', $appearance_delay ) );
	if ( $appearance_duration ) $appearance_duration = intval( str_replace( 'ms', '', $appearance_duration ) );

	$css_class = isset( $css_class ) ? ' ' . NorExtraFilter::string( $css_class, 'attr', '' )  : '';

	if ( $appearance_effect != 'none' ) {
		OhioHelper::add_required_script( 'aos' );
	}

	// Styling
	$accordion_uniqid = uniqid( 'ohio-custom-' );

	$accordion_class = ( $accordion_tabs_type == 'outline' ) ? ' outline' : '';

	$tab_bg_settings = NorExtraParser::VC_color_to_CSS( $tab_bg_color, 'background-color:{{color}};' );
	$tab_border_settings = NorExtraParser::VC_color_to_CSS( $tab_border_color, 'border-color:{{color}};' );
	$active_settings = NorExtraParser::VC_color_to_CSS( $active_color, 'color:{{color}};' );
	$tab_css = NorExtraParser::VC_typo_to_CSS( $accordion_tabs_title_typo );
	$content_css = NorExtraParser::VC_typo_to_CSS( $accordion_tabs_content_typo );
	NorExtraParser::VC_typo_custom_font( $accordion_tabs_title_typo );
	NorExtraParser::VC_typo_custom_font( $accordion_tabs_content_typo );

	if ( $accordion_tabs_type == 'outline' ) {
		$tab_css .= $tab_border_settings;
	} else {
		$tab_css .= $tab_bg_settings;
	}

	// Assembling
	include( plugin_dir_path( __FILE__ ) . 'accordion__style.php' );
	ob_start();
	include( plugin_dir_path( __FILE__ ) . 'accordion__view.php' );
	return ob_get_clean();
}
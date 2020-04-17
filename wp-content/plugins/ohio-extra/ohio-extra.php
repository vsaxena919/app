<?php
/*
	Plugin Name: Ohio Extra
	Plugin URI: https://clbthemes.com
	Description: Supercharge your WordPress site with WPBakery Page Builder custom shortcodes, ACF PRO extended theme settings and additional widgets.
	Version: 1.0.6
	Author: Colabrio
	Author URI: https://clbthemes.com

	Copyright 2020 Colabrio (email: support@clbthemes.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301 USA
*/

$ohio_extra_get_theme = wp_get_theme();

if ( in_array( $ohio_extra_get_theme->get( 'TextDomain' ), array( 'ohio', 'ohio-child' ) ) ) {

	include_once plugin_dir_path( __FILE__ ) . 'rest_api/routes.php';

	add_action( 'plugins_loaded', 'ohio_extra_load_plugin_textdomain' );

	function ohio_extra_load_plugin_textdomain() {
		load_plugin_textdomain( 'ohio-extra', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	add_action( 'vc_before_init', 'ohio_extra_vc_init_plugin' );

	if ( function_exists( 'vc_set_shortcodes_templates_dir' ) ) {
		$vc_template_dir = plugin_dir_path( __FILE__ ) . 'vc_templates';
		vc_set_shortcodes_templates_dir( $vc_template_dir );
	}


	// Ohio social shortcodes
	function ohio_share_woo_func( ) {
		global $post;

		$social_networks = OhioOptions::get_global( 'woocommerce_sharing_networks' );

		if ( !$social_networks ) {
			return false;
		}

		$facebook_link = 'https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode( get_permalink() );
		$twitter_link = 'https://twitter.com/intent/tweet?text=' . urlencode( $post->post_title ) . ',+' . rawurlencode( get_permalink() );
		$google_link = 'https://plus.google.com/share?url=' . rawurlencode( get_permalink() );
		$linkedin_link = 'https://www.linkedin.com/shareArticle?mini=true&url=' . rawurlencode( get_permalink() ) . '&title=' . urlencode( $post->post_title ) . '&source=' . urlencode( get_bloginfo( 'name' ) );
		$pinterest_link = 'http://pinterest.com/pin/create/button/?url=' . rawurlencode( get_permalink() ) . '&description=' . urlencode( $post->post_title );
		$vk_link = 'http://vk.com/share.php?url=' . rawurlencode( get_permalink() );
		?>

		<div class="woocommerce-share">
			<div class="wrap">
				<?php _e( 'Share this product', 'ohio' ); ?>:
				<div class="socialbar flat">
				<?php
					foreach ( $social_networks as $link ) {
						switch ( $link ) {
							case 'facebook':
								echo '<a href="' . $facebook_link . '"><span class="fa fa-facebook-f"></span></a>';
								break;
							case 'twitter':
								echo '<a href="' . $twitter_link . '"><span class="fa fa-twitter"></span></a>';
								break;
							case 'googleplus':
								echo '<a href="' . $google_link . '"><span class="fa fa-google"></span></a>';
								break;
							case 'linkedin':
								echo '<a href="' . $linkedin_link . '"><span class="fa fa-linkedin"></span></a>';
								break;
							case 'pinterest':
								echo '<a href="' . $pinterest_link . '"><span class="fa fa-pinterest-p"></span></a>';
								break;
							case 'vk':
								echo '<a href="' . $vk_link . '"><span class="fa fa-vk"></span></a>';
								break;
						}
					}
				?>
				</div>
			</div>
		</div>
		<?php return "";
	}
	add_shortcode( 'ohio_share_woo', 'ohio_share_woo_func' );

	function ohio_share_blog_func( ) {
		global $post;

		$social_networks = OhioOptions::get_global( 'post_sharing_networks' );

		if ( !$social_networks ) {
			return false;
		}

		$facebook_link = 'https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode( get_permalink() );
		$twitter_link = 'https://twitter.com/intent/tweet?text=' . urlencode( $post->post_title ) . ',+' . rawurlencode( get_permalink() );
		$google_link = 'https://plus.google.com/share?url=' . rawurlencode( get_permalink() );
		$linkedin_link = 'https://www.linkedin.com/shareArticle?mini=true&url=' . rawurlencode( get_permalink() ) . '&title=' . urlencode( $post->post_title ) . '&source=' . urlencode( get_bloginfo( 'name' ) );
		$pinterest_link = 'http://pinterest.com/pin/create/button/?url=' . rawurlencode( get_permalink() ) . '&description=' . urlencode( $post->post_title );
		$vk_link = 'http://vk.com/share.php?url=' . rawurlencode( get_permalink() );
		?>

		<div class="clb-share-bar" data-blog-share="true">
			<div class="socialbar flat">
			<?php
				foreach ( $social_networks as $link ) {
					switch ( $link ) {
						case 'facebook':
							echo '<a href="' . $facebook_link . '" class="facebook"><span class="fa fa-facebook-f"></span></a>';
							break;
						case 'twitter':
							echo '<a href="' . $twitter_link . '" class="twitter"><span class="fa fa-twitter"></span></a>';
							break;
						case 'googleplus':
							echo '<a href="' . $google_link . '" class="googleplus"><span class="fa fa-google"></span></a>';
							break;
						case 'linkedin':
							echo '<a href="' . $linkedin_link . '" class="linkedin"><span class="fa fa-linkedin"></span></a>';
							break;
						case 'pinterest':
							echo '<a href="' . $pinterest_link . '" class="pinterest"><span class="fa fa-pinterest-p"></span></a>';
							break;
						case 'vk':
							echo '<a href="' . $vk_link . '" class="vk"><span class="fa fa-vk"></span></a>';
							break;
					}
				}
			?>
			</div>
		</div>
		<?php return "";
	}
	add_shortcode( 'ohio_share_blog', 'ohio_share_blog_func' );



	function ohio_extra_vc_init_plugin() {
        $shortcodes_path = plugin_dir_path( __FILE__ ) . 'shortcodes/';
        $helpers_path 	= plugin_dir_path( __FILE__ ) . 'helpers/';
        $types_path 	= plugin_dir_path( __FILE__ ) . 'types/';

        // Helpers
        require_once $helpers_path . 'parsing.php';
        require_once $helpers_path . 'filtering.php';
        require_once $helpers_path . 'google_fonts.php';
		require_once $helpers_path . 'adobe_fonts.php';
		require_once $helpers_path . 'custom_fonts.php';

        // VC param types
        require_once $types_path . 'input.php'; // Fully HTML allowed input
        require_once $types_path . 'button.php'; // Button settings
        require_once $types_path . 'columns.php'; // Columns settings
        require_once $types_path . 'colorpicker.php'; // Color picker settings
        require_once $types_path . 'choose_box.php'; // Radio select with images
        require_once $types_path . 'check.php'; // Pretty checkboxes
        require_once $types_path . 'divider.php'; // Simple titled divider
        require_once $types_path . 'typography.php'; // Powerful typography module
        //require_once $types_path . 'icon_selector.php'; // Old extended icon selector
        require_once $types_path . 'icon_picker.php'; // Extended icon picker
        require_once $types_path . 'datetime.php'; // JQuery datetime selector
        require_once $types_path . 'portfolio_types.php'; // Dropdown with portfolio categories
        require_once $types_path . 'post_types.php'; // Dropdown with post categories
        require_once $types_path . 'woo_cats_types.php'; // Dropdown with WooCommerce categories

        // VC shortcodes
        $dh = opendir( $shortcodes_path );
        while ( false !== ( $filename = readdir( $dh ) ) ) {
          if ( substr( $filename, 0, 1) != '_' && strrpos( $filename, '.' ) === false ) {
            include_once $shortcodes_path . $filename . '/' . $filename . '.php';
            include_once $shortcodes_path . $filename . '/' . $filename . '__params.php';
          }
        }

        add_action('vc_after_init', function() {
        		// Custom setting for default row
				$useLinesData = array(
					'type' => 'ohio_check',
					'heading' => __( 'Use through lines under background?', 'ohio-extra' ),
					'param_name' => 'use_through_lines',
					'description' => __( '...', 'ohio-extra' ),
					'value' => array(
						__( 'Yes, use lines for this row', 'ohio-extra' ) => '0'
					)
				);
				vc_update_shortcode_param( 'vc_row', $useLinesData );

				$linesStyleData = array(
					'type' => 'dropdown',
					'heading' => __( 'Through lines background style', 'ohio-extra' ),
					'param_name' => 'through_lines_style',
					'description' => __( '...', 'ohio-extra' ),
					'value' => array(
						__( 'Dark', 'ohio-extra' ) => 'dark',
						__( 'Light', 'ohio-extra' ) => 'light'
					),
					'dependency' => array(
						'element' => 'use_through_lines',
						'value' => array(
							'1'
						)
					)
				);
				vc_update_shortcode_param( 'vc_row', $linesStyleData );

				$sideTitleData = array(
					'type' => 'textfield',
					'group' => __( 'Side Background Title', 'ohio-extra' ),
					'heading' => __( 'Background title text', 'ohio-extra' ),
					'param_name' => 'side_background_title',
					'description' => __( 'Recommended to use short headers.', 'ohio-extra' ),
				);
				vc_update_shortcode_param( 'vc_row', $sideTitleData );

				$sideTitleAlignmentData = array(
					'type' => 'dropdown',
					'group' => __( 'Side Background Title', 'ohio-extra' ),
					'heading' => __( 'Background title alignment', 'ohio-extra' ),
					'param_name' => 'side_background_title_alignment',
					'value' => array(
						__( 'Left', 'ohio-extra' ) => 'left',
						__( 'Right', 'ohio-extra' ) => 'right'
					)
				);
				vc_update_shortcode_param( 'vc_row', $sideTitleAlignmentData );

				$sideTitleColorData = array(
					'type' => 'ohio_colorpicker',
					'group' => __( 'Side Background Title', 'ohio-extra' ),
					'heading' => __( 'Background title color', 'ohio-extra' ),
					'param_name' => 'side_background_title_color',
					'description' => __( 'Recommended to use transparent or non-contrast colors.', 'ohio-extra' ),
				);
				vc_update_shortcode_param( 'vc_row', $sideTitleColorData );

				$sideTitleTypoData = array(
					'type' => 'ohio_typography',
					'group' => __( 'Side Background Title', 'ohio-extra' ),
					'heading' => __( 'Background title typography', 'ohio-extra' ),
					'param_name' => 'side_background_title_typo'
				);
				vc_update_shortcode_param( 'vc_row', $sideTitleTypoData );
			});
	}


	add_action( 'widgets_init', 'ohio_extra_widgets_init_plugin' );

	function ohio_extra_widgets_init_plugin() {
		$widgets_path = plugin_dir_path( __FILE__ ) . 'widgets/';

		require_once $widgets_path . 'widget.php';
		require_once $widgets_path . 'widget-about-author.php'; // About author. Multicontext widget
		require_once $widgets_path . 'widget-contacts.php'; // Contacts block widget
		require_once $widgets_path . 'widget-login.php'; // Login into Wordpress
		require_once $widgets_path . 'widget-logo.php'; // Show logo in sidebar
		require_once $widgets_path . 'widget-menu.php'; // Navigation widget
		require_once $widgets_path . 'widget-recent.php'; // Recent posts widget
		require_once $widgets_path . 'widget-socialbar-subscribe.php'; // ?
		require_once $widgets_path . 'widget-socialbar.php'; // Social bar icons with
		require_once $widgets_path . 'widget-subscribe.php'; // Subscribe by Feedburner feed
	}

	// ACF Ohio fields extention
	require plugin_dir_path( __FILE__ ) . 'acf_ext/acf-fields.php';

	// Custom admin bar theme menu
	add_action( 'admin_bar_menu', 'ohio_admin_bar_link', 40 );
	function ohio_admin_bar_link( $wp_admin_bar ) {
		$args = array(
			'id'     => 'theme-settings',
			'title'	=>	esc_html__('Theme settings', 'ohio'),
		);
		$wp_admin_bar->add_node( $args );

		$args = array();
		array_push($args,array(
			'id'		=>	'branding',
			'title'		=>	esc_html__('Branding', 'ohio'),
			'href'		=>	admin_url('admin.php?page=theme-general-branding'),
			'parent'	=>	'theme-settings',
		));
		array_push($args,array(
			'id'		=>	'theme-styling',
			'title'		=>	esc_html__('Theme Styling', 'ohio'),
			'href'		=>	admin_url('admin.php?page=theme-general-styling'),
			'parent'	=>	'theme-settings',
		));
		array_push($args,array(
			'id'		=>	'typography',
			'title'		=>	esc_html__('Typography', 'ohio'),
			'href'		=>	admin_url('admin.php?page=theme-general-typography'),
			'parent'	=>	'theme-settings',
		));
		array_push($args,array(
			'id'		=>	'header-menu',
			'title'		=>	esc_html__('Header & Menu', 'ohio'),
			'href'		=>	admin_url('admin.php?page=theme-general-header'),
			'parent'	=>	'theme-settings',
		));
		array_push($args,array(
			'id'		=>	'page-settings',
			'title'		=>	esc_html__('Page Settings', 'ohio'),
			'href'		=>	admin_url('admin.php?page=theme-general-pages'),
			'parent'	=>	'theme-settings',
		));
		array_push($args,array(
			'id'		=>	'blog-settings',
			'title'		=>	esc_html__('Blog Settings', 'ohio'),
			'href'		=>	admin_url('admin.php?page=theme-general-blog'),
			'parent'	=>	'theme-settings',
		));
		array_push($args,array(
			'id'		=>	'portfolio-settings',
			'title'		=>	esc_html__('Portfolio Settings', 'ohio'),
			'href'		=>	admin_url('admin.php?page=theme-general-portfolio'),
			'parent'	=>	'theme-settings',
		));
		array_push($args,array(
			'id'		=>	'shop-settings',
			'title'		=>	esc_html__('Shop Settings', 'ohio'),
			'href'		=>	admin_url('admin.php?page=theme-general-woocommerce'),
			'parent'	=>	'theme-settings',
		));
		array_push($args,array(
			'id'		=>	'subscribe-settings',
			'title'		=>	esc_html__('Subscribe Pop-up', 'ohio'),
			'href'		=>	admin_url('admin.php?page=theme-general-subscribe'),
			'parent'	=>	'theme-settings',
		));
		array_push($args,array(
			'id'		=>	'footer-settings',
			'title'		=>	esc_html__('Footer', 'ohio'),
			'href'		=>	admin_url('admin.php?page=theme-general-footer'),
			'parent'	=>	'theme-settings',
		));
		array_push($args,array(
			'id'		=>	'custom-settings',
			'title'		=>	esc_html__('Custom CSS', 'ohio'),
			'href'		=>	admin_url('admin.php?page=theme-general-custom'),
			'parent'	=>	'theme-settings',
		));
		array_push($args,array(
			'id'		=>	'other-settings',
			'title'		=>	esc_html__('Other Settings', 'ohio'),
			'href'		=>	admin_url('admin.php?page=theme-general-other'),
			'parent'	=>	'theme-settings',
		));
		array_push($args,array(
			'id'		=>	'help-settings',
			'title'		=>	esc_html__('Get Help', 'ohio'),
			'href'		=>	admin_url('admin.php?page=theme-general-support'),
			'parent'	=>	'theme-settings',
		));

		foreach( $args as $each_arg ) {
			$wp_admin_bar->add_node($each_arg);
		}
	}

    function add_custom_upload_mimes($existing_mimes) {
	    if ( function_exists( 'mime_content_type') ) {
            $existing_mimes['ttf'] = mime_content_type(plugin_dir_path(__FILE__) . 'etc/RobotoExample.ttf');
            $existing_mimes['otf'] = mime_content_type(plugin_dir_path(__FILE__) . 'etc/MontserratExample.otf');
        } else {
            $existing_mimes['ttf'] = 'application/x-font-ttf';
            $existing_mimes['otf'] = 'application/x-font-opentype';
        }
        $existing_mimes['woff'] = 'application/font-woff';
        $existing_mimes['woff2'] = 'application/font-woff2';

        return $existing_mimes;
    }
    add_filter( 'upload_mimes', 'add_custom_upload_mimes', 10, 1 );

} else {
	add_action( 'admin_notices', 'ohio_extra_admin_notice' );

	function ohio_extra_admin_notice() {
?>
	<div class="notice notice-error">
		<p>
			<strong><?php esc_html_e( '"Ohio Extra" plugin is not supported by this theme', 'ohio-extra' ); ?></strong>
			<br>
			<?php esc_html_e( 'Please use this plugin with Ohio theme, or deactivate it.', 'ohio' ); ?>
		</p>
	</div>
<?php
	}
}
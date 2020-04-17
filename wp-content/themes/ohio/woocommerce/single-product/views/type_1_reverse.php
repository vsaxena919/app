<?php
// GLOBALS
$shop_page_id = wc_get_page_id( 'shop' );
$show_breadcrumbs = OhioOptions::get( 'page_breadcrumbs_visibility', true );
$show_lightbox = OhioOptions::get_global( 'woocommerce_product_lightbox_preview' );

if ( $show_breadcrumbs ) {
    $category_in_breadcrumb = OhioOptions::get( 'page_show_category_breadcrumbs', true );
}

global $post;
global $product;
$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
	'woocommerce-product-gallery',
	'woocommerce-product-gallery--' . ( has_post_thumbnail() ? 'with-images' : 'without-images' ),
	'woocommerce-product-gallery--columns-' . absint( $columns ),
	'images',
) );

// SLIDER
function get_slides($size = 'shop_single') {
    global $post;
    global $product;
    $allowed_html = array(
        'div' => array(
            'class' =>true,
            'data-gallery-item'=>true,
            'data-lazy-item'=>true
        ),
        'i' => array(
            'class' =>true
        ),
        'img' => array(
            'class' => true,
            'src' => true,
            'alt'=> true
        )
    );
    $html = '<div class="image-wrap woocommerce-product-gallery__image gallery-image" style="position:relative"><img class="gimg wp-post-image" src="'.wp_get_attachment_image_url( $product->get_image_id(), $size ).'" alt="'.esc_attr($post->post_title).'"></div>';
    $attachment_ids = $product->get_gallery_image_ids();
    $image_class = '';
    $loop = 1;
    foreach ( $attachment_ids as $attachment_id ) {
        $classes = array( 'zoom' );
        $image_class = implode( ' ', $classes );
        $props       = wc_get_product_attachment_props( $attachment_id, $post );
        if ( ! $props['url'] ) {
            continue;
        }
        $html .= '<div class="image-wrap woocommerce-product-gallery__image gallery-image" style="position:relative"><img class="gimg" src="'.wp_get_attachment_image_url( $attachment_id, $size ).'" alt="'.esc_attr($post->post_title).'"></div>';
        $loop++;
    }
    echo wp_kses( $html, $allowed_html);
}
?>

<div class="page-container">

    <?php wc_get_template_part("single-product/sticky", "product") ?>
        <?php if ( $show_breadcrumbs ) : ?>
        <div class="breadcrumbs">
            <div class="breadcrumbs-inner">
                <a class="brand-color-hover" href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>">
                    <?php echo OhioSettings::breadcrumbs_woocommerce_slug(); ?>
                </a>
                <?php
                    $ancestors = get_ancestors( get_the_ID(), 'page', 'post_type' );
                    for( $i = count( $ancestors ) - 1; $i >= 0; $i-- ) {
                        $page = get_page( $ancestors[$i] );
                        printf( '<i class="ion ion-ios-arrow-forward"></i> <a class="brand-color-hover" href="%s">%s</a>', $page->guid, $page->post_title );
                    } ?>
                <?php
                if($category_in_breadcrumb) {
                    $terms = wp_get_post_terms( $post->ID, 'product_cat', array( 'taxonomy' => 'product_cat' ) );

                    if ( is_array( $terms ) && is_object( $terms[0] ) ) {
                        printf( '<i class="ion ion-ios-arrow-forward"></i> <a class="brand-color-hover hover-underline underline-brand" href="%s">%s</a>', get_term_link( $terms[0] ), $terms[0]->name );
                    }
                }
                ?>
                <i class="ion ion-ios-arrow-forward"></i> <span class="current"><?php the_title(); ?></span>
            </div>
        </div>
        <?php endif; ?>
    <div class="vc_row" id="scroll-product">
        <div class="vc_col-md-5 vc_col-sm-12 woo_c-product-details">
            <div class="summary entry-summary woo_c-product-details-inner" data-ohio-content-scroll='#scroll-product'>
                <div class="woo-summary-content">
                    <div class="wrap">
                        <?php
                        do_action( 'woocommerce_single_product_summary' );
                        ?>
                        </div>
                    </div>
                </div>
                <?php
                    $show_sharing = OhioOptions::get_global( 'woocommerce_sharing_visibility' );
                    if ( $show_sharing ) {
                        do_shortcode( '[ohio_share_woo]' );
                    } ?>
            </div>
        <div class="vc_col-md-7 vc_col-sm-12 woo_c-product-image">
            <div class="woo_c-product-image-slider ohio-gallery-sc gallery-wrap" data-gallery="ohio-custom-<?php echo esc_attr( $product->get_id()); ?>">
                <?php if ( has_post_thumbnail() ) { ?>
                    <div class="product_images <?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>">
                        <?php get_slides(); ?>
                    </div>
                    <?php
                } else {
                    echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), esc_html__( 'Placeholder', 'ohio' ) ), $post->ID );
                } ?>
                <?php wc_get_template_part('single-product/sale', 'stick'); ?>
                <?php if( $show_lightbox ): ?>
                    <div class="btn-lightbox btn-round btn-round-outline btn-round-small" data-gallery-item="0"><i class="ion ion-md-expand"></i></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="ohio-gallery-opened-sc clb-popup clb-gallery-lightbox" id="ohio-custom-<?php echo esc_attr( $product->get_id()); ?>">
        <div class="close close-bar">
            <div class="clb-close btn-round round-animation circle-animation" tabindex="0">
                <i class="ion ion-md-close"></i>
            </div>
            <div class="expand btn-round round-animation circle-animation" tabindex="0">
                <i class="ion ion-md-expand"></i>
            </div>
        </div>
        <div class="clb-popup-holder"></div>
    </div>
</div>
<?php
wc_get_template_part( 'single-product/tabs/tabs' );
woocommerce_upsell_display();
woocommerce_related_products( $product->get_id(), 4 );
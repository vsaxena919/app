<?php
$project = OhioHelper::get_storage_item_data();
$_project_uniqid = false;
if ($project['overlay'] && preg_match("/^\#[a-zA-Z0-9]{6}$/i", trim($project['overlay']))) {
    $_project_uniqid = uniqid('ohio_post_style_');
    $_overlay_color = OhioHelper::hex_to_rgba($project['overlay'], 0.5);
}

$wrap_classes = [];
if ( isset( $brand_classes ) ) extract( $brand_classes );
$css_class = '';

$wrap_classes[] = $css_class;
if ( isset( $background_class ) ) $wrap_classes[] = $background_class;
?>

<div class="portfolio-item portfolio-item-fullscreen portfolio-grid-type-6 parallax-holder <?php echo esc_attr( implode( ' ', $wrap_classes ) ); ?>"<?php if ($_project_uniqid) {
    echo ' id="' . esc_attr($_project_uniqid) . '"';
} ?><?php if ($project['in_popup']) {
    echo ' data-portfolio-popup="' . esc_attr($project['popup_id']) . '"';
} ?>>
    <div class="portfolio-item-image parallax" <?php echo ' data-ohio-bg-image="' . esc_url($project['featured_image']) . '"'; ?>></div>
    <div class="portfolio-item-overlay ">
        <div class="portfolio-details animated-holder">

            <?php if (isset($project['video']['link']) && !empty($project['video']['link'])) { ?>
                <div class="portfolio-details-video ohio-video-module-sc video-module open-popup"
                     data-video-module="<?php echo esc_url($project['video']['link']); ?>">
                    <div class="btn-play btn-round btn-round-outline btn-round-light" tabindex='1'>
                        <i class="ion ion-ios-play"></i>
                    </div>
                </div>
            <?php } ?>

            <?php if ($project['category_visible'] !== false) : ?>
                <?php if ($project['categories_plain']) : ?>
                    <div class="portfolio-details-categories">
                        <?php $categories = explode(', ', $project['categories_plain']) ?>
                            <div class="category-holder">
                            <?php foreach ($categories as $category) : ?>
                                <span class="category <?php if ( isset( $category_class ) ) echo esc_attr( $category_class ); ?>"><?php echo esc_html($category); ?></span>
                            <?php endforeach; ?>
                            </div>
                        <?php if ( OhioOptions::get_global( 'portfolio_date_visibility' ) ) : ?>
                            <span class="portfolio-details-date <?php if ( isset( $date_class ) ) echo esc_attr( $date_class ); ?>"><?php echo esc_html($project['date']) ?></span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="portfolio-details-title">
                <a href="<?php echo esc_url($project['url']); ?>"<?php if ($project['external']) {
                    echo ' target="_blank"';
                } ?>>
                    <h3 class="portfolio-details-headline title <?php if ( isset( $title_class ) ) echo esc_attr( $title_class ); ?>"><?php echo esc_html($project['title']); ?></h3>
                </a>
            </div>

            <?php if ( OhioOptions::get_global( 'portfolio_descr_visibility' ) ) : ?>
                <div class="portfolio-details-description">
                    <div class="short-description <?php if ( isset( $short_description_class ) ) echo esc_attr( $short_description_class ); ?>"><?php echo esc_html($project['short_description']); ?></div>
                </div>
            <?php endif; ?>

            <?php if ($project['more_visible'] !== false) : ?>
                <div class="portfolio-details-link">
                    <a class="btn btn-link <?php if( $project['in_popup'] ) echo 'btn-lightbox '; if ( isset( $more_class ) ) echo esc_attr( $more_class ); ?>" href="<?php echo esc_url($project['url']); ?>"<?php if ($project['external']) {
                        echo ' target="_blank"';
                    } ?>>
                        <?php esc_html_e('Show Project', 'ohio') ?>
                        <i class="ion-right ion"><svg class="arrow-icon" width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 7H16M16 7L11 1M16 7L11 13" stroke-width="2"/></svg></i>
                    </a>
                </div>
            <?php endif; ?>

        </div>
        <div class="portfolio-item-bg-title">
            <span class="bg-title"><?php echo esc_html($project['title']); ?></span>
        </div>
    </div>
</div>
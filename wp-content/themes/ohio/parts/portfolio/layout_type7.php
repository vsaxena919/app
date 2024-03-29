<?php
global $post;

# Project settings
$project = OhioObjectParser::parse_to_project_object($post);

if (is_array($project['images_full']) && count($project['images_full']) > 0) {
    $project['images'] = $project['images_full'];
}


# Header previous button
$previous_btn = OhioOptions::get_global( 'page_header_previous_button', true );
$previous_btn_text = OhioOptions::get( 'page_header_previous_button_text', esc_html__( 'Back', 'ohio' ), null, true );

# Slider options
$navBtn = OhioOptions::get( 'project_nav_visibility' );
$loop = OhioOptions::get( 'project_loop_mode' );
$autoplay = OhioOptions::get( 'project_autoplay_mode' );
$autoplayTimeout = OhioOptions::get( 'project_autoplay_interval', '', NULL, true );
$pagination = OhioOptions::get( 'project_bullets_visibility', true );

$slider_pagination_data = '';
if ($pagination) {
    $slider_pagination_type = OhioOptions::get( 'project_bullets_type');
    if ($slider_pagination_type == 'bullets') {
        $slider_pagination_data = 'data-slider-dots="true"';
    } else if ($slider_pagination_type == 'pagination') {
        $slider_pagination_data = 'data-slider-pagination="true"';
    }
}


# Page container settings
$show_breadcrumbs = OhioOptions::get( 'page_breadcrumbs_visibility', true );
$page_wrapped = OhioOptions::get( 'page_add_wrapper', true );
$add_content_padding = OhioOptions::get( 'page_add_top_padding', true );
$show_header_title = OhioOptions::get( 'page_header_title_visibility', true );

$page_container_class = '';
$custom_page_container_class = '';
if (!$show_breadcrumbs && $add_content_padding) {
    $page_container_class .= ' top-offset';
}
if (!$page_wrapped) {
    $page_container_class .= ' full';
    $custom_page_container_class .= ' full';
}
if ($add_content_padding) {
    $page_container_class .= ' bottom-offset';
}

if ($show_breadcrumbs) {
    get_template_part('parts/elements/breadcrumbs');
}

?>
<?php if ($project['custom_content_position'] == 'top') : ?>
    <div class="page-container <?php echo esc_attr($custom_page_container_class); ?>">
        <div class="project-page-custom-content">
            <?php echo do_shortcode(get_post_field('post_content', $post->ID)); ?>
        </div>
    </div>
<?php endif; ?>

<div class="project-page project layout-type7<?php echo esc_attr($page_container_class); ?>">
    <div class="page-container">
        <div class="project-page-content">
            <div class="vc_row">
                <div class="vc_col-md-5">
                    <?php if ( !$show_header_title ): ?>
                        <?php if ( $project['categories_plain'] ) : ?>
                            <div class="category-holder">
                                <?php $categories = explode( ', ', $project['categories_plain'] ) ?>
                                <?php foreach ( $categories as $category ) : ?>
                                    <span class="category"><?php echo esc_html( $category ); ?></span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( $project['date'] ) : ?>
                            <span class="date"><?php echo esc_html( $project['date'] ); ?></span>
                        <?php endif; ?>
                        <div class="project-title">
                            <?php the_title( '<h1 class="headline">', '</h1>'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="project-description">
                        <?php echo wp_kses( $project['description'], 'basic_html' ); ?>
                        <?php 
                            if ( $project['custom_content_position'] == 'after_description' ) {
                                echo do_shortcode( get_post_field( 'post_content', $post->ID ) );
                            }
                        ?>
                    </div>
                </div>
                <div class="vc_col-md-push-1 vc_col-md-6">
                    <?php if ( $project['task'] ) :?>
                        <div class="project-task">
                            <h6 class="heading-sm"><?php esc_html_e( 'Task', 'ohio' ); ?></h6>
                            <p class="project-task-description"><?php echo wp_kses( $project['task'], 'default' ); ?></p>
                        </div>
                    <?php endif; ?>
                    <ul class="project-meta">
                        <?php if ( $project['strategy'] ) : ?>
                            <li>
                                <h6 class="project-meta-title"><?php esc_html_e( 'Strategy', 'ohio' ); ?></h6>
                                <p><?php echo wp_kses( $project['strategy'], 'default' ); ?></p>
                            </li>
                        <?php endif; ?>

                        <?php if ( $project['design'] ) : ?>
                            <li>
                                <h6 class="project-meta-title"><?php esc_html_e( 'Design', 'ohio' ); ?></h6>
                                <p><?php echo wp_kses( $project['design'], 'default' ); ?></p>
                            </li>
                        <?php endif; ?>

                        <?php if ( $project['client'] ) : ?>
                            <li>
                                <h6 class="project-meta-title"><?php esc_html_e( 'Client', 'ohio' ); ?></h6>
                                <p><?php echo wp_kses( $project['client'], 'default' ); ?></p>
                            </li>
                        <?php endif; ?>

                        <?php if ( $project['custom_fields'] ) : ?>
                            <?php foreach ( $project['custom_fields'] as $custom_field ) : ?>
                            <li>
                                <h6 class="project-meta-title"><?php echo esc_html( $custom_field['title'] ); ?>:</h6>
                                <p><?php echo esc_html( $custom_field['value'] ); ?></p>
                            </li>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if ( $project['tags'] ) { ?>
                            <li>
                                <h6 class="project-meta-title"><?php esc_html_e( 'Tags', 'ohio' ); ?></h6>
                                <p><?php echo esc_html(implode(', ', $project['tags'])); ?></p>
                            </li>
                        <?php } ?>
                    </ul>

                    <?php if ( $project['link'] ) : ?>
                        <a href="<?php echo esc_url( $project['link'] ); ?>" class="btn btn-link" target="_blank">
                            <?php esc_html_e( 'Open Project', 'ohio' ); ?>
                            <i class="ion-right ion"><svg class="arrow-icon" width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 7H16M16 7L11 1M16 7L11 13" stroke-width="2"/></svg></i>
                        </a>
                    <?php endif; ?>
                </div> 
            </div>
        </div>
        <div class="project-page-media-holder">

            <?php if ( is_array( $project['images'] ) ) : ?>
                <?php foreach ( $project['images'] as $key => $art ) :
                    $alt = get_post_meta(OhioHelper::get_attachment_id($art), '_wp_attachment_image_alt', true);
                    ?>
                    <?php if ($key == 0 ) : ?>
                        <div class="project-first-image">
                            <img src="<?php echo esc_url( $art ); ?>" alt="<?php echo esc_attr($alt) ?>">
                            <?php if (isset($project['video']['link']) && !empty($project['video']['link'])) : ?>
                                <div class="ohio-video-module-sc video-module with-animation open-popup" data-video-module="<?php echo esc_url($project['video']['link']); ?>">
                                    <div class="btn-play btn-round" tabindex='1'>
                                        <i class="ion ion-ios-play"></i>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ( $project['show_sharing'] && $project['sharing_links'] && count( $project['sharing_links'] ) > 0 ) : ?>

                                <div class="clb-share-bar">
                                    <div class="socialbar flat">
                                        <?php vprintf('%s', $project['sharing_links_html']); ?>
                                    </div>  
                                </div>  

                            <?php endif; ?>
                        </div>
                        
                    <?php else:  ?>
                        <img src="<?php echo esc_url( $art ); ?>" alt="<?php echo esc_attr($alt) ?>">
                    <?php endif ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Custom WPBakery content -->
<?php if ($project['custom_content_position'] == 'bottom') : ?>
    <div class="page-container <?php echo esc_attr($custom_page_container_class); ?>">
        <div class="project-page-custom-content">
            <?php echo do_shortcode(get_post_field('post_content', $post->ID)); ?>
        </div>
    </div>
<?php endif; ?>

<!-- Back button -->
<?php if ( $previous_btn ): ?>
<div class="clb-back-link clb-back-link-project vc_hidden-xs">
    <a href="<?php echo wp_get_referer(); ?>" class="btn-round btn-round-light">
        <i class="ion-left ion"><svg class="arrow-icon arrow-icon-back" width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 7H16M16 7L11 1M16 7L11 13" stroke-width="2"/></svg></i>
    </a>
    <span class="clb-back-link-caption">
        <?php echo esc_html($previous_btn_text) ?>
    </span>
</div>
<?php endif; ?>

<!-- Next & Prev nav -->
<?php if ( $project['show_navigation'] ) {
    get_template_part('parts/elements/nav_projects');
}?>
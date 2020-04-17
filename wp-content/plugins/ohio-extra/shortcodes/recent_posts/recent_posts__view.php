<?php

/**
* WPBakery Page Builder Ohio Recent Posts shortcode view
*/

global $post;

?>

<?php 
	$asymmetric_atts = "";

	if ($asymmetric_parallax) {
		
		$_columns_in_row = (int) substr( $columns_in_row, 0, 1);
		$asymmetric_atts = ' data-asymmetric-parallax-grid=true data-grid-number='. $column_asymmetric_grid .' data-asymmetric-parallax-speed='. $asymmetric_parallax_speed . '';
	}

	$masonry_grid = $masonry_grid ? 'ohio-masonry' : '';
?>

<div class="ohio-recent-posts-sc vc_row blog-posts-masonry<?php echo esc_attr($css_class) ?> <?php echo esc_attr($masonry_grid) ?>"
	id="<?php echo esc_attr( $recent_posts_uniqid ); ?>"
	<?php if ( $appearance_effect != 'none' ) { echo ' data-aos="' . esc_attr( $appearance_effect ) . '"'; } ?> 
	<?php if ( $appearance_duration ) { echo ' data-aos-duration="' . esc_attr( $appearance_duration ) . '"'; } ?>
	<?php if ( $appearance_delay ) echo ' data-aos-delay="' . $appearance_delay . '"'; ?>
	<?php echo esc_attr($asymmetric_atts);?>
	data-lazy-container="posts">
	<?php

		$pagination_page = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		$items_per_page = intval( $pagination_items_per_page );

		// Calculate pagination
		$_post_start = 0;
		$_post_end = count( $posts_data );

		if ( $use_pagination ) {
			$_post_start = $pagination_page * $items_per_page - $items_per_page;

			if ( $_post_end > $_post_start + $items_per_page ) {
				$_post_end = $_post_start + $items_per_page;
			}
		}

		for ( $_post_i = $_post_start; $_post_i < $_post_end; $_post_i++ ) {
			$_post_object = $posts_data[ $_post_i ];

			setup_postdata($_post_object);
			$post = $_post_object;
			$post->image_size = $blog_images_size;

			$ohio_post = OhioObjectParser::parse_to_post_object( $_post_object, 'recent_posts', $_post_i + 1 );
			$ohio_post['boxed'] = $card_boxed;
			$ohio_post['hover_effect'] = $hover_effect;
			$ohio_post['metro_style'] = $metro_style;
			$ohio_post['meta_visibility'] =  array(
				'author_visibility' => true,
				'category_visibility' =>  true,
				'short_description_visibility' => $short_description,
				'read_more_visibility' => true,
				'reading_time_visibility' => true
			);
			// $ohio_post['grid_card_striped'] = $card_striped;
			// $ohio_post['grid_card_indented'] = $card_indented;

			OhioHelper::set_storage_item_data( $ohio_post );
			$col_class = $column_class;
			if ( $ohio_post['grid_style'] == '2col' ) {
				$col_class = $column_double_class;
			}
			// Animation calculating
			$_anim_attrs = '';
			if ( in_array( $animation_type, array( 'sync', 'async' ) ) ) {
				OhioHelper::add_required_script( 'aos' );

				$_anim_attrs .= ' data-aos-once="true"';
				$_anim_attrs .= ' data-aos="' . $animation_effect . '"';
				if ( $animation_type == 'async' ) {
					$_columns_in_row = (int) substr( $columns_in_row, 0, 1);
					$_delay = ( 400 / $_columns_in_row ) * ( $_post_i % $_columns_in_row );
					$_delay = (int) $_delay - ( $_delay % 50 );
					$_anim_attrs .= ' data-aos-delay="' . $_delay . '"';
				}
			}
			echo '<div class="' . $col_class . ' blog-post-masonry masonry-block post-offset ohio-card-wrapper' . (( $ohio_post['grid_style'] != '2col' ) ? ' grid-item' : '') . '" data-lazy-item="" data-lazy-scope="posts">';

			if ( $_anim_attrs ) {
				echo '<div ' . $_anim_attrs . '>';
			}

			switch ( $card_layout ) {
				case 'blog_grid_1':
					get_template_part( 'parts/blog_grid/layout_type1' );
					break;
				case 'blog_grid_2':
					get_template_part( 'parts/blog_grid/layout_type2' );
					break;
				case 'blog_grid_3':
					get_template_part( 'parts/blog_grid/layout_type3' );
					break;
				case 'blog_grid_4':
					get_template_part( 'parts/blog_grid/layout_type4' );
					break;
				case 'blog_grid_5':
					get_template_part( 'parts/blog_grid/layout_type5' );
					break;
				default:
					get_template_part( 'parts/blog_grid/layout_type1' );
					break;
			}

			if ( $_anim_attrs ) {
				echo '</div>';
			}
			echo '</div>';
		}

		wp_reset_postdata();
	?>
</div>

<?php 
	if ( $use_pagination ) {

		echo '<div class="vc_col-lg-12">';

			$pages_count = ceil( count( $posts_data ) / $items_per_page );
			$large_number = 10000000;
			$paginator_pattern = str_replace( $large_number, '{{page}}', get_pagenum_link( $large_number ) );

			if ( $pagination_type == 'simple' ) {

				OhioLayout::the_paginator_layout( $pagination_page, $pages_count, $pagination_position );

			} else if ( $pagination_type == 'standard' ) {

				echo '<div class="pagination-standard">';
				OhioLayout::the_paginator_layout( $pagination_page, $pages_count, $pagination_position );
				echo '</div>';

			} else if ( $pagination_type == 'lazy_scroll' ) {

				$position = 'text-' . $pagination_position;

				echo '<div class="lazy-load loading font-titles ' . $position . ' " data-lazy-load="scroll" ';
					echo 'data-lazy-pages-count="' . esc_attr( $pages_count ) . '" ';
					echo 'data-lazy-load-url-pattern="' . esc_attr( $paginator_pattern ) . '" ';
					echo 'data-lazy-load-scope="posts">';
				echo '<span class="btn-round btn-round-light" tabindex="0"><i class="ion ion-md-sync"></i></span>';
				echo '<span class="loading-text">' . esc_html__( 'Loading', 'ohio-extra' ) . '</span>';
				echo '</div>';

			}  else if ( $pagination_type == 'lazy_button' ) {

				$position = 'text-' . $pagination_position;

				echo '<div class="lazy-load load-more font-titles ' . $position . ' " data-lazy-load="click" ';
					echo 'data-lazy-pages-count="' . esc_attr( $pages_count ) . '" ';
					echo 'data-lazy-load-url-pattern="' . esc_attr( $paginator_pattern ) . '" ';
					echo 'data-lazy-load-scope="posts">';
				echo '<span class="btn-round btn-round-light" tabindex="0"><i class="ion ion-md-sync"></i></span>';
				echo '<span class="loadmore-text">' . esc_html__( 'Load More', 'ohio-extra' ) . '</span>';
				echo '<span class="loading-text">' . esc_html__( 'Loading', 'ohio-extra' ) . '</span>';
				echo '</div>';

			}

		echo '</div>';

	}
?>
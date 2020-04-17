<?php OhioHelper::add_required_script( 'isotope' ); ?>

<?php 
	$grid_attr = '';				
	if ( $card_layout == 'grid_8' ) {
		$grid_attr .= "data-interactive-links-grid=true";
	}
?>
<div data-ohio-portfolio-grid="true" id="<?php echo $recent_projects_uniqid; ?>" class="ohio-recent-projects-sc"
	<?php if ( $appearance_effect != 'none' ) { echo ' data-aos="' . $appearance_effect . '"'; } ?>
	<?php if ( $appearance_duration ) { echo ' data-aos-duration="' . intval( $appearance_duration ) . '"'; } ?>
	<?php if ( $appearance_delay ) echo ' data-aos-delay="' . $appearance_delay . '"'; ?>
	<?php echo esc_attr($grid_attr); ?>>

	<?php if ( $card_layout == 'grid_8' ): ?>
		<div class="portfolio-grid-images portfolio-grid8-images interactive-links-grid-images" data-vc-full-width="true" data-vc-stretch-content="true" >
		</div>
	<?php endif; ?>

	<?php if ( $show_projects_filter ) : ?>
		<?php
			if ( is_array( $projects_category ) ) {
				if ( is_string( $projects_category[0] ) ) {
					$cat_ids = get_terms( array( 'taxonomy' => 'ohio_portfolio_category', 'slug' => $projects_category ) );
				} else {
					$cat_ids = get_terms( array( 'taxonomy' => 'ohio_portfolio_category', 'include' => $projects_category ) );
				}
			} else {
				$cat_ids = get_terms( array( 'taxonomy' => 'ohio_portfolio_category' ) );
			}
			if ( is_array( $cat_ids ) && $cat_ids ) :
		?>
		<div class="portfolio-sorting<?php echo esc_attr( $filter_align_class ); ?>" data-filter="portfolio">
			<ul class="unstyled">
				<li><?php esc_html_e( 'Filter by', 'ohio' ) ?></li>
				<li>
                    <a class="active" href="#all" data-isotope-filter="*">
                        <span class="name"><?php esc_html_e( 'All', 'ohio' ); ?></span>
                        <span class="num"></span>
                    </a>
                </li>
				<?php foreach ( $cat_ids as $cat_obj ) : ?>
					<li> /
						<a href="#<?php echo esc_attr( $cat_obj->slug ); ?>" data-isotope-filter=".ohio-filter-project-<?php echo hash( 'md4', $cat_obj->slug, false ); ?>">
							<span class="name"><?php echo esc_html( $cat_obj->name ); ?></span>
							<span class="num"></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>


		<?php endif; ?>
	<?php endif; ?>

	<?php
		$items_per_page = intval( $pagination_items_per_page );

		$asymmetric_atts = "";
		$_columns_in_row = (int) substr( $columns_in_row, 0, 1 );
		
		if ($asymmetric_parallax) {
			$asymmetric_atts = ' data-asymmetric-parallax-grid=true data-grid-number='. $column_asymmetric_grid .' data-asymmetric-parallax-speed='. $asymmetric_parallax_speed. '';
		}
	?>
	<?php if( !$is_slider ) : ?>

		<div class="vc_row <?php echo implode( ' ', $wrap_classes ) ?> portfolio-grid" data-isotope-grid="true" data-lazy-container="projects" <?php echo esc_attr($asymmetric_atts); ?>>

			<?php
				$_post_start = 0;
				$_post_end = count( $projects_data );
				$_prev_item_featured_image = '';
			?>

			<?php for ( $_post_i = $_post_start; $_post_i < $_post_end; $_post_i++ ) : ?>
			<?php
				$_project_object = $projects_data[$_post_i];
				$_project_object->image_size = $portfolio_images_size;
				$ohio_project = OhioObjectParser::parse_to_project_object( $_project_object );
				$ohio_project['metro_style'] = $metro_style;
				$ohio_project['in_popup'] = $lightbox_visibility;
				if ($_post_i == 0) {
					$_last_project = OhioObjectParser::parse_to_project_object( $projects_data[$_post_end - 1] );
					$ohio_project['prev_item_featured_image'] = $_last_project['featured_image'];
				} else {
					$ohio_project['prev_item_featured_image'] = $_prev_item_featured_image;
				}
				$_prev_item_featured_image = $ohio_project['featured_image'];
				if ( $card_layout == 'grid_1' || $card_layout == 'grid_2' || $card_layout == 'grid_11'){
					$ohio_project['boxed'] = $boxed_classes;
					$ohio_project['hover_effect'] = $hover_effect;
				}
				OhioHelper::set_storage_item_data( $ohio_project );
				$col_class = '';
				if ($card_layout != 'grid_8') {
					$col_class = $column_class;
					if ( $ohio_project['grid_style'] == '2col') {
						$col_class = $column_double_class;
						$col_class .= ' double-width';
					}
				}

				// Animation calculating
				$_anim_attrs = '';
				if ( in_array( $animation_type, array( 'sync', 'async' ) ) ) {
					OhioHelper::add_required_script( 'aos' );

					$_anim_attrs .= ' data-aos-once="true"';
					$_anim_attrs .= ' data-aos="' . $animation_effect . '"';
					if ( $animation_type == 'async' ) {
						$_columns_in_row = (int) substr( $columns_in_row, 0, 1 );
						if ( $columns_in_row <= 0 ) { $columns_in_row = 1; }
						$_delay = ( 400 / $_columns_in_row ) * ( $_post_i % $_columns_in_row );
						$_delay = (int) $_delay - ( $_delay % 50 );
						$_anim_attrs .= ' data-aos-delay="' . $_delay . '"';
					}
				}
				echo '<div class="portfolio-item-wrap masonry-block' . ' grid-item' . $col_class . ( ( $projects_solid ) ? ' post-offset' : '' ) . ' ohio-project-item ' . $ohio_project['categories_group'] . '" data-lazy-item="" data-lazy-scope="projects">';

				if ( $_anim_attrs ) {
					echo '<div' . $_anim_attrs . '>';
				}

				switch ( $card_layout ) {
					case 'grid_1':
						include( locate_template( 'parts/portfolio_grid/portfolio_layout_type_1.php' ) );
						break;
					case 'grid_2':
						include( locate_template( 'parts/portfolio_grid/portfolio_layout_type_2.php' ) );
						break;
					case 'grid_3':
						include( locate_template( 'parts/portfolio_grid/portfolio_layout_type_3.php' ) );
						break;
					case 'grid_4':
						include( locate_template( 'parts/portfolio_grid/portfolio_layout_type_4.php' ) );
						break;
					case 'grid_5':
						include( locate_template( 'parts/portfolio_grid/portfolio_layout_type_5.php' ) );
						break;
					case 'grid_6':
						include( locate_template( 'parts/portfolio_grid/portfolio_layout_type_6.php' ) );
						break;
					case 'grid_7':
						include( locate_template( 'parts/portfolio_grid/portfolio_layout_type_7.php' ) );
						break;
					case 'grid_8':
						include( locate_template( 'parts/portfolio_grid/portfolio_layout_type_8.php' ) );
						break;
					case 'grid_9':
						include( locate_template( 'parts/portfolio_grid/portfolio_layout_type_9.php' ) );
						break;
					case 'grid_10':
						include( locate_template( 'parts/portfolio_grid/portfolio_layout_type_10.php' ) );
						break;
					case 'grid_11':
						include( locate_template( 'parts/portfolio_grid/portfolio_layout_type_11.php' ) );
						break;
					default:
						include( locate_template( 'parts/portfolio_grid/portfolio_layout_type_1.php' ) );
						break;
				}

				if ( $_anim_attrs ) {
					echo '</div>';
				}
				if ( $lightbox_visibility ) {
					//temporary
					$ohio_project['show_view_link_in_popup'] = true;
					ob_start();
					OhioHelper::set_storage_item_data( $ohio_project );
					include( locate_template( 'parts/portfolio_grid/lightbox.php' ) );
					OhioLayout::append_to_footer_buffer_content( ob_get_clean() );
				}

			?>
			</div>
		<?php endfor; ?>
		</div>
	<?php else : ?>
		<div class="vc_row wpb_row vc_row-fluid vc_row-no-padding portfolio-onepage-slider clb-slider-scroll-bar <?php echo esc_attr($card_layout); ?> <?php echo esc_attr($fullscreen_classes); ?>" data-portfolio-grid-slider data-vc-full-width="true" data-vc-stretch-content="true" data-slider-navigation="<?php echo $navBtn; ?>" data-slider-pagination="<?php echo $pagination; ?>" data-slider-loop="<?php echo $loop; ?>" data-slider-mousescroll="<?php echo $mousewheel; ?>" data-slider-autoplay="<?php echo $autoplay_mode; ?>" data-slider-autoplay-time="<?php echo $autoplay_interval; ?>">
			<?php
				foreach ( $projects_data as $_project_index => $_project_object ) {
					$ohio_project = OhioObjectParser::parse_to_project_object( $_project_object );
					$ohio_project['in_popup'] = $lightbox_visibility;
					OhioHelper::set_storage_item_data( $ohio_project );
				
					switch ( $card_layout ) {
						case 'grid_3':
							include( locate_template( 'parts/portfolio_grid/portfolio_layout_type_3.php' ) );
							break;
						case 'grid_4':
							include( locate_template( 'parts/portfolio_grid/portfolio_layout_type_4.php' ) );
							break;
						case 'grid_5':
							include( locate_template( 'parts/portfolio_grid/portfolio_layout_type_5.php' ) );
							break;
						case 'grid_6':
							include( locate_template( 'parts/portfolio_grid/portfolio_layout_type_6.php' ) );
							break;
						case 'grid_7':
							include( locate_template( 'parts/portfolio_grid/portfolio_layout_type_7.php' ) );
							break;
						case 'grid_8':
							include( locate_template( 'parts/portfolio_grid/portfolio_layout_type_8.php' ) );
							break;
						case 'grid_9':
							include( locate_template( 'parts/portfolio_grid/portfolio_layout_type_9.php' ) );
							break;
						case 'grid_10':
							include( locate_template( 'parts/portfolio_grid/portfolio_layout_type_10.php' ) );
							break;
						default:
							include( locate_template( 'parts/portfolio_grid/portfolio_layout_type_3.php' ) );
							break;
					}

					if ( $lightbox_visibility ) {
						//temporary
						$ohio_project['show_view_link_in_popup'] = true;
						ob_start();
						OhioHelper::set_storage_item_data( $ohio_project );
						include( locate_template( 'parts/portfolio_grid/lightbox.php' ) );
						OhioLayout::append_to_footer_buffer_content( ob_get_clean() );
					}
				}
			?>
		</div>
	<?php endif; ?>

	<?php 
		if ( $use_pagination ) {

			$large_number = 10000000;
			$paginator_pattern = str_replace( $large_number, '{{page}}', get_pagenum_link( $large_number ) );
 
			if ( $pagination_type == 'simple' ) {

				OhioLayout::the_paginator_layout( $paged, $query->max_num_pages, $pagination_position );

			} else if ( $pagination_type == 'standard' ) {

				echo '<div class="pagination-standard">';
				OhioLayout::the_paginator_layout( $paged, $query->max_num_pages, $pagination_position );
				echo '</div>';

			} else if ( $pagination_type == 'lazy_scroll' ) {

				echo '<div class="lazy-load loading font-titles text-' . $pagination_position . '" data-lazy-load="scroll" ';
					echo 'data-lazy-pages-count="' . esc_attr( $query->max_num_pages ) . '" ';
					echo 'data-lazy-load-url-pattern="' . esc_attr( $paginator_pattern ) . '" ';
					echo 'data-lazy-load-scope="projects">';
				echo '<span class="btn-round btn-round-light" tabindex="0"><i class="ion ion-md-sync"></i></span>';
				echo '<span class="loading-text">' . esc_html__( 'Loading', 'ohio-extra' ) . '</span>';
				echo '</div>';

			}  else if ( $pagination_type == 'lazy_button' ) {

				echo '<div class="lazy-load load-more font-titles text-' . $pagination_position . '" data-lazy-load="click" ';
					echo 'data-lazy-pages-count="' . esc_attr( $query->max_num_pages ) . '" ';
					echo 'data-lazy-load-url-pattern="' . esc_attr( $paginator_pattern ) . '" ';
					echo 'data-lazy-load-scope="projects">';
				echo '<span class="btn-round btn-round-light" tabindex="0"><i class="ion ion-md-sync"></i></span>';
				echo '<span class="loadmore-text">' . esc_html__( 'Load More', 'ohio-extra' ) . '</span>';
				echo '<span class="loading-text">' . esc_html__( 'Loading', 'ohio-extra' ) . '</span>';
				echo '</div>';

			}
		}
	?>
</div>

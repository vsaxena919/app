		</div><!-- #content -->
		<?php get_template_part( 'parts/elements/footer' ); ?>
	</div><!-- #page -->

	<?php get_template_part('parts/elements/notification'); ?>

	<?php if ( OhioOptions::get( 'page_header_menu_style', 'style1' ) == 'style6' ) : ?>
	</div><!--.content-right-->
	<?php endif; ?>

	<?php if ( OhioOptions::get( 'page_use_boxed_wrapper', false ) ) : ?>
	</div> <!-- .boxed-container -->
	<?php endif; ?>

	<div class="clb-popup container-loading custom-popup">
		<div class="close-bar">
			<div class="btn-round clb-close" tabindex="0">
				<i class="ion ion-md-close"></i>
			</div>
		</div>
		<div class="clb-popup-holder">
			
		</div>
	</div>

	<?php
		$search_position = OhioOptions::get( 'page_header_search_position', 'standard' );
	?>
	
	<!-- Search -->
	<?php if ( $search_position == "fixed" ) : ?>
		<?php get_template_part( 'parts/elements/search' );?>
	<?php endif; ?>

	<?php
		// Some dynamic code place: popups, client JS, snippets...
		OhioLayout::get_footer_buffer_content( true );

		OhioBuffer::stop_content_bufferization();
		// Include collected dynamic CSS to head
		OhioLayout::show_shortcodes_inline_css();
		// Return the rest of page code
		OhioBuffer::get_content_buffer();

		wp_footer();
	?>
	</body>
</html>

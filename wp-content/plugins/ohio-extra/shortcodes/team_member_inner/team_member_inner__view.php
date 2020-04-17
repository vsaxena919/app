<?php

/**
* WPBakery Page Builder Ohio Team Members Group Inner shortcode view
*/

?>
<div id="<?php echo esc_attr( $team_member_uniqid ); ?>" 
	class="cover-content<?php echo $css_class; ?>" 
	data-item="true">

	<div class="center-aligned">
		<div class="team-member_wrap">
			<h5 class="team-member_title"><?php echo $name; ?></h5>
			<p class="team-member_subtitle"><?php echo $position; ?></p>
			<p class="team-member_description"><?php echo $description; ?></p>

			<?php if ( $social_bar ) : ?>
			<div class="socialbar small outline">
				<?php if ( $facebook_link ) : ?>
					<a href="<?php echo esc_url( $facebook_link ); ?>" class="facebook"><span class="icon fa fa-facebook-f"></span></a>
				<?php endif; ?>
				<?php if ( $twitter_link ) : ?>
					<a href="<?php echo esc_url( $twitter_link ); ?>" class="twitter"><span class="icon fa fa-twitter"></span></a>
				<?php endif; ?>
				<?php if ( $dribbble_link ) : ?>
					<a href="<?php echo esc_url( $dribbble_link ); ?>" class="dribbble"><span class="icon fa fa-dribbble"></span></a>
				<?php endif; ?>
				<?php if ( $pinterest_link ) : ?>
					<a href="<?php echo esc_url( $pinterest_link ); ?>" class="pinterest"><span class="icon fa fa-pinterest-p"></span></a>
				<?php endif; ?>
				<?php if ( $github_link ) : ?>
					<a href="<?php echo esc_url( $github_link ); ?>" class="github"><span class="icon fa fa-github"></span></a>
				<?php endif; ?>
				<?php if ( $instagram_link ) : ?>
					<a href="<?php echo esc_url( $instagram_link ); ?>" class="instagram"><span class="icon fa fa-instagram"></span></a>
				<?php endif; ?>
				<?php if ( $linkedin_link ) : ?>
					<a href="<?php echo esc_url( $linkedin_link ); ?>" class="linkedin"><span class="icon fa fa-linkedin"></span></a>
				<?php endif; ?>
				<?php if ( $vk_link ) : ?>
					<a href="<?php echo esc_url( $vk_link ); ?>" class="vk"><span class="icon fa fa-vk"></span></a>
				<?php endif; ?>	
			</div>
			<?php endif; ?>
		</div>
	</div>

</div>

<div class="team-member_image vc_col-sm-3" data-trigger="true">
	<div class="vc_row">
		<?php if ( $photo ) : ?>
		<img src="<?php echo $photo; ?>" alt="<?php echo esc_attr( $name ); ?>">
		<?php endif; ?>
	</div>
</div>
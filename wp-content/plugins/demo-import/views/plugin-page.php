<?php
/**
 * The plugin page view - the "settings" page of the plugin.
 *
 * @package ocdi
 */

namespace OCDI;

?>

<div class="wrap ocdi">

	<h1 class="ocdi__title wp-heading-inline"><?php esc_html_e( 'Import Demo Data', 'pt-ocdi' ); ?></h1>

	<?php

	// Display warrning if PHP safe mode is enabled, since we wont be able to change the max_execution_time.
	if ( ini_get( 'safe_mode' ) ) {
		printf(
			esc_html__( '%sWarning: your server is using %sPHP safe mode%s. This means that you might experience server timeout errors.%s', 'pt-ocdi' ),
			'<div class="notice  notice-warning  is-dismissible"><p>',
			'<strong>',
			'</strong>',
			'</p></div>'
		);
	}

	// Start output buffer for displaying the plugin intro text.
	ob_start();
	?>

	<div class="ocdi__intro-notice  notice  notice-warning  is-dismissible">
		<p><?php esc_html_e( 'Before you begin, make sure all the required plugins are activated.', 'pt-ocdi' ); ?></p>
	</div>

	<div class="ocdi-intro">

		<!-- OCDI Block -->
			<div class="ocdi-block ocdi-card">
				<div class="ocdi-block-header">
					<div class="ocdi-block-title">
						<h2>Getting Started with Demo Import</h2>
						<p>When you import the demo data, the following things might happen:</p>
					</div>
					<div class="ocdi-block-flex-button">
						<a target="_blank" href="https://docs.clbthemes.com/ohio/getting-started/#setting_up" class="button">View Docs</a>
					</div>
				</div>
				<div class="ocdi-block-section">
					<ul>
						<li><span class="mark"><i class="dashicons dashicons-yes"></i></span><?php esc_html_e( 'No existing posts, pages, categories, images, custom post types or any other data will be deleted or modified.', 'pt-ocdi' ); ?></li>
						<li><span class="mark"><i class="dashicons dashicons-yes"></i></span><?php esc_html_e( 'Posts, pages, images, widgets, menus and other theme settings will get imported.', 'pt-ocdi' ); ?></li>
						<li><span class="mark"><i class="dashicons dashicons-yes"></i></span><?php esc_html_e( 'All the global Theme Settings options will be overridden with each new demo import.', 'pt-ocdi' ); ?></li>
					</ul>
				</div>
			</div>

			<!-- OCDI Block -->
			<div class="ocdi-block ocdi-card warning">
				<div class="ocdi-block-header">
					<div class="ocdi-block-title">
						<h2><i class="dashicons dashicons-admin-site-alt3"></i> System Status</h2>
						<p>Contact your hosting provider and ask them to increase the limits to a minimum of the following:</p>
					</div>
					<div class="ocdi-block-flex-button">
						<a target="_blank" href="https://docs.clbthemes.com/ohio/getting-started/#requirements" class="button">View Docs</a>
					</div>
				</div>
				<div class="ocdi-block-section">
					<ul>
						<table class="ocdi-system-status">
							<tr class="table-heading">
								<td style="width: 50%;">Directive</td>
								<td>Suggested value</td>
								<td>Current value</td>
							</tr>

							<?php
								$ini_info = [
									[
                                        'info' => 'PHP time limit <span>(max_execution_time)</span>:',
                                        'recommended' => 120,
                                        'current' => ini_get( 'max_execution_time' ),
                                        'type' => 'int'
                                    ],
									[
                                        'info' => 'PHP memory limit <span>(memory_limit)</span>:',
                                        'recommended' => '350M',
                                        'current' => ini_get( 'memory_limit' ),
                                        'type' => 'int'
                                    ],
                                    [
                                        'info' => 'Max upload size <span>(upload_max_filesize)</span>:',
                                        'recommended' => '16M',
                                        'current' => ini_get( 'upload_max_filesize' ),
                                        'type' => 'int'
                                    ],
                                    [
                                        'info' => 'File upload permission <span>(file_uploads)</span>:',
                                        'recommended' => 'On',
                                        'current' => is_numeric(ini_get('file_uploads')) ? (ini_get('file_uploads') ? 'On' : 'Off') : ini_get('file_uploads'),
                                        'type' => 'bool'
                                    ],
								];
							?>
							<?php foreach($ini_info as $info_item): ?>
							<tr class="value">
								<td><?php echo $info_item['info']; ?></td>
								<td><?php echo $info_item['recommended']; ?></td>
								<td
                                    <?php if ( $info_item['type'] == 'int' && intval($info_item['recommended']) > intval($info_item['current']) ) { echo 'class="ini-warning"'; } ?>
                                    <?php if ( $info_item['type'] == 'bool' && $info_item['recommended'] != $info_item['current'] ) { echo 'class="ini-warning"'; } ?>>

									<i class="dashicons dashicons-yes"></i>
									<i class="dashicons dashicons-warning"></i> 
									<?php echo $info_item['current']; ?>
								</td>
							</tr>
							<?php endforeach; ?>

                            <?php if (!class_exists('XMLReader')): ?>
                                <tr class="value">
                                    <td>
                                        XML reader <span>(XML PHP extension)</span>:
                                    </td>
                                    <td>Installed XML extension</td>
                                    <td class="ini-warning ini-error">
                                        <i class="dashicons dashicons-warning"></i>
                                        XMLReader not found
                                    </td>
                                </tr>
                            <?php endif; ?>


						</table>
					</ul>
				</div>
			</div>

			
	</div>

	<?php
	$plugin_intro_text = ob_get_clean();

	// Display the plugin intro text (can be replaced with custom text through the filter below).
	echo wp_kses_post( apply_filters( 'pt-ocdi/plugin_intro_text', $plugin_intro_text ) );
	?>


	<?php if ( empty( $this->import_files ) ) : ?>

		<div class="notice  notice-info  is-dismissible">
			<p><?php esc_html_e( 'There are no predefined import files available in this theme. Please upload the import files manually!', 'pt-ocdi' ); ?></p>
		</div>

		<div class="ocdi__file-upload-container">
			<h2><?php esc_html_e( 'Manual demo files upload', 'pt-ocdi' ); ?></h2>

			<div class="ocdi__file-upload">
				<h3><label for="content-file-upload"><?php esc_html_e( 'Choose a XML file for content import:', 'pt-ocdi' ); ?></label></h3>
				<input id="ocdi__content-file-upload" type="file" name="content-file-upload">
			</div>

			<div class="ocdi__file-upload">
				<h3><label for="widget-file-upload"><?php esc_html_e( 'Choose a WIE or JSON file for widget import:', 'pt-ocdi' ); ?></label> <span><?php esc_html_e( '(*optional)', 'pt-ocdi' ); ?></span></h3>
				<input id="ocdi__widget-file-upload" type="file" name="widget-file-upload">
			</div>

			<div class="ocdi__file-upload">
				<h3><label for="customizer-file-upload"><?php esc_html_e( 'Choose a DAT file for customizer import:', 'pt-ocdi' ); ?></label> <span><?php esc_html_e( '(*optional)', 'pt-ocdi' ); ?></span></h3>
				<input id="ocdi__customizer-file-upload" type="file" name="customizer-file-upload">
			</div>

			<?php if ( class_exists( 'ReduxFramework' ) ) : ?>
			<div class="ocdi__file-upload">
				<h3><label for="redux-file-upload"><?php esc_html_e( 'Choose a JSON file for Redux import:', 'pt-ocdi' ); ?></label> <span><?php esc_html_e( '(*optional)', 'pt-ocdi' ); ?></span></h3>
				<input id="ocdi__redux-file-upload" type="file" name="redux-file-upload">
				<div>
					<label for="redux-option-name" class="ocdi__redux-option-name-label"><?php esc_html_e( 'Enter the Redux option name:', 'pt-ocdi' ); ?></label>
					<input id="ocdi__redux-option-name" type="text" name="redux-option-name">
				</div>
			</div>
			<?php endif; ?>
		</div>

		<p class="ocdi__button-container">
			<button class="ocdi__button  button  button-hero  button-primary  js-ocdi-import-data"><?php esc_html_e( 'Import Demo Data', 'pt-ocdi' ); ?></button>
		</p>

	<?php elseif ( 1 === count( $this->import_files ) ) : ?>

		<div class="ocdi__demo-import-notice  js-ocdi-demo-import-notice"><?php
			if ( is_array( $this->import_files ) && ! empty( $this->import_files[0]['import_notice'] ) ) {
				echo wp_kses_post( $this->import_files[0]['import_notice'] );
			}
		?></div>

		<p class="ocdi__button-container">
			<button class="ocdi__button  button  button-hero  button-primary  js-ocdi-import-data"><?php esc_html_e( 'Import Demo Data', 'pt-ocdi' ); ?></button>
		</p>

	<?php else : ?>

		<!-- OCDI grid layout -->
		<div class="ocdi__gl  js-ocdi-gl">
		<?php
			// Prepare navigation data.
			$categories = Helpers::get_all_demo_import_categories( $this->import_files );
		?>
			<?php if ( ! empty( $categories ) ) : ?>
				<div class="ocdi__gl-header  js-ocdi-gl-header">
					<nav class="ocdi__gl-navigation">
						<ul>
							<li class="active"><a href="#all" class="ocdi__gl-navigation-link  js-ocdi-nav-link"><?php esc_html_e( 'All', 'pt-ocdi' ); ?></a></li>
							<?php foreach ( $categories as $key => $name ) : ?>
								<li><a href="#<?php echo esc_attr( $key ); ?>" class="ocdi__gl-navigation-link  js-ocdi-nav-link"><?php echo esc_html( $name ); ?></a></li>
							<?php endforeach; ?>
						</ul>
					</nav>
					<div clas="ocdi__gl-search">
						<input type="search" class="ocdi__gl-search-input  js-ocdi-gl-search" name="ocdi-gl-search" value="" placeholder="<?php esc_html_e( 'Search demos...', 'pt-ocdi' ); ?>">
					</div>
				</div>
			<?php endif; ?>
			<div class="ocdi__gl-item-container  wp-clearfix  js-ocdi-gl-item-container">
				<?php foreach ( $this->import_files as $index => $import_file ) : ?>
					<?php
						// Prepare import item display data.
						$img_src = isset( $import_file['import_preview_image_url'] ) ? $import_file['import_preview_image_url'] : '';
						// Default to the theme screenshot, if a custom preview image is not defined.
						if ( empty( $img_src ) ) {
							$theme = wp_get_theme();
							$img_src = $theme->get_screenshot();
						}

					?>
					<div class="ocdi__gl-item js-ocdi-gl-item ocdi-card" data-categories="<?php echo esc_attr( Helpers::get_demo_import_item_categories( $import_file ) ); ?>" data-name="<?php echo esc_attr( strtolower( $import_file['import_file_name'] ) ); ?>">
						<div class="ocdi__gl-item-image-container">
							<?php if ( ! empty( $img_src ) ) : ?>
								<img class="ocdi__gl-item-image" src="<?php echo esc_url( $img_src ) ?>">
							<?php else : ?>
								<div class="ocdi__gl-item-image  ocdi__gl-item-image--no-image"><?php esc_html_e( 'No preview image.', 'pt-ocdi' ); ?></div>
							<?php endif; ?>
						</div>
						<div class="ocdi__gl-item-footer">
							<h4 class="ocdi__gl-item-title"><?php echo $import_file['import_file_name']; ?></h4>

							<?php if (!empty($import_file['preview_url'])): ?>
							<a
								href="<?php echo esc_url($import_file['preview_url']); ?>"
								class="ocdi__gl-item-button button button-secondary"
								target="_blank" style="margin-left:auto; margin-right:8px;">Preview</a>
							<?php endif; ?>

							<button class="ocdi__gl-item-button  button  button-primary  js-ocdi-gl-import-data" value="<?php echo esc_attr( $index ); ?>"><?php esc_html_e( 'Install', 'pt-ocdi' ); ?></button>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<div id="js-ocdi-modal-content"></div>

	<?php endif; ?>

	<p class="ocdi__ajax-loader js-ocdi-ajax-loader">
		<span class="ocdi__ajax-loader-holder">
			<span class="preloader"></span>
			<span class="details">
				<b><?php esc_html_e( 'Import is starting', 'pt-ocdi' ); ?></b><br>
				<em><?php esc_html_e( 'This process may take a while on some hosts, so please be patient.', 'pt-ocdi' ); ?></em>
			</span>
		</span>
	</p>

	<div class="ocdi__response  js-ocdi-ajax-response"></div>
</div>

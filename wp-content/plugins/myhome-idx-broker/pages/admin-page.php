<div class="wrap">
	<h1><?php esc_html_e( 'MyHome IDX Broker', 'myhome-idx-broker' ); ?></h1>
	<div class="mh-idx-info-start">
		<div class="mh-idx-max-width">
			<strong><?php esc_html_e( 'Using this plugin is fully optional and it is not necessary for the functioning of the MyHome theme.',
					'myhome-idx-broker' ); ?></strong>

			<strong><?php esc_html_e( 'You can disable it if you do not plan to use it.',
					'myhome-idx-broker' ); ?></strong>
			<br><br>
			<?php esc_html_e( 'IDX is limited to licensed agents from', 'myhome-idx-broker' ); ?>
			<strong><?php esc_html_e( 'United States, Canada, Bahamas, Mexico and Jamaica.',
					'myhome-idx-broker' ); ?></strong>
			<br>
			<?php esc_html_e( 'You can read more about IDX integration in the MyHome Knowledge Base:',
				'myhome-idx-broker' ); ?>
			<a target="_blank"
			   href="https://myhometheme.zendesk.com/hc/en-us/articles/115004872273-About-IDX-Broker-Integration-MLS-">
				<?php esc_html_E( 'About IDX', 'myhome-idx-broker' ); ?>
			</a>
		</div>
	</div>
	<div class="mh-idx-info-registration">
		<div class="mh-idx-max-width">
			<h2><?php esc_html_e( 'Registration', 'myhome-idx-broker' ); ?></h2>
			<div>
				<?php esc_html_e( 'If you do not have IDX Broker account yet we recommend to use below button to register. This way you do not have to pay set up fees (normally $99.99) and',
					'myhome-idx-broker' ); ?>
				<a href="https://themeforest.net/user/tangibledesign"><?php esc_html_e( 'TangibleDesign',
						'myhome-idx-broker' ); ?></a>
				<?php esc_html_e( '( MyHome developers team) will be assigned to your IDX Broker account. It can be useful for you if you need any help with IDX in the future.',
					'myhome-idx-broker' ); ?>
			</div>
			<br>
			<p>
				<a href="https://signup.idxbroker.com/d/myhome" class="button button-primary" target="_blank">
					<?php esc_html_e( 'REGISTER', 'myhome-idx-broker' ); ?>
				</a>
			</p>
		</div>
	</div>

	<div class="mh-idx-form-basic">
		<div class="mh-idx-max-width">
			<h2><?php esc_html_e( 'Basic settings', 'myhome-idx-broker' ); ?></h2>

			<div>
				<?php
				$myhome_idx_broker_load_style = \MyHomeIDXBroker\My_Home_IDX_Broker()->options->get( 'load_style' );
				?>
			</div>

			<form action="<?php echo esc_url( admin_url( 'admin-post.php?action=myhome_idx_broker_save_options' ) ); ?>"
				  method="post">

				<?php wp_nonce_field( 'myhome_idx_broker_update_options', 'check_sec' ); ?>

				<table class="form-table mh-basic-settings-table">
					<tr>
						<th>
							<label for="api-key" class="mh-idx-form-basic__heading">
								<?php esc_html_e( 'API Key', 'myhome-idx-broker' ); ?>
							</label>
						</th>
						<td>
							<input
								id="api-key"
								type="text"
								name="options[api_key]"
								value="<?php echo esc_attr( \MyHomeIDXBroker\My_Home_IDX_Broker()->options->get( 'api_key' ) ); ?>">
						</td>
					</tr>
					<tr>
						<th>
							<h3 class="mh-idx-form-basic__heading">
								<?php esc_html_e( 'Load MyHome styles', 'myhome-idx-broker' ); ?>
							</h3>
							<div class="mh-idx-form-basic__subheading">
								<?php esc_html_e( 'It will overwrite default IDX Broker styles', 'myhome-idx-broker' ); ?>
							</div>
						</th>
						<td>
							<input
								type="checkbox"
								value="1"
								name="options[load_style]"
								<?php if ( is_null( $myhome_idx_broker_load_style ) || ! empty( $myhome_idx_broker_load_style ) ) : ?>
									checked="checked"
								<?php endif; ?>
							>
						</td>
					</tr>
				</table>
				<p>
					<button class="button button-primary">
						<?php esc_html_e( 'SAVE ALL OPTIONS', 'myhome-idx-broker' ); ?>
					</button>
				</p>
				<br><br>
				<h2><?php esc_html_e( 'Importing MLS Featured Properties into WordPress Databases',
						'myhome-idx-broker' ); ?></h2>

				<div>
					<?php
					$myhome_idx_broker_load_style = \MyHomeIDXBroker\My_Home_IDX_Broker()->options->get( 'load_style' );
					?>
				</div>
				<div>
					<?php esc_html_e( 'Please check documentation here:', 'myhome-idx-broker' ); ?>
					<a href="https://myhometheme.zendesk.com/hc/en-us/articles/360000959273-Importing-MLS-Featured-Properties-into-WordPress-Database">
						<?php esc_html_e( 'Importing MLS Featured Properties into WordPress Databases',
							'myhome-idx-broker' ); ?>
					</a>

				</div>

				<table class="form-table mh-basic-settings-table">
					<tr>
						<th>
							<label for="init-status" class="mh-idx-form-basic__heading">
								<?php esc_html_e( 'Initial property status', 'myhome-idx-broker' ); ?>
							</label>
						</th>
						<td>
							<select name="options[init_status]" id="init-status">
								<option
									value="publish"
									<?php if ( \MyHomeIDXBroker\My_Home_IDX_Broker()->options->get( 'init_status' ) == 'publish' ) : ?>
										selected="selected"
									<?php endif; ?>
								>
									<?php esc_html_e( 'Publish', 'myhome-idx-broker' ); ?>
								</option>
								<option
									value="pending"
									<?php if ( \MyHomeIDXBroker\My_Home_IDX_Broker()->options->get( 'init_status' ) == 'pending' ) : ?>
										selected="selected"
									<?php endif; ?>
								>
									<?php esc_html_e( 'Pending', 'myhome-idx-broker' ); ?>
								</option>
								<option
									value="draft"
									<?php if ( \MyHomeIDXBroker\My_Home_IDX_Broker()->options->get( 'init_status' ) == 'draft' ) : ?>
										selected="selected"
									<?php endif; ?>
								>
									<?php esc_html_e( 'Draft', 'myhome-idx-broker' ); ?>
								</option>
							</select>
						</td>
					</tr>
					<tr>
						<th>
							<label for="user" class="mh-idx-form-basic__heading">
								<?php esc_html_e( 'Default user', 'myhome-idx-broker' ); ?>
							</label>
						</th>
						<td>
							<?php
							$myhome_users        = get_users();
							$myhome_default_user = intval( \MyHomeIDXBroker\My_Home_IDX_Broker()->options->get( 'user' ) );
							?>
							<select name="options[user]" id="user">
								<option value="0"><?php esc_html_e( 'Not set', 'myhome-idx-broker' ); ?></option>
								<?php foreach ( $myhome_users as $myhome_user ) :
									/* @var $myhome_user \WP_User */
									?>
									<option
										value="<?php echo esc_attr( $myhome_user->ID ); ?>"
										<?php if ( $myhome_default_user == $myhome_user->ID ) : ?>
											selected
										<?php endif; ?>
									>
										<?php echo esc_html( $myhome_user->display_name ); ?>
									</option>
								<?php endforeach; ?>
							</select>
						</td>
					</tr>
					<tr>
						<th>
							<label for="offer-type" class="mh-idx-form-basic__heading">
								<?php esc_html_e( 'Default offer type', 'myhome-idx-broker' ); ?>
							</label>
						</th>
						<td>
							<?php $myhome_idx_broker_offer_type = intval( \MyHomeIDXBroker\My_Home_IDX_Broker()->options->get( 'offer_type' ) ); ?>
							<select name="options[offer_type]" id="offer-type">
								<option value="0">
									<?php esc_html_e( 'Not set', 'myhome-idx-broker' ) ?>
								</option>
								<?php foreach ( \MyHomeCore\Terms\Term_Factory::get_offer_types() as $offer_type ) : ?>
									<option
										<?php if ( $myhome_idx_broker_offer_type == $offer_type->get_ID() ) : ?>
											selected="selected"
										<?php endif; ?>
										value="<?php echo esc_attr( $offer_type->get_ID() ); ?>"
									>
										<?php echo esc_html( $offer_type->get_name() ); ?>
									</option>
								<?php endforeach; ?>

							</select>
						</td>
					</tr>
					<tr>
						<th>
							<label for="offer-type-sold" class="mh-idx-form-basic__heading">
								<?php esc_html_e( 'Offer type for "Sold" properties:', 'myhome-idx-broker' ); ?>
							</label>
						</th>
						<td>
							<?php $myhome_idx_broker_offer_type_sold = intval( \MyHomeIDXBroker\My_Home_IDX_Broker()->options->get( 'offer_type_sold' ) ); ?>
							<select name="options[offer_type_sold]" id="offer-type-sold">
								<option value="0">
									<?php esc_html_e( 'Not set', 'myhome-idx-broker' ) ?>
								</option>
								<?php foreach ( \MyHomeCore\Terms\Term_Factory::get_offer_types() as $offer_type ) : ?>
									<option
										<?php if ( $myhome_idx_broker_offer_type_sold == $offer_type->get_ID() ) : ?>
											selected="selected"
										<?php endif; ?>
										value="<?php echo esc_attr( $offer_type->get_ID() ); ?>"
									>
										<?php echo esc_html( $offer_type->get_name() ); ?>
									</option>
								<?php endforeach; ?>

							</select>
						</td>
					</tr>
					<tr>
						<th>
							<label for="offer-type-pending" class="mh-idx-form-basic__heading">
								<?php esc_html_e( 'Offer type for "Pending" properties:', 'myhome-idx-broker' ); ?>
							</label>
						</th>
						<td>
							<?php $myhome_idx_broker_offer_type_pending = intval( \MyHomeIDXBroker\My_Home_IDX_Broker()->options->get( 'offer_type_pending' ) ); ?>
							<select name="options[offer_type_pending]" id="offer-type-pending">
								<option value="0">
									<?php esc_html_e( 'Not set', 'myhome-idx-broker' ) ?>
								</option>
								<?php foreach ( \MyHomeCore\Terms\Term_Factory::get_offer_types() as $offer_type ) : ?>
									<option
										<?php if ( $myhome_idx_broker_offer_type_pending == $offer_type->get_ID() ) : ?>
											selected="selected"
										<?php endif; ?>
										value="<?php echo esc_attr( $offer_type->get_ID() ); ?>"
									>
										<?php echo esc_html( $offer_type->get_name() ); ?>
									</option>
								<?php endforeach; ?>

							</select>
						</td>
					</tr>
					<tr>
						<th>
							<label for="images-limit" class="mh-idx-form-basic__heading">
								<?php esc_html_e( 'Limit number of imported images', 'myhome-idx-broker' ); ?>
							</label>
						</th>
						<td>
							<?php
							$myhome_idx_broker_images_limit = \MyHomeIDXBroker\My_Home_IDX_Broker()->options->get( 'images_limit' );

							if ( $myhome_idx_broker_images_limit == '' ) {
								$myhome_idx_broker_images_limit = 25;
							} else {
								$myhome_idx_broker_images_limit = intval( $myhome_idx_broker_images_limit );
							}
							?>
							<input name="options[images_limit]" id="images-limit" type="text"
								   value="<?php echo esc_attr( $myhome_idx_broker_images_limit ); ?>">
						</td>
					</tr>
					<tr>
						<th>
							<label for="update_type" class="mh-idx-form-basic__heading">
								<?php esc_html_e( 'Update all values during synchronization', 'myhome-idx-broker' ); ?>
							</label>
							<div class="mh-idx-form-basic__subheading">
								<?php esc_html_e( 'If this option is checked, every synchronization will overwrite content in the WordPress database. If it is unchecked the "Price" and "Offer Type" will be updated.',
									'myhome-idx-broker' ); ?>
							</div>
						</th>
						<td>
							<?php
							if ( ! \MyHomeIDXBroker\My_Home_IDX_Broker()->options->exists( 'update_all_data' ) ) :
								$myhome_idx_broker_update_all_data = 1;
							else :
								$myhome_idx_broker_update_all_data = intval( \MyHomeIDXBroker\My_Home_IDX_Broker()->options->get( 'update_all_data' ) );
							endif;
							?>
							<input
								type="checkbox"
								value="1"
								name="options[update_all_data]"
								<?php if ( ! empty( $myhome_idx_broker_update_all_data ) ) : ?>
									checked="checked"
								<?php endif; ?>
							>
						</td>
					</tr>
					<tr>
						<th>
							<label for="mh-disable_sold_import" class="mh-idx-form-basic__heading">
								<?php esc_html_e( 'Disable sold properties import', 'myhome-idx-broker' ); ?>
							</label>
						</th>
						<td>
							<input
								id="mh-disable_sold_import"
								type="checkbox"
								value="1"
								name="options[disable_sold_import]"
								<?php if ( ! empty( \MyHomeIDXBroker\My_Home_IDX_Broker()->options->get( 'disable_sold_import' ) ) ) : ?>
									checked="checked"
								<?php endif; ?>
							>
						</td>
					</tr>
				</table>

				<?php
				$myhome_breadcrumb_attributes = \MyHomeCore\Common\Breadcrumbs\Breadcrumbs::get_attributes();

				if ( count( $myhome_breadcrumb_attributes ) ) :
					?>
					<h3><?php esc_html_e( 'Breadcrumbs fields - default values', 'myhome-idx-broker' ); ?></h3>
					<div>
						<?php
						echo wp_kses_post( __( 'Default values are required for all fields that are used in the breadcrumbs. If you wish you can visit MyHome Theme >> Breadcrumbs to remove fields from its structure.',
							'myhome-idx-broker' ) );
						?>
					</div>
				<?php
				endif;
				?>

				<table class="form-table mh-basic-settings-table">
					<?php foreach ( $myhome_breadcrumb_attributes as $myhome_attribute ) : ?>
						<tr>
							<th>
								<label class="mh-idx-form-basic__heading"
									   for="attr-<?php echo esc_attr( $myhome_attribute->get_slug() ); ?>">
									<?php echo esc_html( $myhome_attribute->get_name() ); ?>
								</label>
							</th>
							<td>
								<select
									name="options[attributes][<?php echo esc_attr( $myhome_attribute->get_ID() ); ?>]"
									id="attr-<?php echo esc_attr( $myhome_attribute->get_slug() ); ?>"
								>
									<?php foreach ( $myhome_attribute->get_terms() as $myhome_term ) : ?>
										<option
											value="<?php echo esc_attr( $myhome_term->get_ID() ); ?>"
											<?php
											$myhome_current_term_id = intval( \MyHomeIDXBroker\My_Home_IDX_Broker()->options->get( 'attributes',
												$myhome_attribute->get_ID() ) );
											if ( $myhome_term->get_ID() == $myhome_current_term_id ) : ?>
												selected="selected"
											<?php endif; ?>
										>
											<?php echo esc_html( $myhome_term->get_name() ); ?>
										</option>
									<?php endforeach; ?>
								</select>
							</td>
						</tr>
					<?php endforeach; ?>
				</table>
				<p>
					<button class="button button-primary">
						<?php esc_html_e( 'SAVE ALL OPTIONS', 'myhome-idx-broker' ); ?>
					</button>
				</p>
			</form>
		</div>
	</div>

	<div class="mh-idx-auto-setup">
		<div class="mh-idx-max-width">
			<h2><?php esc_html_e( 'Auto setup', 'myhome-idx-broker' ); ?></h2>
			<p>
				<a href="https://myhometheme.zendesk.com/hc/en-us/articles/360000959933-IDX-Broker-configuration-using-dynamic-wrappers-to-display-all-MLS-listings">Click
					here to read full documentation, about displaying all MLS Properties via feed</a></p>
			<div><?php esc_html_e( 'When you click Auto Setup. MyHome will:', 'myhome-idx-broker' ); ?>
				<ul>
					<li><?php esc_html_e( '- add all IDX Demo Wrappers to your WordPress', 'myhome-idx-broker' ); ?></li>
					<li><?php esc_html_e( '- set this wrappers in your IDX Broker MGMT', 'myhome-idx-broker' ); ?></li>
				</ul>
			</div>
			<p>
				<a href="<?php echo esc_url( admin_url( 'admin-post.php?action=myhome_idx_broker_auto_setup' ) ); ?>"
				   class="button button-primary">
					<?php esc_html_e( 'AUTO SETUP', 'myhome-idx-broker' ); ?>
				</a>
			</p>
		</div>
	</div>

	<div class="mh-idx-cache">
		<div class="mh-idx-max-width">
			<h2><?php esc_html_e( 'Clear MyHome IDX Broker Cache', 'myhome-idx-broker' ); ?></h2>
			<p>
				<a href="<?php echo esc_url( admin_url( 'admin-post.php?action=myhome_idx_broker_clear_cache' ) ); ?>"
				   class="button button-primary">
					<?php esc_html_e( 'CLEAR CACHE', 'myhome-idx-broker' ); ?>
				</a>
			</p>
		</div>
	</div>
</div>
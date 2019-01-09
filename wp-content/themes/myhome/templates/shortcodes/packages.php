<?php
global $myhome_packages;
?>

<div class="mh-pricing-table mh-pricing-table--<?php echo esc_attr( $myhome_packages['number'] ); ?>-col">
	<div class="mh-pricing-table__inner">
		<?php foreach ( $myhome_packages['products'] as $product ) : ?>
			<?php /* @var $product \MyHomeCore\Payments\WC_Product_Property_Package */ ?>
			<div class="mh-pricing-table__column">
				<div class="mh-pricing-table__column__inner">
					<div class="mh-pricing-table__row mh-pricing-table__row--name">
						<?php echo esc_html( $product->get_name() ); ?>
					</div>
					<div class="mh-pricing-table__row mh-pricing-table__row--price">
						<?php if ( empty( $product->get_price() ) ) : ?>
							<?php esc_html_e( 'Free', 'myhome' ); ?>
						<?php else : ?>
							<?php echo wp_kses_post( $product->get_price_html() ); ?>
						<?php endif; ?>
						<!--<span class="mh-pricing-table__price-period"></span>!-->
					</div>
					<div class="mh-pricing-table__row">
						<?php esc_html_e( 'Properties number:', 'myhome' ); ?> <?php echo esc_html( $product->get_properties_number() ); ?>
					</div>
					<div class="mh-pricing-table__row">
						<?php esc_html_e( 'Featured number:', 'myhome' ); ?> <?php echo esc_html( $product->get_featured_number() ); ?>
					</div>
					<?php $product->is_virtual() ?>
					<div class="mh-pricing-table__row mh-pricing-table__row--button">
						<a
							href="<?php echo esc_url( $product->add_to_cart_url() ); ?>"
							class="mdl-button mdl-button--lg mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--primary"
						>
							<?php esc_html_e( 'Buy now', 'myhome' ); ?>
						</a>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>
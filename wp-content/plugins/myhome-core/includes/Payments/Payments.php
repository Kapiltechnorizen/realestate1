<?php

namespace MyHomeCore\Payments;


/**
 * Class Payments
 * @package MyHomeCore\Payments
 */
class Payments {

	/**
	 * Payments constructor.
	 */
	public function __construct() {
		add_action( 'woocommerce_order_status_completed', array( $this, 'package_purchased' ) );
		add_filter( 'product_type_selector', array( $this, 'add_custom_product_type' ) );
		add_filter( 'woocommerce_product_class', array( $this, 'add_product_class' ), 10, 2 );
		add_action( 'woocommerce_product_options_general_product_data', array( $this, 'add_custom_fields' ) );
		add_action( 'woocommerce_process_product_meta', array( $this, 'save_custom_fields' ) );
		add_action( 'admin_footer', array( $this, 'show_price' ) );
	}

	public function package_purchased( $order_id ) {
		$order   = \WC_Order_Factory::get_order( $order_id );
		$user_id = $order->get_user_id();

		foreach ( $order->get_items() as $item ) {
			/* @var $item \WC_Order_Item_Product */
			$product = $item->get_product();
			if ( ! $product instanceof WC_Product_Property_Package ) {
				continue;
			}

			$quantity          = $item->get_quantity();
			$properties_number = intval( get_user_meta( $user_id, 'package_properties', true ) );
			$featured_number   = intval( get_user_meta( $user_id, 'package_featured', true ) );

			update_user_meta( $user_id, 'package_properties', $properties_number + $product->get_properties_number() * $quantity );
			update_user_meta( $user_id, 'package_featured', $featured_number + $product->get_featured_number() * $quantity );
		}
	}

	/**
	 * @param array $types
	 *
	 * @return array
	 */
	public function add_custom_product_type( $types ) {
		$types['myhome_package'] = esc_html__( 'MyHome Package', 'myhome-core ' );

		return $types;
	}

	/**
	 * @param string $class_name
	 * @param string $product_type
	 *
	 * @return string
	 */
	public function add_product_class( $class_name, $product_type ) {
		if ( $product_type == 'myhome_package' ) {
			return '\MyHomeCore\Payments\WC_Product_Property_Package';
		}

		return $class_name;
	}

	public function add_custom_fields() {
		global $woocommerce, $post;
		echo '<div class="options_group show_if_myhome_package">';

		woocommerce_wp_text_input(
			array(
				'id'          => 'myhome_properties_number',
				'label'       => esc_html__( 'Properties number', 'myhome-core' ),
				'placeholder' => '',
				'desc_tip'    => 'true',
				'description' => esc_html__( 'Properties number tip', 'myhome-core' ),
				'type'        => 'number'
			)
		);

		woocommerce_wp_text_input(
			array(
				'id'          => 'myhome_featured_number',
				'label'       => esc_html__( 'Featured properties number', 'myhome-core' ),
				'placeholder' => '',
				'desc_tip'    => 'true',
				'description' => esc_html__( 'Featured properties number tip', 'myhome-core' ),
				'type'        => 'number'
			)
		);

		echo '</div>';
	}

	/**
	 * @param int $post_id
	 */
	public function save_custom_fields( $post_id ) {
		if ( isset( $_POST['myhome_properties_number'] ) ) {
			$properties_number = intval( $_POST['myhome_properties_number'] );
			update_post_meta( $post_id, 'myhome_properties_number', $properties_number );
		}

		if ( isset( $_POST['myhome_featured_number'] ) ) {
			$featured_number = intval( $_POST['myhome_featured_number'] );
			update_post_meta( $post_id, 'myhome_featured_number', $featured_number );
		}

		if ( isset( $_POST['myhome_days_expire'] ) ) {
			$days_expire = intval( $_POST['myhome_days_expire'] );
			update_post_meta( $post_id, 'myhome_days_expire', $days_expire );
		}
	}

	public function show_price() {
		if ( 'product' != get_post_type() ) {
			return;
		}

		?>
		<script>
			jQuery(document).ready(function () {
				jQuery('#general_product_data .pricing').addClass('show_if_myhome_package').show();
				jQuery('.inventory_options').addClass('show_if_myhome_package').show();
			});
		</script>
		<?php
	}

	/**
	 * @return bool
	 */
	public static function is_enabled() {
		$is_enabled = \MyHomeCore\My_Home_Core()->settings->get( 'payment' );

		return ! empty( $is_enabled );
	}

}
<?php

namespace MyHomeCore\Payments;


/**
 * Class WC_Product_Property_Package
 * @package MyHomeCore\Payments
 */
class WC_Product_Property_Package extends \WC_Product_Simple {

	/**
	 * @return string
	 */
	public function get_type() {
		return 'myhome_package';
	}

	/**
	 * @return int
	 */
	public function get_featured_number() {
		return intval( $this->get_meta( 'myhome_featured_number' ) );

	}

	/**
	 * @return int
	 */
	public function get_properties_number() {
		return intval( $this->get_meta( 'myhome_properties_number' ) );
	}

	/**
	 * @return bool
	 */
	public function is_virtual() {
		return true;
	}

	/**
	 * @return bool
	 */
	public function is_downloadable() {
		return false;
	}

	/**
	 * @return bool
	 */
	public function is_purchasable() {
		return true;
	}

}
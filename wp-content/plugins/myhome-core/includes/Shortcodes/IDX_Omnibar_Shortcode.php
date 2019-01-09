<?php

namespace MyHomeCore\Shortcodes;


/**
 * Class IDX_Omnibar_Shortcode
 * @package MyHomeCore\Shortcodes
 */
class IDX_Omnibar_Shortcode extends Shortcode {

	/**
	 * @param array   $args
	 * @param \string $content
	 *
	 * @return string
	 */
	public function display( $args = array(), $content = null ) {
		return $this->get_template();
	}

	/**
	 * @return array
	 */
	public function get_vc_params() {
		return array();
	}

}
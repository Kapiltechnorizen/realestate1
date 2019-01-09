<?php

namespace MyHomeIDXBroker;

/**
 * Class Api
 * @package MyHomeIDXBroker
 */
class Api {

	const CITIES = 'https://api.idxbroker.com/mls/cities';
	const COUNTIES = 'https://api.idxbroker.com/mls/counties';
	const POSTAL_CODES = 'https://api.idxbroker.com/mls/postalcodes';
	const PROPERTY_TYPES = 'https://api.idxbroker.com/mls/propertytypes/a';
	const SEARCH_FIELDS = 'https://api.idxbroker.com/mls/searchfields';
	const SEARCH_FIELD_VALUES = 'https://api.idxbroker.com/mls/searchfieldvalues';
	const AGENTS = 'https://api.idxbroker.com/clients/agents';
	const PROPERTIES_ACTIVE = 'https://api.idxbroker.com/clients/featured';
	const PROPERTIES_SOLD_PENDING = 'https://api.idxbroker.com/clients/soldpending';
	const PROPERTIES_SUPPLEMENTAL = 'https://api.idxbroker.com/clients/supplemental';

	const SYSTEM_LINKS = 'https://api.idxbroker.com/clients/systemlinks';
	const SAVED_LINKS = 'https://api.idxbroker.com/clients/savedlinks';
	const WIDGET_SRC = 'https://api.idxbroker.com/clients/widgetsrc';
	const DYNAMIC_WRAPPER_URL = 'https://api.idxbroker.com/clients/dynamicwrapperurl';

	const OPTION_API_KEY = 'api_key';

	/**
	 * @var string
	 */
	private $key;

	/**
	 * Api constructor.
	 */
	public function __construct() {
		$this->key = My_Home_IDX_Broker()->options->get( Api::OPTION_API_KEY );
	}

	/**
	 * @param string $query
	 * @param array  $data
	 *
	 * @return array|bool|mixed|object
	 */
	public function request( $query, $data = array() ) {
		$headers = array(
			'Content-Type: application/x-www-form-urlencoded',
			'accesskey: ' . $this->key,
			'outputtype: json'
		);

		$handle = curl_init();
		curl_setopt( $handle, CURLOPT_URL, $query );
		curl_setopt( $handle, CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $handle, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $handle, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt( $handle, CURLOPT_SSL_VERIFYPEER, false );

		if ( ! empty( $data ) ) {
			curl_setopt( $handle, CURLOPT_POST, 1 );
			curl_setopt( $handle, CURLOPT_POSTFIELDS, http_build_query( $data ) );
		}

		$response = curl_exec( $handle );
		$code     = curl_getinfo( $handle, CURLINFO_HTTP_CODE );

		if ( $code >= 200 || $code < 300 ) {
			return json_decode( $response );
		}

		if ( $code == 412 ) {
			global $idx_broker_limit;
			$idx_broker_limit = true;
		}

		return false;
	}

	public function get_mls() {

	}

	/**
	 * @param $mls_ID
	 *
	 * @return bool|object
	 */
	public function get_search_fields( $mls_ID ) {
		$query = Api::SEARCH_FIELDS . '/' . $mls_ID;

		return $this->request( $query );
	}

	/**
	 * @param $mls_ID
	 * @param $mls_pt_ID
	 * @param $mls_name
	 */
	public function get_search_field_values( $mls_ID, $mls_pt_ID, $mls_name ) {
		$query = Api::SEARCH_FIELD_VALUES . '/' . $mls_ID . '?mlsPtID=' . $mls_pt_ID . '&name=' . $mls_name;

		$this->request( $query );
	}

	/**
	 * @return array
	 */
	public function get_agents() {
		$query = Api::AGENTS;

		$response = $this->request( $query );

		if ( isset( $response->agent ) ) {
			return $response->agent;
		}

		return array();
	}

	/**
	 * @param string $last_check
	 *
	 * @return array
	 */
	public function get_new_active_properties( $last_check = '' ) {
		$query = Api::PROPERTIES_ACTIVE;

		$response   = $this->request( $query );
		$properties = json_decode( json_encode( $response ), true );

		if ( ! is_array( $properties ) ) {
			return array();
		}

		return $properties;
	}

	/**
	 * @param string $last_check
	 *
	 * @return array
	 */
	public function get_sold_pending_properties( $last_check = '' ) {
		$query = Api::PROPERTIES_SOLD_PENDING;

		$response   = $this->request( $query );
		$properties = json_decode( json_encode( $response ), true );

		if ( ! is_array( $properties ) ) {
			return array();
		}

		return $properties;
	}

	public function get_supplemental_properties() {
		$query = Api::PROPERTIES_SUPPLEMENTAL;

		$this->request( $query );
	}

	/**
	 * @return array
	 */
	public function get_system_links() {
		$cache_key    = 'idx_broker_system_links';
		$system_links = get_transient( $cache_key );
		if ( $system_links !== false ) {
			if ( ! is_array( $system_links ) ) {
				return [];
			}

			return $system_links;
		}

		$response     = $this->request( Api::SYSTEM_LINKS );
		$system_links = json_decode( json_encode( $response ), true );

		set_transient( $cache_key, $system_links, 3600 );

		if ( ! is_array( $system_links ) ) {
			return array();
		}

		return $system_links;
	}

	/**
	 * @return array
	 */
	public function get_saved_links() {
		$cache_key   = 'idx_broker_saved_links';
		$saved_links = get_transient( $cache_key );
		if ( $saved_links !== false ) {
			if ( ! is_array( $saved_links ) ) {
				return [];
			}

			return $saved_links;
		}

		$response    = $this->request( Api::SAVED_LINKS );
		$saved_links = json_decode( json_encode( $response ), true );

		set_transient( $cache_key, $saved_links, 3600 );

		if ( ! is_array( $saved_links ) ) {
			return array();
		}

		return $saved_links;
	}

	/**
	 * @return array
	 */
	public function get_widget_src() {
		$cache_key = 'idx_broker_widgets';
		$widgets   = get_transient( $cache_key );
		if ( $widgets !== false ) {
			return $widgets;
		}

		$response   = $this->request( Api::WIDGET_SRC );
		$widget_src = json_decode( json_encode( $response ), true );

		if ( ! is_array( $widget_src ) ) {
			return array();
		}

		set_transient( $cache_key, $widget_src, 3600 );

		return $widget_src;
	}

	/**
	 * @param array $data
	 */
	public function update_wrapper( $data ) {
		$this->request( Api::DYNAMIC_WRAPPER_URL, $data );
	}

}
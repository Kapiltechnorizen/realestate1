<?php

namespace MyHomeIDXBroker;


/**
 * Class IDX
 * @package MyHomeIDXBroker
 */
class IDX {

	/**
	 * @var Options
	 */
	public $options;

	private static $instance = false;
	public static $is_crone = false;

	private $auto_setup;

	/**
	 * @return IDX
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function init() {
		add_filter( 'upload_mimes', function ( $mimes ) {
			$mimes['.jpg'] = 'application/octet-stream';

			return $mimes;
		} );
		$this->options    = new Options();
		$this->auto_setup = new Auto_Setup();

		add_action( 'admin_menu', array( $this, 'add_menu' ), 99 );
		add_action( 'init', array( $this, 'load_text_domain' ) );

		add_action( 'admin_post_myhome_idx_broker_import_agents', array( $this, 'import_agents' ) );
		add_action( 'admin_post_myhome_idx_broker_import_fields', array( $this, 'import_fields' ) );
		add_action( 'admin_post_myhome_idx_broker_save_fields', array( $this, 'save_fields' ) );
		add_action( 'admin_post_myhome_idx_broker_save_options', array( $this, 'save_options' ) );
		add_action( 'admin_post_myhome_idx_broker_save_mls_ids', array( $this, 'save_mls_ids' ) );
		add_action( 'wp_ajax_myhome_idx_broker_import_init', array( $this, 'import_init' ) );
		add_action( 'wp_ajax_myhome_idx_broker_import_job', array( $this, 'import_job' ) );
		add_action( 'wp_ajax_myhome_idx_broker_generate_thumbnails', array( $this, 'generate_thumbnails' ) );
		add_action( 'upload_mimes', array( $this, 'mime_types' ) );

		if ( is_admin() ) {
			$auto_setup = get_option( 'myhome_idx_broker_auto_setup' );
			if ( ! empty( $auto_setup ) ) {
				add_action( 'admin_notices', function () {
					?>
					<div class="notice notice-success notice-auto-setup">
                        <p><?php esc_html_e( 'MyHome IDX Broker auto setup finished', 'myhome-idx-broker' ); ?></p>
                        <p><a href="https://myhometheme.zendesk.com/hc/en-us/articles/360000959933-IDX-Broker-configuration-using-dynamic-wrappers-to-display-all-MLS-listings">Click here to read full documentation, about displaying all MLS Properties via feed</a></p>
                    </div>
					<?php
				} );
				update_option( 'myhome_idx_broker_auto_setup', 0 );
			}

			add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
			$api_key = \MyHomeIDXBroker\My_Home_IDX_Broker()->options->get( 'api_key' );
			if ( ! empty( $api_key ) ) {
				$this->register_fields();
			}
		}

		add_action( 'admin_post_nopriv_myhome_idx_broker_cron_init', array( $this, 'cron_init' ) );
		add_action( 'admin_post_myhome_idx_broker_cron_init', array( $this, 'cron_init' ) );
		add_action( 'admin_post_nopriv_myhome_idx_broker_cron_job', array( $this, 'cron_job' ) );
		add_action( 'admin_post_myhome_idx_broker_cron_job', array( $this, 'cron_job' ) );
		add_action( 'admin_post_myhome_idx_broker_hash', array( $this, 'regenerate_hash' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts' ) );
		add_action( 'init', array( $this, 'check_idx_broker_config' ) );
		//		add_action( 'save_post_page', array( $this, 'save_page' ), 100 );
		add_action( 'admin_post_myhome_idx_broker_clear_cache', array( $this, 'clear_cache' ) );
	}

	public function clear_cache() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Something went wrong', 'myhome-idx-broker' ) );
		}

		delete_transient( 'idx_broker_saved_links' );
		delete_transient( 'idx_broker_system_links' );
		delete_transient( 'idx_broker_widgets' );

		wp_redirect( admin_url( 'admin.php?page=myhome_idx_broker' ) );
		die();
	}

	public function check_idx_broker_config() {
		$check = get_option( 'check_idx_broker_config' );
		if ( is_null( $check ) || empty( $check ) ) {
			$options = get_option( Options::OPTION_KEY );
			if ( ! isset( $options['load_style'] ) ) {
				$options['load_style'] = 1;
				update_option( Options::OPTION_KEY, $options );
			}
			update_option( 'check_idx_broker_config', 1, 'yes' );
		}
	}

	public function load_scripts() {
		$load_style = My_Home_IDX_Broker()->options->get( 'load_style' );
		if ( ! empty( $load_style ) ) {
			wp_enqueue_style( 'myhome-idx-broker', plugins_url( MY_HOME_IDX_PATH . '/assets/css/main.css' ) );
		}
	}

	public function generate_thumbnails() {
		$importer = new Importer();
		$importer->generate_thumbnails();
		wp_die();
	}

	public function mime_types( $mimes = array() ) {
		$mimes['jpg'] = "image/jpeg";

		return $mimes;
	}

	public function scripts() {
		if ( isset( $_GET['page'] ) && strpos( $_GET['page'], 'myhome_idx_broker_properties' ) !== false ) {
			wp_enqueue_script( 'myhome-idx-broker', plugins_url( MY_HOME_IDX_PATH . '/assets/js/build.js' ), array(), false, true );
		}

		wp_enqueue_style( 'myhome-idx-broker', plugins_url( MY_HOME_IDX_PATH . '/assets/css/style.css' ) );
	}

	public function load_text_domain() {
		load_plugin_textdomain( 'myhome-idx-broker', false, MY_HOME_IDX_PATH . '/languages' );
	}

	public function add_menu() {
		add_menu_page(
			esc_html__( 'MyHome IDX Broker', 'myhome-idx-broker' ),
			esc_html__( 'MyHome IDX Broker', 'myhome-idx-broker' ),
			'administrator',
			'myhome_idx_broker',
			array( $this, 'admin_page' ),
			'',
			3
		);
		$pages = array(
			array(
				'title' => esc_html__( 'Add MLS IDs', 'myhome-idx-broker' ),
				'slug'  => 'mls'
			),
			array(
				'title' => esc_html__( 'Import Agents', 'myhome-idx-broker' ),
				'slug'  => 'agents'
			),
			array(
				'title' => esc_html__( 'Assign MLS Fields', 'myhome-idx-broker' ),
				'slug'  => 'fields'
			),
			array(
				'title' => esc_html__( 'Synchronize Properties', 'myhome-idx-broker' ),
				'slug'  => 'properties'
			)
		);

		foreach ( $pages as $page ) {
			add_submenu_page(
				'myhome_idx_broker',
				$page['title'],
				$page['title'],
				'administrator',
				'myhome_idx_broker_' . $page['slug'],
				array( $this, $page['slug'] . '_page' )
			);
		}
	}

	public function admin_page() {
		require MY_HOME_IDX_VIEWS . 'admin-page.php';
	}

	public function properties_page() {
		require MY_HOME_IDX_VIEWS . 'properties-page.php';
	}

	public function agents_page() {
		require MY_HOME_IDX_VIEWS . 'agents-page.php';
	}

	public function fields_page() {
		require MY_HOME_IDX_VIEWS . 'fields-page.php';
	}

	public function mls_page() {
		require MY_HOME_IDX_VIEWS . 'mls-page.php';
	}

	public function import_agents() {
		$agents = new Agents();
		$agents->import();

		wp_redirect( admin_url( 'admin.php?page=myhome_idx_broker_agents' ) );
		exit;
	}

	public function import_init() {
		$importer = new Importer();
		$importer->init();
		wp_die();
	}

	public function import_job() {
		$importer = new Importer();
		$importer->job();
		wp_die();
	}

	public function import_fields() {
		$fields = new Fields();
		$fields->import();

		wp_redirect( admin_url( 'admin.php?page=myhome_idx_broker_fields' ) );
		exit;
	}

	public function save_mls_ids() {
		$this->check_if_allowed( 'myhome_idx_broker_update_mls' );

		if ( ! isset( $_POST['mls_ids'] ) ) {
			return;
		}

		MLS::save();
		wp_redirect( admin_url( 'admin.php?page=myhome_idx_broker_mls' ) );
		exit;
	}

	public function save_fields() {
		$fields = new Fields();
		$fields->save();

		wp_redirect( admin_url( 'admin.php?page=myhome_idx_broker_fields' ) );
		exit;
	}

	public function save_options() {
		$this->check_if_allowed( 'myhome_idx_broker_update_options' );

		if ( isset( $_POST['options'] ) && ! empty( $_POST['options'] ) ) {
		    if (!isset($_POST['options']['update_all_data'])) {
		        $_POST['options']['update_all_data'] = 0;
            }
			My_Home_IDX_Broker()->options->save( $_POST['options'] );
		}

		if ( isset( $_POST['options']['api_key'] ) && ! empty( $_POST['options']['api_key'] ) ) {
			add_filter( 'mod_rewrite_rules', function ( $rules ) {
				ob_start();
				?>
				# BEGIN MyHome IDX Broker
				<FilesMatch "\.(ttf|otf|eot|woff)$">
				<IfModule mod_headers.c>
					Header set Access-Control-Allow-Origin "*"
				</IfModule>
				</FilesMatch>
				# END MyHome IDX Broker
				<?php
				$rules .= ob_get_clean();

				return $rules;
			} );
			flush_rewrite_rules();
		}

		wp_redirect( admin_url( 'admin.php?page=myhome_idx_broker' ) );
		exit;
	}

	private function check_if_allowed( $action ) {
		check_admin_referer( $action, 'check_sec' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You don\'t have right permissions to manage options.', 'myhome-idx-broker' ) );
		}
	}

	public function register_fields() {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		/**
		 * Agent fields
		 */
		acf_add_local_field_group( array(
			'key'        => 'myhome_idx_broker_user_fields',
			'title'      => esc_html__( 'MyHome IDX Broker', 'myhome-idx-broker' ),
			'fields'     => array(
				array(
					'key'   => 'myhome_idx_broker_user_id',
					'label' => esc_html__( 'IDX Agent ID', 'myhome-idx-broker' ),
					'name'  => 'idx_broker_user_id',
					'type'  => 'text'
				),
				array(
					'key'   => 'myhome_idx_broker_user_listing_id',
					'label' => esc_html__( 'IDX Agent Listing ID', 'myhome-idx-broker' ),
					'name'  => 'idx_broker_user_listing_id',
					'type'  => 'text'
				)
			),
			'menu_order' => 11,
			'location'   => array(
				array(
					array(
						'param'    => 'user_role',
						'operator' => '==',
						'value'    => 'all',
					),
				),
			),
		) );

		/**
		 * Property fields
		 */
		acf_add_local_field_group( array(
			'key'        => 'myhome_idx_broker_property_fields',
			'title'      => esc_html__( 'MyHome IDX Broker', 'myhome-idx-broker' ),
			'fields'     => array(
				array(
					'key'   => 'myhome_idx_broker_property_id',
					'label' => esc_html__( 'Property IDX ID', 'myhome-idx-broker' ),
					'name'  => 'idx_broker_property_id',
					'type'  => 'text'
				)
			),
			'menu_order' => 11,
			'location'   => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'estate',
					),
				),
			),
		) );

		$wrapper_types = array(
			'default'    => esc_html__( 'Not set', 'myhome-idx-broker' ),
			'global'     => esc_html__( 'Global wrapper', 'myhome-idx-broker' ),
			'page'       => esc_html__( 'Page', 'myhome-idx-broker' ),
			'saved_link' => esc_html__( 'Saved link', 'myhome-idx-broker' )
		);

		$api   = new Api();
		$pages = array();
		foreach ( $api->get_system_links() as $page ) {
			$temp = explode( '-', $page['uid'] );
			if ( ! isset( $page['name'] ) ) {
				$page['name'] = '';
			}
			$pages[ $temp[1] ] = $page['name'];
		}

		$saved_links = array();
		foreach ( $api->get_saved_links() as $page ) {
			$temp = explode( '-', $page['uid'] );
			if ( ! isset( $page['name'] ) ) {
				$page['name'] = '';
			}
			$saved_links[ $temp[1] ] = $page['name'];
		}

		//		acf_add_local_field_group( array(
		//			'key'      => 'myhome_idx_broker_page_fields',
		//			'title'    => esc_html__( 'MyHome IDX Broker', 'myhome-idx-broker' ),
		//			'position' => 'side',
		//			'fields'   => array(
		//				array(
		//					'key'     => 'myhome_idx_broker_wrapper_type',
		//					'label'   => esc_html__( 'Set as dynamic wrapper for:', 'myhome-idx-broker' ),
		//					'name'    => 'idx_broker_wrapper_type',
		//					'type'    => 'select',
		//					'choices' => $wrapper_types
		//				),
		//				array(
		//					'key'               => 'myhome_idx_broker_page_id',
		//					'label'             => esc_html__( 'Set as dynamic wrapper for:', 'myhome-idx-broker' ),
		//					'name'              => 'idx_broker_page_id',
		//					'type'              => 'select',
		//					'choices'           => $pages,
		//					'conditional_logic' => array(
		//						array(
		//							array(
		//								'field'    => 'myhome_idx_broker_wrapper_type',
		//								'operator' => '==',
		//								'value'    => 'page'
		//							)
		//						)
		//					)
		//				),
		//				array(
		//					'key'               => 'myhome_idx_broker_saved_link_id',
		//					'label'             => esc_html__( 'Saved links', 'myhome-idx-broker' ),
		//					'name'              => 'idx_broker_saved_link_id',
		//					'type'              => 'select',
		//					'choices'           => $saved_links,
		//					'conditional_logic' => array(
		//						array(
		//							array(
		//								'field'    => 'myhome_idx_broker_wrapper_type',
		//								'operator' => '==',
		//								'value'    => 'saved_link'
		//							)
		//						)
		//					)
		//				)
		//			),
		//			'location' => array(
		//				array(
		//					array(
		//						'param'    => 'post_type',
		//						'operator' => '==',
		//						'value'    => 'page',
		//					),
		//				),
		//			),
		//		) );
	}

	public static function cron_get_hash() {
		$hash = get_option( Importer::CRON_HASH );

		if ( empty( $hash ) ) {
			$hash = IDX::cron_create_hash();
		}

		return $hash;
	}

	public static function cron_create_hash() {
		$hash = md5( 'myhome_idx_broker_' . time() . '_' . rand( 1, 10000 ) );
		update_option( Importer::CRON_HASH, $hash );

		return $hash;
	}

	private function cron_check() {
		if ( ! isset( $_GET['myhome_idx_broker_hash'] ) || empty( $_GET['myhome_idx_broker_hash'] ) ) {
			return false;
		}

		$hash = sanitize_text_field( $_GET['myhome_idx_broker_hash'] );

		if ( ! ( $hash == IDX::cron_get_hash() ) ) {
			wp_die();
		}
	}

	public function cron_init() {
		$this->cron_check();
		update_option( Importer::CRON_JOB, Importer::CRON_JOB_INIT );
	}

	public function cron_job() {
		IDX::$is_crone = true;

		$this->cron_check();
		$importer = new Importer();
		$importer->cron();
	}

	public function regenerate_hash() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die();
		}
		IDX::cron_create_hash();
		wp_redirect( admin_url( 'admin.php?page=myhome_idx_broker' ) );
	}

	/**
	 * @param int $post_id
	 */
	public function save_page( $post_id ) {
		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || isset( $_REQUEST['bulk_edit'] ) ) {
			return;
		}

		$wrapper_type = get_post_meta( $post_id, 'idx_broker_wrapper_type', true );
		if ( empty( $wrapper_type ) || $wrapper_type == 'default' ) {
			return;
		}

		$data = array( 'dynamicURL' => get_the_permalink( $post_id ) );
		if ( $wrapper_type == 'page' ) {
			$data['pageID'] = get_post_meta( $post_id, 'idx_broker_page_id', true );
		} elseif ( $wrapper_type == 'saved_link' ) {
			$data['savedLinkID'] = get_post_meta( $post_id, 'idx_broker_saved_link_id', true );
		}

		$api = new Api();
		$api->update_wrapper( $data );
	}

}
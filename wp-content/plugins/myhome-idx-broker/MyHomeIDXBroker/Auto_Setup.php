<?php

namespace MyHomeIDXBroker;


/**
 * Class Auto_Setup
 * @package MyHomeIDXBroker
 */
class Auto_Setup {

	/**
	 * Auto_Setup constructor.
	 */
	public function __construct() {
		add_action( 'admin_post_myhome_idx_broker_auto_setup', array( $this, 'init' ) );
	}

	public function init() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Something went wrong', 'myhome-idx-broker' ) );
		}

		$wp_pages = array(
			array(
				'idx_name'      => '',
				'page_template' => 'page_full-width.php',
				'title'         => 'IDX - Homepage (Omnibar)',
				'content'       => '[vc_row full_width="stretch_row_content_no_spaces" el_class="overflow-initial" css=".vc_custom_1518459044524{background-image: url(https://myhometheme.net/idx/wp-content/uploads/2017/11/buildings-city-darker.jpg?id=2648) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column css=".vc_custom_1518458768553{padding-top: 72px !important;padding-bottom: 72px !important;}"][mh_heading heading_style="mh-heading--no-separator" heading_align="" heading_font_weight="700" heading_size="mh-font-size-xxxl" heading_tag="h1" heading_color="mh-color-white" heading_font_family="" heading_subheading_color="" heading_text="IDX BROKER ITEGRATION" heading_subheading="" heading_image_id="" css=".vc_custom_1518459339509{margin-bottom: 0px !important;}"][mh_heading heading_style="mh-heading--no-separator" heading_align="" heading_font_weight="400" heading_size="mh-font-size-l" heading_tag="h2" heading_color="mh-color-white" heading_font_family="" heading_subheading_color="" heading_text="WordPress Omnibar Search" heading_subheading="" heading_image_id="" css=".vc_custom_1521554777486{margin-bottom: 24px !important;}"][mh_idx_omnibar][/vc_column][/vc_row][vc_row css=".vc_custom_1522867644845{padding-top: 39px !important;padding-bottom: 24px !important;}"][vc_column][mh_heading heading_style="mh-heading--bottom-separator" heading_align="" heading_font_weight="700" heading_size="" heading_tag="h2" heading_color="" heading_font_family="" heading_subheading_color="" heading_text="Featured Properteis" heading_subheading="" heading_image_id="" css=""][mh_idx_widget widget="//myhometheme.idxbroker.com/idx/carousel.php?widgetid=1"][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1523027644029{padding-top: 39px !important;padding-bottom: 24px !important;background-color: #f4f4f4 !important;}"][vc_column css=".vc_custom_1522867158516{padding-top: 24px !important;padding-bottom: 24px !important;}"][mh_heading heading_style="mh-heading--bottom-separator" heading_align="" heading_font_weight="700" heading_size="" heading_tag="h2" heading_color="" heading_font_family="" heading_subheading_color="" heading_text="Miami For Rent" heading_subheading="You can define properties that will be displayed here" heading_image_id="" css=""][mh_idx_widget widget="//idx.myhometheme.net/idx/carousel.php?widgetid=1" carousel_card_bg="#ffffff" carousel_width="300"][/vc_column][/vc_row][vc_row css=".vc_custom_1522867644845{padding-top: 39px !important;padding-bottom: 24px !important;}"][vc_column][mh_heading heading_style="mh-heading--bottom-separator" heading_align="" heading_font_weight="700" heading_size="" heading_tag="h2" heading_color="" heading_font_family="" heading_subheading_color="" heading_text="Map" heading_subheading="" heading_image_id="" css=""][mh_idx_widget widget="//myhometheme.idxbroker.com/idx/mapwidgetjs.php?widgetid=1"][/vc_column][/vc_row][vc_row css=".vc_custom_1522867552012{padding-top: 39px !important;padding-bottom: 24px !important;}"][vc_column][mh_heading heading_style="mh-heading--bottom-separator" heading_align="" heading_font_weight="700" heading_size="" heading_tag="h2" heading_color="" heading_font_family="" heading_subheading_color="" heading_text="IDX Search Form Horizontal" heading_subheading="" heading_image_id="" css=""][mh_idx_widget widget="//idx.myhometheme.net/idx/quicksearchjs.php?widgetid=1" quick_search_type="horizontal"][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1522867390900{padding-bottom: 24px !important;background-color: #f4f4f4 !important;}"][vc_column css=".vc_custom_1522867542159{padding-top: 39px !important;padding-bottom: 24px !important;}"][mh_heading heading_style="mh-heading--bottom-separator" heading_align="" heading_font_weight="700" heading_size="" heading_tag="h2" heading_color="" heading_font_family="" heading_subheading_color="" heading_text="Testimonials" heading_subheading="" heading_image_id="" css=""][mh_carousel_testimonials owl_visible="owl-carousel--visible-1" style="mh-testimonials--standard" color="mh-testimonials--dark" owl_dots="" owl_auto_play="true"][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1533214848883{padding-bottom: 24px !important;background-color: #ffffff !important;}"][vc_column css=".vc_custom_1522867542159{padding-top: 39px !important;padding-bottom: 24px !important;}"][mh_heading heading_style="mh-heading--bottom-separator" heading_align="" heading_font_weight="700" heading_size="" heading_tag="h2" heading_color="" heading_font_family="" heading_subheading_color="" heading_text="Articles" heading_subheading="" heading_image_id="" css=""][mh_carousel_post owl_visible="owl-carousel--visible-3" posts_limit="5" read_more_text="Read more" posts_style="" owl_dots="owl-carousel--no-dots" owl_auto_play="" more_page_text="Visit Blog" more_page="1721"][/vc_column][/vc_row][vc_row][vc_column][mh_heading heading_style="mh-heading--bottom-separator" heading_align="" heading_font_weight="700" heading_size="" heading_tag="h2" heading_color="" heading_font_family="" heading_subheading_color="" heading_text="Partners" heading_subheading="" heading_image_id="" css=""][mh_carousel_clients owl_visible="owl-carousel--visible-5" owl_auto_play="true"][/vc_column][/vc_row]'
			),
			array(
				'idx_name'      => '',
				'page_template' => 'page_right-sidebar.php',
				'title'         => 'IDX - Global Wrapper',
				'content'       => '[vc_row][vc_column][mh_idx_wrapper type="basic"][/vc_column][/vc_row]'
			),
			array(
				'idx_name'      => 'My Account',
				'page_template' => 'page_right-sidebar.php',
				'title'         => 'IDX - My Account',
				'content'       => '[vc_row][vc_column][mh_idx_wrapper type="my_account" template_my_account="myaccount" template_my_account_version_myaccount="1000"][/vc_column][/vc_row]',
			),
			array(
				'idx_name'      => 'User Login',
				'page_template' => 'page_right-sidebar.php',
				'title'         => 'IDX - User login',
				'content'       => '[vc_row][vc_column][mh_idx_wrapper type="user_login" template_user_login="userlogin" template_user_login_version_userlogin="1001"][/vc_column][/vc_row]'
			),
			array(
				'idx_name'      => 'User Signup',
				'page_template' => 'page_right-sidebar.php',
				'title'         => 'IDX - User Signup',
				'content'       => '[vc_row][vc_column][mh_idx_wrapper type="user_signup" template_user_signup="usersignup" template_user_signup_version_usersignup="1002"][/vc_column][/vc_row]'
			),
			array(
				'idx_name'      => 'Results',
				'page_template' => 'page_right-sidebar.php',
				'title'         => 'IDX - Results',
				'content'       => '[vc_row][vc_column][mh_idx_wrapper type="results" template_results="mobileFirstResults" template_results_version_mobileFirstResults="1006"][/vc_column][/vc_row]'
			),
			array(
				'idx_name'      => 'Address',
				'page_template' => 'page_right-sidebar.php',
				'title'         => 'IDX - Address',
				'content'       => '[vc_row][vc_column][mh_idx_wrapper type="search_page" template_search_page="searchStandard" template_search_page_version_searchStandard="1002"][/vc_column][/vc_row]'
			),
			array(
				'idx_name'      => 'Advanced Search',
				'page_template' => 'page_right-sidebar.php',
				'title'         => 'IDX - Advanced Search',
				'content'       => '[vc_row][vc_column][mh_idx_wrapper type="search_page" template_search_page="searchBase" template_search_page_version_searchBase="1005" template_search_page_version_searchbase="1005"][/vc_column][/vc_row]'
			),
			array(
				'idx_name'      => 'Basic Search',
				'page_template' => 'page_right-sidebar.php',
				'title'         => 'IDX - Basic Search',
				'content'       => '[vc_row][vc_column][mh_idx_wrapper type="search_page" template_search_page="searchBase" template_search_page_version_searchBase="1005"][/vc_column][/vc_row]'
			),
			array(
				'idx_name'      => 'Browse by City',
				'page_template' => 'page_right-sidebar.php',
				'title'         => 'IDX - Browse by City',
				'content'       => '[vc_row][vc_column][mh_idx_wrapper type="browser_by_city"][/vc_column][/vc_row]'
			),
			array(
				'idx_name'      => 'Contact',
				'page_template' => 'page_right-sidebar.php',
				'title'         => 'IDX - Contact',
				'content'       => '[vc_row][vc_column][mh_idx_wrapper type="contact" template_contact="contact" template_contact_version_contact="1004"][/vc_column][/vc_row]'
			),
			array(
				'idx_name'      => 'Roster',
				'page_template' => 'page_right-sidebar.php',
				'title'         => 'IDX - Roster',
				'content'       => '[vc_row][vc_column][mh_idx_wrapper type="roster" template_roster="mobileFirstRoster" template_roster_version_mobileFirstRoster="1001"][/vc_column][/vc_row]'
			),
			array(
				'idx_name'      => 'Featured',
				'page_template' => 'page_full-width.php',
				'title'         => 'IDX - Featured',
				'content'       => '[vc_row css=".vc_custom_1522084297089{margin-top: 0px !important;margin-right: 0px !important;margin-bottom: 0px !important;margin-left: 0px !important;border-top-width: 0px !important;border-right-width: 0px !important;border-bottom-width: 0px !important;border-left-width: 0px !important;padding-top: 0px !important;padding-right: 0px !important;padding-bottom: 0px !important;padding-left: 0px !important;}"][vc_column css=".vc_custom_1522084313312{margin-top: 0px !important;padding-top: 18px !important;padding-right: 18px !important;padding-bottom: 18px !important;padding-left: 18px !important;background-color: #f4f4f4 !important;}"][vc_column_text css=".vc_custom_1521661044016{margin-bottom: 0px !important;padding-bottom: 0px !important;}"]
<p style="font-size: 21px;">How the adventure ended will be seen anon. Aouda was anxious, though she said nothing. As for Passepartout, he thought Mr. Fogg’s manoeuvre simply glorious. The captain had said “between eleven and twelve knots,” and the Henrietta confirmed his prediction.</p>
[/vc_column_text][/vc_column][/vc_row][vc_row][vc_column][mh_idx_wrapper type="results" template_results="mobileFirstResults" template_results_version_mobileFirstResults="1006" template_results_version_mobilefirstresults="1006"][/vc_column][/vc_row]'
			),
			array(
				'idx_name'      => 'Mortgage Calculator',
				'page_template' => 'page_right-sidebar.php',
				'title'         => 'IDX - Mortgage Calculator',
				'content'       => '[vc_row][vc_column][mh_idx_wrapper type="mortgage_calculator" template_mortgage_calculator="mobileFirstMortgage" template_mortgage_calculator_version_mobileFirstMortgage="1002" template_mortgage_calculator_version_mobilefirstmortgage="1002"][/vc_column][/vc_row]'
			),
			array(
				'idx_name'      => 'Map Search',
				'page_template' => 'page_right-sidebar.php',
				'title'         => 'IDX - Map Search',
				'content'       => '[vc_row][vc_column][mh_idx_wrapper type="map_search_page" template_map_search_page="mapsearch" template_map_search_page_version_mapsearch="1000"][/vc_column][/vc_row]'
			),
			array(
				'idx_name'      => 'Email Update Signup',
				'page_template' => 'page_right-sidebar.php',
				'title'         => 'IDX - Email Update Signup',
				'content'       => '[vc_row][vc_column][mh_idx_wrapper type="search_page" template_search_page="searchBase" template_search_page_version_searchBase="1005" template_search_page_version_searchbase="1005"][/vc_column][/vc_row]'
			),
			array(
				'idx_name'      => 'Photo Gallery',
				'page_template' => 'page_right-sidebar.php',
				'title'         => 'IDX - Photo Gallery',
				'content'       => '[vc_row][vc_column][mh_idx_wrapper type="photo_gallery" template_photo_gallery="photogallery" template_photo_gallery_version_photogallery="1002" template_search_page_version_searchbase="1005"][/vc_column][/vc_row]'
			),
			array(
				'idx_name'      => 'Listing ID',
				'page_template' => 'page_right-sidebar.php',
				'title'         => 'IDX - Listing ID',
				'content'       => '[vc_row][vc_column][mh_idx_wrapper type="search_page" template_search_page="searchBase" template_search_page_version_searchBase="1005"][/vc_column][/vc_row]'
			),
			array(
				'idx_name'      => 'Home Valuation',
				'page_template' => 'page_full-width.php',
				'title'         => 'IDX - Home Valuation',
				'content'       => '[vc_row][vc_column][mh_idx_wrapper type="contact" template_contact="contact" template_contact_version_contact="1004"][/vc_column][/vc_row]'
			),
			array(
				'idx_name'      => 'Homes For Sale',
				'page_template' => 'page_right-sidebar.php',
				'title'         => 'IDX - Homes For Sale',
				'content'       => '[vc_row][vc_column][mh_idx_wrapper type="basic"][/vc_column][/vc_row]'
			),
			array(
				'idx_name'      => 'Property Updates',
				'page_template' => 'page_right-sidebar.php',
				'title'         => 'IDX - Property Updates',
				'content'       => '[vc_row][vc_column][mh_idx_wrapper type="search_page" template_search_page="searchBase" template_search_page_version_searchBase="1005"][/vc_column][/vc_row]'
			),
			array(
				'idx_name'      => 'More Info',
				'page_template' => 'page_right-sidebar.php',
				'title'         => 'IDX - More Info',
				'content'       => '[vc_row][vc_column][mh_idx_wrapper type="more_info" template_more_info="contact" template_more_info_version_contact="1004"][/vc_column][/vc_row]'
			),
			array(
				'idx_name'      => 'Schedule Showing',
				'page_template' => 'page_right-sidebar.php',
				'title'         => 'IDX - Schedule Showing',
				'content'       => '[vc_row][vc_column][mh_idx_wrapper type="more_info" template_more_info="contact" template_more_info_version_contact="1004"][/vc_column][/vc_row]'
			),
			array(
				'idx_name'      => 'Sold/Pending',
				'page_template' => 'page_right-sidebar.php',
				'title'         => 'IDX - Sold/Pending',
				'content'       => '[vc_row][vc_column][mh_idx_wrapper type="results" template_results="mobileFirstResults" template_results_version_mobileFirstResults="1006" template_search_page_version_searchbase="1005"][/vc_column][/vc_row]'
			),
			array(
				'idx_name'      => 'Featured Open Houses',
				'page_template' => 'page_right-sidebar.php',
				'title'         => 'IDX - Featured Open Houses',
				'content'       => '[vc_row][vc_column][mh_idx_wrapper type="results" template_results="mobileFirstResults" template_results_version_mobileFirstResults="1006" template_search_page_version_searchbase="1005"][/vc_column][/vc_row]'
			),
			array(
				'idx_name'      => 'Featured Virtual Tours',
				'page_template' => 'page_right-sidebar.php',
				'title'         => 'IDX - Featured Virtual Tours',
				'content'       => '[vc_row][vc_column][mh_idx_wrapper type="results" template_results="mobileFirstResults" template_results_version_mobileFirstResults="1006" template_search_page_version_searchbase="1005"][/vc_column][/vc_row]'
			),
			array(
				'idx_name'      => 'Supplemental',
				'page_template' => 'page_right-sidebar.php',
				'title'         => 'IDX - Supplemental',
				'content'       => '[vc_row][vc_column][mh_idx_wrapper type="results" template_results="mobileFirstResults" template_results_version_mobileFirstResults="1006" template_search_page_version_searchbase="1005"][/vc_column][/vc_row]'
			),
			array(
				'idx_name'      => 'Agent Bio & Listings',
				'page_template' => 'page_right-sidebar.php',
				'title'         => 'IDX - Agent Bio & Listings',
				'content'       => '[vc_row][vc_column][mh_idx_wrapper type="results" template_results="mobileFirstResults" template_results_version_mobileFirstResults="1006"][/vc_column][/vc_row]'
			),
			array(
				'idx_name'      => 'Details',
				'page_template' => 'page_right-sidebar.php',
				'title'         => 'IDX - Details',
				'content'       => '[vc_row][vc_column][mh_idx_wrapper type="details" template_details="detailsDynamic" template_details_version_detailsDynamic="1008" template_results_version_mobilefirstresults="1006"][/vc_column][/vc_row]'
			),
			array(
				'idx_name'      => 'Property Updates',
				'page_template' => 'page_blank.php',
				'title'         => 'IDX - Property Updates',
				'content'       => '[vc_row][vc_column][mh_idx_wrapper type="basic" template_results_version_mobilefirstresults="1006"][/vc_column][/vc_row]'
			),
		);

		$api          = new Api();
		$pages_saved  = $api->get_saved_links();
		$pages_system = $api->get_system_links();

		foreach ( $wp_pages as $wp_page ) {
			$post_id = wp_insert_post( array(
				'post_title'   => $wp_page['title'],
				'post_content' => $wp_page['content'],
				'post_type'    => 'page',
				'post_author'  => get_current_user_id(),
				'post_status'  => 'publish'
			) );

			if ( ! empty( $wp_page['page_template'] ) ) {
				update_post_meta( $post_id, '_wp_page_template', $wp_page['page_template'] );
			}

			if ( empty( $wp_page['idx_name'] ) ) {
				continue;
			}

			foreach ( $pages_saved as $page ) {
				if ( $page['name'] != $wp_page['idx_name'] ) {
					continue;
				}

				$temp = explode( '-', $page['uid'] );
				$data = array(
					'dynamicURL'  => get_the_permalink( $post_id ),
					'savedLinkID' => $temp[1]
				);
				update_post_meta( $post_id, 'idx_broker_wrapper_type', 'saved_link' );
				update_post_meta( $post_id, 'idx_broker_saved_link_id', $temp[1] );
				break;
			}

			if ( ! isset( $data ) ) {
				foreach ( $pages_system as $page ) {
					if ( $page['name'] != $wp_page['idx_name'] ) {
						continue;
					}

					$temp = explode( '-', $page['uid'] );
					$data = array(
						'dynamicURL' => get_the_permalink( $post_id ),
						'pageID'     => $temp[1]
					);
					update_post_meta( $post_id, 'idx_broker_wrapper_type', 'page' );
					update_post_meta( $post_id, 'idx_broker_page_id', $temp[1] );
					break;
				}
			}

			if ( isset( $data ) ) {
				$api->update_wrapper( $data );
			}
			$data = null;
		}

		update_option( 'myhome_idx_broker_auto_setup', 1 );
		wp_redirect( admin_url( 'admin.php?page=myhome_idx_broker' ) );
		die();
	}

}
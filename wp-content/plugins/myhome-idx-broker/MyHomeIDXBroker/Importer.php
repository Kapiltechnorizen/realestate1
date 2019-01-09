<?php

namespace MyHomeIDXBroker;


/**
 * Class Importer
 * @package MyHomeIDXBroker
 */
class Importer {

	const LAST_CHECK = 'myhome_idx_broker_last_check';
	const CURRENT_STATUS = 'myhome_idx_broker_current_status';
	const STATUS_STOP = 'stop';
	const STATUS_WORK = 'work';
	const JOBS = 'myhome_idx_broker_jobs';
	const CRON_JOB = 'myhome_idx_broker_cron_job';
	const CRON_JOB_INIT = 'myhome_idx_broker_cron_init';
	const CRON_JOB_TASK = 'myhome_idx_broker_cron_task';
	const CRON_JOB_THUMBNAILS = 'myhome_idx_broker_cron_thumbnails';
	const CRON_HASH = 'myhome_idx_broker_hash';

	public function import() {
		$status = get_option( Importer::CURRENT_STATUS, Importer::STATUS_STOP );
		if ( $status == Importer::STATUS_WORK ) {
			$this->job();
		}
	}

	public function init() {
		$api                 = new Api();
		$properties_active   = $api->get_new_active_properties();
		$disable_sold_import = My_Home_IDX_Broker()->options->get( 'disable_sold_import' );
		if ( ! empty( $disable_sold_import ) ) {
			$properties_sold_pending = [];
		} else {
			$properties_sold_pending = $api->get_sold_pending_properties();
		}
		$properties = array_merge( $properties_active, $properties_sold_pending );

		update_option( Importer::JOBS, $properties );
		update_option( Importer::LAST_CHECK, date( "Y-m-d h:i:s" ) );

		$mls_ids = array();
		if ( ! empty( $properties ) ) {
			foreach ( $properties as $property ) {
				$mls_ids[] = $property['listingID'];
			}
			$this->check_active( $mls_ids );

			update_option( Importer::CURRENT_STATUS, Importer::STATUS_WORK );
			echo json_encode( array(
				'start' => true,
				'found' => count( $properties ),
				'msg'   => esc_html__( 'Please wait synchronizing data', 'myhome-idx-broker' )
			) );
		} else {
			update_option( Importer::CURRENT_STATUS, Importer::STATUS_STOP );

			global $idx_broker_limit;
			if ( ! is_null( $idx_broker_limit ) && $idx_broker_limit ) {
				$msg = esc_html__( 'Account is over it\'s hourly access limit.', 'myhome-idx-broker' );
			} else {
				$msg = esc_html__( 'Nothing new', 'myhome-idx-broker' );
			}
			echo json_encode( array(
				'start' => false,
				'msg'   => $msg
			) );
		}
	}

	public function check_active( $mlsIds ) {
		$query = new \WP_Query( array(
			'post_type'      => 'estate',
			'posts_per_page' => - 1,
			'post_status'    => 'publish'
		) );

		foreach ( $query->posts as $post ) {
			$mlsId = get_post_meta( $post->ID, Properties::IDX_LISTING_ID, true );
			if ( empty( $mlsId ) ) {
				continue;
			}

			if ( ! in_array( $mlsId, $mlsIds ) ) {
				wp_update_post( array(
					'ID'          => $post->ID,
					'post_status' => 'draft'
				) );
			}
		}
	}

	public function job() {
		$properties = get_option( Importer::JOBS );
		if ( empty( $properties ) || ! is_array( $properties ) ) {
			update_option( Importer::CURRENT_STATUS, Importer::STATUS_STOP );

			return false;
		}

		$property           = array_shift( $properties );
		$properties_manager = new Properties();

		if ( ! $properties_manager->exists( $property['listingID'] ) ) {
			$properties_manager->create( $property );
		} else {
			$properties_manager->update( $property );
		}

		update_option( Importer::JOBS, $properties );

		if ( empty( $properties ) ) {
			update_option( Importer::CURRENT_STATUS, Importer::STATUS_STOP );
			update_option( Importer::CRON_JOB, Importer::STATUS_STOP );
		}

		return true;
	}

	public function cron() {
		$current_job = get_option( Importer::CRON_JOB, Importer::CRON_JOB_INIT );
		$importer    = new Importer();

		switch ( $current_job ) {
			case Importer::CRON_JOB_INIT:
				$importer->init();
				update_option( Importer::CRON_JOB, Importer::CRON_JOB_TASK );
				break;
			case Importer::CRON_JOB_TASK:
				$importer->job();
				break;
			case Importer::CRON_JOB_THUMBNAILS;
				if ( ! $importer->generate_thumbnails( true ) ) {
					update_option( Importer::CRON_JOB, Importer::CRON_JOB_TASK );
				}
				break;
		}
	}

	public function generate_thumbnails( $is_cron = false ) {
		$images     = get_option( Properties::IDX_GENERATE_THUMBNAILS );
		$attachment = array_pop( $images );

		Properties::generate_thumbnails( $attachment );

		update_option( Properties::IDX_GENERATE_THUMBNAILS, $images );

		$next = empty( $images ) ? false : true;

		if ( ! $is_cron ) {
			echo json_encode( array( 'next' => $next ) );
		}

		return $next;
	}

}
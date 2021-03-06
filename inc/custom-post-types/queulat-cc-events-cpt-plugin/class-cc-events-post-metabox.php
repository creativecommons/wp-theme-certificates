<?php

use Queulat\Metabox;
use Queulat\Forms\Node_Factory;
use Queulat\Forms\Element\Input_Url;
use Queulat\Forms\Element\WP_Editor;
use Queulat\Forms\Element\Input_Text;
use Queulat\Forms\Element\Select;

class Event_Metabox extends Metabox {


	public function __construct( $id = '', $title = '', $post_type = '', array $args = array() ) {
		parent::__construct( $id, $title, $post_type, $args );
		add_action( "{$this->get_id()}_metabox_data_updated", array( $this, 'data_updated' ), 10, 2 );
	}
	public function data_updated( $data, $post_id ) {
		$dtstart = DateTime::createFromFormat( 'Y-m-d H:i', $data['dtstart_date'] . ' ' . $data['dtstart_time'] );
		$dtend   = DateTime::createFromFormat( 'Y-m-d H:i', $data['dtstart_date'] . ' ' . $data['dtend_time'] );
		if ( $dtstart ) {
			update_post_meta( $post_id, 'event_dtstart', $dtstart->format( 'Y-m-d H:i:s' ) );
		}
		if ( $dtend ) {
			update_post_meta( $post_id, 'event_dtend', $dtend->format( 'Y-m-d H:i:s' ) );
		}
		return true;
	}
	public function get_site_courses() {
		$courses      = new WP_Query(
			array(
				'post_type'      => 'cc_course',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
			)
		);
		$return_array = array( '' => 'Select a Course' );
		if ( $courses->have_posts() ) {
			foreach ( $courses->posts as $course ) {
				$return_array[ $course->ID ] = get_the_title( $course->ID );
			}
		} else {
			return false;
		}
		return $return_array;
	}
	public function get_fields(): array {
		return array(
			Node_Factory::make(
				Select::class,
				array(
					'name'       => 'related_course',
					'label'      => 'Related courses',
					'attributes' => array(
						'class' => 'widefat',
					),
					'properties' => array(
						'description' => 'If this event is related to a course please select',
					),
					'options'    => $this->get_site_courses(),
				)
			),
			Node_Factory::make(
				Input_Text::class,
				array(
					'name'       => 'location',
					'label'      => 'Location',
					'attributes' => array(
						'class'    => 'regular-text',
						'required' => 'required',
					),
				)
			),
			Node_Factory::make(
				Input_Text::class,
				array(
					'name'       => 'dtstart_date',
					'label'      => 'Date',
					'attributes' => array(
						'class'    => 'regular-text',
						'required' => 'required',
						'type'     => 'date',
					),
				)
			),
			Node_Factory::make(
				Input_Text::class,
				array(
					'name'       => 'dtstart_time',
					'label'      => 'Start time',
					'attributes' => array(
						'class'    => 'regular-text',
						'required' => 'required',
						'type'     => 'time',
					),
				)
			),
			Node_Factory::make(
				Input_Text::class,
				array(
					'name'       => 'dtend_time',
					'label'      => 'End time',
					'attributes' => array(
						'class'    => 'regular-text',
						'required' => 'required',
						'type'     => 'time',
					),
				)
			),
			Node_Factory::make(
				Input_Text::class,
				array(
					'name'       => 'signups',
					'label'      => 'Signup Url',
					'attributes' => array(
						'class' => 'regular-text',
					),
				)
			),
			Node_Factory::make(
				Input_Url::class,
				array(
					'name'       => 'url',
					'label'      => 'Event Url',
					'attributes' => array(
						'class' => 'regular-text',
					),
				)
			),
		);
	}
	public function sanitize_data( array $data ): array {
		$sanitized = array();
		foreach ( $data as $key => $val ) {
			switch ( $key ) {
				case 'location':
				case 'signups':
					$sanitized[ $key ] = sanitize_text_field( $val );
					break;
				case 'dtstart_date':
					$dtstart = DateTime::createFromFormat( 'Y-m-d', $val );
					if ( $dtstart instanceof \DateTime ) {
						$sanitized[ $key ] = $dtstart->format( 'Y-m-d' );
					}
					break;
				case 'dtstart_time':
				case 'dtend_time':
					   $time = DateTime::createFromFormat( 'Y-m-d H:i', date_i18n( 'Y-m-d' ) . ' ' . $val );
					if ( $time instanceof \DateTime ) {
						$sanitized[ $key ] = $time->format( 'H:i' );
					}
					break;
				case 'url':
				case 'featured_url':
					$sanitized[ $key ] = esc_url_raw( $val );
					break;
				case 'description':
					$sanitized[ $key ] = wp_kses_post( $val );
					break;
			}
		}
		return $sanitized;
	}
}

new Event_Metabox( 'event', 'Event Related Data', 'cc_events', array( 'context' => 'normal' ) );

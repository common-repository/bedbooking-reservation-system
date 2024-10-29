<?php

/**
 * This class handles requests to bedbooking api and caches responses
 *
 * @link       https://bed-booking.com
 * @since      1.0.0
 *
 * @package    Bed_Booking
 * @subpackage Bed_Booking/includes
 */

/**
 * Handles requests.
 *
 * This class handles requests to bedbooking api and caches responses.
 *
 * @since      1.0.0
 * @package    Bed_Booking
 * @subpackage Bed_Booking/includes
 * @author     Dawid Wasylkiewicz <dawidw@dev-effectivity.pl>
 */
class Bed_Booking_Request {

    /**
     * Initialize the collections used to maintain the actions and filters.
     *
     * @since    1.0.0
     */
    public function __construct() {

    }

    /**
     * Used to get current Bedbooking calendar id set by user.
     *
     * @since    1.0.0
     */
    public function get_bedbooking_calendar() {
        $calendar_id = get_transient( 'bed_booking_calendar_id');
        if(!$calendar_id && get_option('bed_booking_access_token')) {
            $calendar = $this->request(BEDBOOKING_API_URL.'/api/v2/calendar/index')[0];
            if($calendar) $calendar_id = $calendar['id_calendar'];
            set_transient( 'bed_booking_calendar_id', $calendar_id, 60 * 60 );

        }

        return $calendar_id;
    }

    /**
     * Used to get current Bedbooking user.
     *
     * @since    1.0.0
     */
    public function get_bedbooking_user() {
        $user = get_transient( 'bed_booking_user');
        if(!$user && get_option('bed_booking_access_token')) {
            $user = $this->request(BEDBOOKING_API_URL.'/api/v2/user/index')[0];
            set_transient( 'bed_booking_user', $user, 60 * 60 );
        }

        return $user;
    }

    /**
     * Used to get current Bedbooking user's object.
     *
     * @since    1.0.0
     */
    public function get_bedbooking_object() {
        $object = get_transient('bed_booking_object');
        $calendar_id = $this->get_bedbooking_calendar();
        if(!$object && get_option('bed_booking_access_token')) {

            $object = $this->request(BEDBOOKING_API_URL.'/api/v2/object/index/id_calendar/'.$calendar_id)[0];

            if($object) {
                set_transient( 'bed_booking_object', $object, 60 * 60 );
            }

        }
        return $object;
    }

    /**
     * Used to get current Bedbooking user widget settings.
     *
     * @since    1.0.0
     */
    public function get_bedbooking_widget_settings() {
        $object = $this->get_bedbooking_object();

        $widget_settings = get_transient('bed_booking_widget_settings');
        if(!$widget_settings && get_option('bed_booking_access_token')) {
            $widget_settings = $this->request(BEDBOOKING_API_URL.'/api/v2/widget/index/id_object/'.$object['id']);
                if($widget_settings) $widget_settings = $widget_settings[0];
                else return false;
            set_transient( 'bed_booking_widget_settings', $widget_settings, 30 );
        }
        return $widget_settings;
    }

     /**
     * Used to get current Bedbooking user license.
     *
     * @since    1.0.0
     */
    public function get_bedbooking_license() {

        $license = get_transient('bed_booking_license');
        if(!$license && get_option('bed_booking_access_token')) {
            $license = $this->request(BEDBOOKING_API_URL.'/api/v2/license/index/');
                if($license) $license = $license[0]['license'];
                else return false;
            set_transient( 'bed_booking_license', $license, 60 );
        }
        return $license;
    }

    /**
     * Used to get current Bedbooking user's room.
     *
     * @since    1.0.0
     */

    public function get_bedbooking_rooms() {
        $calendar_id = $this->get_bedbooking_calendar();
        $rooms = get_transient('bed_booking_rooms');
        if(!$rooms && get_option('bed_booking_access_token')) {
            $rooms = $this->request(BEDBOOKING_API_URL.'/api/v2/room/index/id_calendar/' . $calendar_id . '/page_size/500');
            set_transient( 'bed_booking_rooms', $rooms, 60 );
        }
        return $rooms;
    }

    private function request($url){
        $args = array(
            'headers' => array(
                    'Authorization' => 'Bearer ' . get_option('bed_booking_access_token')
            )
        );

        $response = wp_remote_get( esc_url($url), $args );
        $http_code = wp_remote_retrieve_response_code( $response );

        if($http_code == 401){
            delete_option( 'bed_booking_access_token' );
            return false;
        }

        $body = wp_remote_retrieve_body( $response );
        return json_decode($body, true)['items'];
    }
}

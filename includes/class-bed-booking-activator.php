<?php

/**
 * Fired during plugin activation
 *
 * @link       https://bed-booking.com
 * @since      1.0.0
 *
 * @package    Bed_Booking
 * @subpackage Bed_Booking/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Bed_Booking
 * @subpackage Bed_Booking/includes
 * @author     Dawid Wasylkiewicz <dawidw@dev-effectivity.pl>
 */
class Bed_Booking_Activator {

	/**
	 * This function registers holder for Bedbooking user access token.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        add_option('bed_booking_access_token', '');
	}

}

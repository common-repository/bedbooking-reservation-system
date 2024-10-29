<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link       https://bed-booking.com
 * @since      1.0.0
 * @package    Bed_Booking
 *
 * @wordpress-plugin
 * Plugin Name:       BedBooking - Reservation System and Booking Calendar
 * Description:       BedBooking is the most modern tool that allows your phone, tablet or computer to become your mobile Booking Calendar. The Reservation System will allow you to sell your accommodation directly over the Internet.
 * Version:           1.0.3
 * Author:            BedBooking
 * Requires at least: 5.2
 * Requires PHP:      7.3
 * Author URI:        https://bed-booking.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       bed-booking
 */

defined( 'ABSPATH' ) || exit;
// Define environment variables
define('BEDBOOKING_LOGIN_URL', 'https://app.bed-booking.com/login');
define('BEDBOOKING_API_URL', 'https://api.bed-booking.com');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bed-booking-activator.php
 */
function activate_bed_booking_plugin() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-bed-booking-activator.php';
    Bed_Booking_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bed-booking-deactivator.php
 */
function deactivate_bed_booking_plugin() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-bed-booking-deactivator.php';
    Bed_Booking_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_bed_booking_plugin' );
register_deactivation_hook( __FILE__, 'deactivate_bed_booking_plugin' );


require plugin_dir_path( __FILE__ ) . 'includes/class-bed-booking.php';


function run_bed_booking() {

    $plugin = new Bed_Booking();
    $plugin->run();

}

run_bed_booking();

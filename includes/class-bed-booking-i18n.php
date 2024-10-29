<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://bed-booking.com
 * @since      1.0.0
 *
 * @package    Bed_Booking
 * @subpackage Bed_Booking/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Bed_Booking
 * @subpackage Bed_Booking/includes
 * @author     Dawid Wasylkiewicz <dawidw@dev-effectivity.pl>
 */
class Bed_Booking_i18n {

    /**
     * The unique identifier of language.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $lang    The string used to uniquely identify current language.
     */
    protected $lang;

    /**
     * The unique identifier of default language used when translation cannot be found for wp lang.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $defaultLang    The string used to uniquely identify current language.
     */
    protected $defaultLang = 'en_GB';

    /**
     * Initialize the i18n.
     *
     * @since    1.0.0
     */
    public function __construct($lang) {
        $this->lang = $lang;
    }

    /**
     * Translates string key.
     *
     * @since    1.0.0
     * @param    string               $slug             The string identifying translation key.
     */
    public function translate($slug) {
        return __($slug, 'bed-booking');
    }

    /**
     * Loads translations and check if translation object exist for wp language.
     *
     * @since    1.0.0
     *
     */
    public function load_plugin_textdomain() {
        if ( file_exists( plugin_dir_path( dirname( __FILE__ ) ) .  'languages/bed-booking-' . $this->lang . '.mo'  ) ) {
            load_textdomain( 'bed-booking', plugin_dir_path( dirname( __FILE__ ) ) .  'languages/bed-booking-' . $this->lang . '.mo'  );
        } else {
            load_textdomain('bed-booking', plugin_dir_path( dirname( __FILE__ ) ) .  'languages/bed-booking-en_US.mo' );
        }
    }
}

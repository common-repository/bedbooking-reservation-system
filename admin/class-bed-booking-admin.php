<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://bed-booking.com
 * @since      1.0.0
 *
 * @package    Bed_Booking
 * @subpackage Bed_Booking/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Bed_Booking
 * @subpackage Bed_Booking/admin
 * @author     Dawid Wasylkiewicz <dawidw@dev-effectivity.pl>
 */
class Bed_Booking_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/bed-booking-admin-display.php';

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

    /**
     * Register the navigation menu element for the plugin.
     *
     * @since    1.0.0
     */
    public function bed_booking_add_nav_items(){
        $i18n = new Bed_Booking_i18n(get_locale());
        $request = new Bed_Booking_Request();
        $license = $request->get_bedbooking_license();
        $user = $request->get_bedbooking_user();
        if($user) $premium = $user['user_price_group'] == '1' && ($license && $license > time());

        add_menu_page(
            'BedBooking',
            get_option('bed_booking_access_token') && $premium? 'BedBooking' :sprintf('BedBooking <span class="awaiting-mod">%s</span>', '!') ,
            'manage_options',
            'bed-booking',
            'bed_booking_info_page_html',
            'data:image/svg+xml;base64,' . base64_encode(file_get_contents(plugin_dir_path( dirname( __FILE__ ) ) . 'images/bb-logo.svg')),
            98
        );

        add_submenu_page(
            'bed-booking',
            $i18n->translate('BBO_2891_menu_booking_engine'),
            $i18n->translate('BBO_2891_menu_booking_engine'),
            'manage_options',
            'bed-booking-system',
            'bed_booking_info_page_html'
        );

        remove_submenu_page('bed-booking','bed-booking');

    }

   	/**
   	 * Register editor blocks.
   	 *
   	 * @since    1.0.0
   	 */
   	 public function register_editor_blocks() {
         $i18n = new Bed_Booking_i18n(get_locale());
         $request = new Bed_Booking_Request();
         $license = $request->get_bedbooking_license();
         $user = $request->get_bedbooking_user();
         $widget_settings = $request->get_bedbooking_widget_settings();
         $widget_api_key = null;
         if($widget_settings) $widget_api_key = $widget_settings['api_key'];
         if($user) $premium = $user['user_price_group'] == '1' && ($license && $license > time());

        if(get_option('bed_booking_access_token') && $premium){

             $rooms = [];
             if($request->get_bedbooking_rooms()){
                  $roomsFiltered = array_filter($request->get_bedbooking_rooms(), function ($room){ return $room['show_in_search'] == '1';});

                  foreach ($roomsFiltered as $room) {
                     $rooms[$room['id']] = $room['name'];
                  }
             }

             $common = [
                                 'containerId' => [
                                     'type' => 'string',
                                     'default' => '0',
                                     ],
                                 'widgetKey' => [
                                     'type' => 'string',
                                     'default' => $widget_api_key
                                     ]
                                ];

                      $translations = [
                          'BED_2188_add_details_body' => ['type' => 'string', 'default' => $i18n->translate('BED_2188_block_info')],
                          'BBO_2891_type_three' => ['type' => 'string', 'default' => $i18n->translate('BBO_2891_type_three')],
                          'BBO_963_select_room' => ['type' => 'string', 'default' => $i18n->translate('BBO_963_select_room')],
                          'BKO_1130_confirm' => ['type' => 'string', 'default' => $i18n->translate('BKO_1130_confirm')],
                          'OUT_3983_static_position_name' => ['type' => 'string', 'default' => $i18n->translate('OUT_3983_static_position_name')],
                          'OUT_3983_floating_position_name' => ['type' => 'string', 'default' => $i18n->translate('OUT_3983_floating_position_name')],
                          'BBO_2891_type_one' => ['type' => 'string', 'default' => $i18n->translate('BBO_2891_type_one')],
                          'OUT_3983_position_type_setting_title' => ['type' => 'string', 'default' => $i18n->translate('OUT_3983_position_type_setting_title')],
                          'OUT_3983_floating_position_description' => ['type' => 'string', 'default' => $i18n->translate('OUT_3983_floating_position_description')],
                          'OUT_3983_static_position_description' => ['type' => 'string', 'default' => $i18n->translate('OUT_3983_static_position_description')],
                      ];

                      $attributes = array_merge($common, $translations);

                      register_block_type( plugin_dir_path( __FILE__ ) . '../blocks/calendar/',  ['title' => $i18n->translate('BBO_2891_type_two'), 'attributes' => $attributes]);

                      register_block_type( plugin_dir_path( __FILE__ ) . '../blocks/room/', ['title' => $i18n->translate('BBO_2891_type_three'), 'attributes' => array_merge($attributes,
                      ['rooms' => [
                         'type' => 'array',
                         'default' =>  $rooms
                         ],
                     'room' => [
                         'type' => 'string',
                         'default' => array_key_first($rooms)
                          ],
                     'configured' => [
                         'type' => 'boolean',
                         'default' => false
                         ]
                     ])]);
                      register_block_type( plugin_dir_path( __FILE__ ) . '../blocks/search/', ['title' => $i18n->translate('BBO_2891_type_one'), 'attributes' => array_merge($attributes,
                      ['floating' => [
                        'type' => 'integer',
                        'default' => 0
                         ],
                      'configured' => [
                        'type' => 'boolean',
                        'default' => false
                     ]])]);

         }
   	 }

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bed_Booking_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bed_Booking_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bed-booking-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the blocks categories for the editor.
	 *
	 * @since    1.0.0
	 */
    function bed_booking_plugin_block_categories( $categories ) {
        return array_merge(
            [
                [
                    'slug'  => 'bed-booking',
                    'title' => 'BEDBOOKING',
                ],
            ],
            $categories
        );
    }

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bed_Booking_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bed_Booking_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
	    wp_enqueue_script( 'bed_booking_load_widget', plugin_dir_url( __FILE__ ) . '../js/loadWidget.js' );
	    wp_enqueue_script( 'bed_booking_accordion', plugin_dir_url( __FILE__ ) . '../js/accordion.js', [], false, true );
        wp_enqueue_script( 'bed_booking_init_widget', plugin_dir_url( __FILE__ ) . '../js/initWidget.js', [], false, true );

	}

}

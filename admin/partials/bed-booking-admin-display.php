<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://bed-booking.com
 * @since      1.0.0
 *
 * @package    Bed_Booking
 * @subpackage Bed_Booking/admin/partials
 */

function bed_booking_info_page_html() {
    $i18n = new Bed_Booking_i18n(get_locale());
    $request = new Bed_Booking_Request();
    $widget_settings = $request->get_bedbooking_widget_settings();
    $user = $request->get_bedbooking_user();
    $license = $request->get_bedbooking_license();
    $widget_api_key = null;
    if($widget_settings) $widget_api_key = $widget_settings['api_key'];

    $logged = get_option('bed_booking_access_token');
    if($user) $premium = $user['user_price_group'] == '1' && ($license && $license > time());

    ?>

    <div class="wrap">
        <h2 style="padding-bottom: 0px;"><?php echo $i18n->translate('BBO_2891_menu_booking_engine'); ?></h2>

        <div class="bb-grid-wrap">
            <div class="bb-grid-column">

                <?php

                    printf(        '<div class="card bb-card">
                                       <h2 class="title">%s</h2>


                                       <button class="bb-accordion"><div class="bb-accordion-header"><img class="bb-count-element" src="%s" alt="bb-1"/><p>%s</p></div><span class="bb-color dashicons dashicons-arrow-down-alt2 bb-icon-translation"></span></button>
                                       <div class="bb-panel">
                                         <div>%s</div>
                                         <div>%s</div>
                                         <div class="bb-qr-codes"><a href="%s" target="_blank"><img width="200" src="%s" alt="bb-google-play"/></a> <a href="%s" target="_blank"><img width="200" src="%s" alt="bb-apple-store"/></a></div>
                                       </div>

                                       <button class="bb-accordion" ><div class="bb-accordion-header"><img class="bb-count-element" src="%s" alt="bb-2"/><p>%s</p></div><span class="bb-color dashicons dashicons-arrow-down-alt2 bb-icon-translation"></span></button>
                                       <div class="bb-panel">
                                         <div>%s</div>
                                         <div>%s</div>
                                       </div>

                                       <button class="bb-accordion"><div class="bb-accordion-header"><img class="bb-count-element" src="%s" alt="bb-3"/><p>%s</p></div><span class="bb-color dashicons dashicons-arrow-down-alt2 bb-icon-translation"></span></button>
                                       <div class="bb-panel">
                                         <div>%s</div>
                                         <div style="padding-bottom: 15px;">%s</div>
                                       </div>

                                   </div>',
                           $i18n->translate('BED_2188_how_to_connect'),
                           plugin_dir_url( __FILE__ ) . '../../images/1kolko.svg',
                           $i18n->translate('BED_2188_create_account_title'),
                           $i18n->translate('BED_2188_plugin_description'),
                           $i18n->translate('BED_2188_create_account_body'),
                           'https://play.google.com/store/apps/details?id=com.rst.bedbooking',
                           plugin_dir_url( __FILE__ ) . '../../images/qrcodeandorid.svg',
                           'https://apps.apple.com/pl/app/bedbooking-booking-calendar/id826280602',
                           plugin_dir_url( __FILE__ ) . '../../images/qrcodeapple.svg',
                           plugin_dir_url( __FILE__ ) . '../../images/2kolko.svg',
                           $i18n->translate('BED_2188_add_details'),
                           $i18n->translate('BED_2188_add_details_body'),
                           $i18n->translate('BED_2188_add_details_body_2'),
                           plugin_dir_url( __FILE__ ) . '../../images/3kolko.svg',
                           $i18n->translate('BED_2188_login_title'),
                           $i18n->translate('BED_2188_login_body'),
                           $i18n->translate('BED_2188_login_body_2'),
                           );

                    if($logged){
                        if($premium && $widget_api_key){

                            printf('<div class="card bb-card"><h2 class="title">%s</h2><img src="%s" class="bb-check-big-icon" alt="bb-check-icon"/></div>',
                                    $i18n->translate('BED_2188_correct_title'),
                                    plugin_dir_url( __FILE__ ) . '../../images/check_big.svg');

                        } else if(!$premium) {

                            printf('<div class="card bb-card"><h2 class="title">%s</h2><img src="%s" class="bb-check-big-icon" alt="bb-x-big-icon"/><p>%s</p><p>%s</p></div>',
                                    $i18n->translate('BED_2188_error_title'),
                                    plugin_dir_url( __FILE__ ) . '../../images/x_big.svg',
                                    $i18n->translate('BED_2188_error_no_premium'),
                                    $i18n->translate('BED_2188_error_no_premium_2'));

                        } else if(!$widget_api_key) {

                            printf('<div class="card bb-card"><h2 class="title">%s</h2><img src="%s" class="bb-check-big-icon" alt="bb-x-big-icon"/><p>%s</p></div>',
                                    $i18n->translate('BED_2188_error_title'),
                                    plugin_dir_url( __FILE__ ) . '../../images/x_big.svg',
                                    $i18n->translate('BED_2188_error_outcome'));

                        }

                       printf('<div class="card bb-card"><h2 class="title">%s</h2><form method="POST"><input type="hidden" name="logout" value="1" /><button type="submit" class="bb-login-button button button-primary button-hero">%s</button></form></div>',
                               $i18n->translate('BED_2188_disconnect_account'),
                               $i18n->translate('BED_2188_logout'));

                    } else {

                        printf('<div class="card bb-card"><h2 class="title">%s</h2><a href="%s" class="bb-login-button button button-primary button-hero">%s</a></div>',
                                $i18n->translate('BED_2188_connect_account'),
                                esc_url(BEDBOOKING_LOGIN_URL . '?redirect_url='.admin_url(). 'admin.php?page=bed-booking'),
                                $i18n->translate('log_in'));

                    }
                ?>

            </div>
            <div class="bb-grid-column">

                <img
                        src="<?php echo plugin_dir_url( __FILE__ ); ?>../../images/bb_horizontal.svg"
                        alt="BedBooking logo"
                        class="bb-header-image"
                />

                <div class="card bb-card">
                    <?php
                    printf('<h2 class="title">%s</h2><p style="align-self: baseline;">%s</p>', $i18n->translate('OUT_4259_reservation_system_text_1'), $i18n->translate('OUT_4259_reservation_system_text_2'));
                    ?>
                    <img
                            src="<?php echo plugin_dir_url( __FILE__ ); ?>../../images/ikonkasystemrezerwacji_kolorwordpress3.svg"
                            alt="BedBooking icon"
                            class="bb-info-icon"
                    />
                </div>

                <div class="card bb-card">
                    <?php
                    printf('<h2 class="title">%s</h2>', $i18n->translate('OUT_4259_reservation_system_text_3'));
                    ?>

                    <ul class="bb-reservation-list">
                        <li class="bb-reservation-list-item">
                            <?php echo $i18n->translate('OUT_4259_reservation_system_list_1'); ?>
                        </li>
                        <li class="bb-reservation-list-item">
                            <?php echo $i18n->translate('BED_2188_reservation_system_list_2'); ?>
                        </li>
                        <li class="bb-reservation-list-item">
                            <?php echo $i18n->translate('OUT_4259_reservation_system_list_3'); ?>
                        </li>
                        <li class="bb-reservation-list-item">
                            <?php echo $i18n->translate('OUT_4259_reservation_system_list_4'); ?>
                        </li>
                        <li class="bb-reservation-list-item">
                            <?php echo $i18n->translate('OUT_4259_reservation_system_list_5'); ?>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

    </div>

 <?php

}

?>
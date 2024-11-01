<?php

/*
Plugin Name: TACTAL Website Call Button
Description: Add a WebRTC voice chat button to your website for visitors to call you through their browser.
Version: 1.0.1
Author: i-Comm Connect
Author URI: http://icommconnect.com
Plugin URI: https://wordpress.org/plugins/tactal-website-call-button/
License: GPLv2 or later
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//TACTAL Register Admin Menu and setup settings page

add_action( 'admin_menu', 'tactal_add_admin_menu' );
add_action( 'admin_init', 'tactal_settings_init' );


function tactal_load_custom_wp_admin_style($hook) {

    if($hook != 'toplevel_page_tactal') {
        return;
    }
    wp_enqueue_style( 'custom_wp_admin_css', plugins_url('admin/css/tactal-admin.min.css', __FILE__) );
    wp_enqueue_script( 'custom_wp_admin_js', plugins_url('admin/js/tactal-admin.min.js', __FILE__) );
    wp_enqueue_script( 'wp-color-picker' );
    wp_enqueue_style( 'wp-color-picker');
}

add_action( 'admin_enqueue_scripts', 'tactal_load_custom_wp_admin_style' );

function tactal_add_admin_menu(  ) {

    $icon_svg = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAPCAYAAADkmO9VAAABS2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS42LWMxMzggNzkuMTU5ODI0LCAyMDE2LzA5LzE0LTAxOjA5OjAxICAgICAgICAiPgogPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIi8+CiA8L3JkZjpSREY+CjwveDp4bXBtZXRhPgo8P3hwYWNrZXQgZW5kPSJyIj8+IEmuOgAAAYtJREFUOI2V002IT2EUBvDff2JiEikTZWuU8bHwkZSSEkURK2sheyFZKjWzECuFBTMLsZkFC/kqhEhZSBb/vWxk4bPx8Vjc17jd7l049da953nvuc9zznN6SXTELJzADszGF1zC9a4PoNdRcBQv8A6X8R6rcRhvsRk/WysmaZ4FSb4mGW/BJHmW5HkH1spwAouwsyG/zugVhnAXU7j/FxhoIT2CK7X38/iB3bXcUTzBZ9zAgzbJy5JMpYrRktubf/GwIW9pklVJBksL7iWZYXgIfdU0T+FDyc+vseo3lKzDaRwo7BdjlyQrk0wn2d7S5A2F3e2OIexLMpFkS5KzSSZ7Sa6VBu9p6afSp28YbsEWYgWeYhJDA+jp8lQV51RTP9KCfSzFYBNuSrKx+G5th6y5BU+S4Y47j5O8rPvwJM6oVquPOeWv8/AIS1QbcwfjOIjjWINbeIP1+F439lYcwyCmkfL8C/tVazdWk/saV/EJF2eyXSvUccZqvvydZKR5538LSrItyYUky9vwP2B2xe6C8U+8AAAAAElFTkSuQmCC'; // base 64 string goes here

    add_menu_page( 'TACTAL', 'TACTAL', 'manage_options', 'tactal', 'tactal_options_page', $icon_svg );

}

// TACTAL Register Settings

function tactal_settings_init(  ) {

    register_setting( 'tactal_pluginpage', 'tactal_settings' );

    add_settings_section(
        'tactal_pluginpage_section',
        __( 'Account Information', 'tactal' ),
        'tactal_settings_section_callback',
        'tactal_pluginpage_main'
    );


    add_settings_field(
        'tactal_subscriberid',
        __( 'Subscription ID', 'tactal' ),
        'tactal_subscriber_id',
        'tactal_pluginpage_main',
        'tactal_pluginpage_section'
    );

    add_settings_field(
        'tactal_show_hide',
        __( 'Display TACTAL Button?', 'tactal' ),
        'tactal_show_hide',
        'tactal_pluginpage_main',
        'tactal_pluginpage_section',
        'myprefix_settings-section-name',
        array( 'label_for' => 'myprefix_setting-id' )
    );

    add_settings_section(
        'tactal_pluginpage_section',
        __( 'Icon Configuration', 'tactal' ),
        'tactal_settings_section_callback_config',
        'tactal_pluginpage'
    );

    add_settings_field(
        'tactal_icon_type',
        __( 'Choose Your Icon Type', 'tactal' ),
        'tactal_choose_icon',
        'tactal_pluginpage',
        'tactal_pluginpage_section',
        array( 'label_for' => 'myprefix_setting-id' )
    );

    add_settings_field(
        'tactal_position',
        __( 'Choose Your Icon Location', 'tactal' ),
        'tactal_icon_location',
        'tactal_pluginpage',
        'tactal_pluginpage_section'
    );

    add_settings_field(
        'tactal_icon_text_field',
        __( 'Enter Your Icon Text', 'tactal' ),
        'tactal_icon_text',
        'tactal_pluginpage',
        'tactal_pluginpage_section'
    );

    add_settings_field(
        'tactal_icon_font',
        __( 'Enter Your Icon Text', 'tactal' ),
        'tactal_icon_font',
        'tactal_pluginpage',
        'tactal_pluginpage_section'
    );
    add_settings_field(
        'tactal_button_color',
        __( 'Choose The TACTAL Button Color', 'tactal' ),
        'tactal_icon_colors',
        'tactal_pluginpage',
        'tactal_pluginpage_section'

    );

    add_settings_section(
        'tactal_pluginpage_section',
        __( '', 'tactal' ),
        'tactal_settings_section_callback_colors',
        'tactal_pluginpage_color'
    );

    add_settings_field(
        'tactal_custom_bg_color',
        __( 'Choose Background Color', 'tactal' ),
        'tactal_custom_bg_color_render',
        'tactal_pluginpage_color',
        'tactal_pluginpage_section'
    );

    add_settings_field(
        'tactal_custom_text_color',
        __( 'Choose Icon Color', 'tactal' ),
        'tactal_custom_text_color_render',
        'tactal_pluginpage_color',
        'tactal_pluginpage_section'
    );
}

//Setup form fields and values

//Subscriber ID that connects to iComm
function tactal_subscriber_id(  ) {

    $options = get_option( 'tactal_settings' );
    ?>
    <input type='text' name='tactal_settings[tactal_subscriberid]' pattern="[a-zA-Z0-9-]+"  value='<?php echo esc_attr($options['tactal_subscriberid']); ?>' required>
    <?php

}

//Show or hide the TACTAL BUTTON
function tactal_show_hide(  ) {

    $options = get_option('tactal_settings',array('tactal_show_hide' => 'hide'));
    ?>
    <div class="display-icon-section">
        <label><input type='radio' name='tactal_settings[tactal_show_hide]' <?php checked( $options['tactal_show_hide'], "show" ); ?> value='show'>Display</label>
        <label><input type='radio' name='tactal_settings[tactal_show_hide]' <?php checked( $options['tactal_show_hide'], "hide" ); ?> value='hide'>Do Not Display</>
    </div>
    <?php

}

//Choose the icon you want to display
function tactal_choose_icon(  ) {

    $options = get_option('tactal_settings',array('tactal_icon_type' => 'text_icon'));
    ?>
    <div class="custom_half"><label><img height="100" src="<?php echo esc_url(plugin_dir_url( dirname( __FILE__ ) ) ) . 'tactal-website-call-button/admin/images/text-icon.png'; ?>" /><input type='radio' class="text_icon" name='tactal_settings[tactal_icon_type]' <?php checked( $options['tactal_icon_type'], "text_icon" ); ?> value='text_icon'></label></div>
    <div class="custom_half"><label><img height="100" src="<?php echo esc_url(plugin_dir_url( dirname( __FILE__ ) ) ) . 'tactal-website-call-button/admin/images/circle-icon.png'; ?>" /><input type='radio' class="image_icon" name='tactal_settings[tactal_icon_type]' <?php checked( $options['tactal_icon_type'], "image_icon" ); ?> value='image_icon'></label></div>
    <?php

}

//Choose the icon location
function tactal_icon_location(  ) {

    $options = get_option('tactal_settings',array('tactal_position' => 'bottomleft'));
    ?>
    <select name='tactal_settings[tactal_position]' id="choose_location">
        <option value='topleft' <?php selected( $options['tactal_position'], "topleft" ); ?>>Top Left</option>
        <option value='topmiddle' <?php selected( $options['tactal_position'], "topmiddle" ); ?>>Top Middle</option>
        <option value='topright' <?php selected( $options['tactal_position'], "topright" ); ?>>Top Right</option>
        <option value='bottommiddle' <?php selected( $options['tactal_position'], "bottommiddle" ); ?>>Bottom Middle</option>
        <option value='bottomleft' <?php selected( $options['tactal_position'], "bottomleft" ); ?>>Bottom Left</option>
        <option value='bottomright' <?php selected( $options['tactal_position'], "bottomright" ); ?>>Bottom Right</option>
    </select>

    <?php

}

//Enter icon text
function tactal_icon_text(  ) {

    $options = get_option( 'tactal_settings' );
    ?>
    <input type='text' maxlength="14" name='tactal_settings[tactal_text]' value='<?php echo esc_html($options['tactal_text']); ?>'>
    <?php

}

//Choose to use the default font (lato) or your themes font
function tactal_icon_font(  ) {

    $options = get_option('tactal_settings',array('tactal_icon_font' => 'tactal-user-font'));

    ?>
    <div class="use-font-section">
        <label><input type='radio' name='tactal_settings[tactal_icon_font]' <?php checked( $options['tactal_icon_font'], "tactal-user-font" ); ?> value='tactal-user-font'>Use your website's default font.</label>
        <label><input type='radio' name='tactal_settings[tactal_icon_font]' <?php checked( $options['tactal_icon_font'], "tactal-default-font" ); ?> value='tactal-default-font'>Use our font.</label>
    </div>
    <?php

}

//Icon colors
function tactal_icon_colors(  ) {

    $options = get_option('tactal_settings',array('tactal_color' => 'tactal-blue'));
    ?>
    <div id="color-container">
        <span class="colors"><label><span class="tactal-blue"></span><input type='checkbox' class="color_radio color-selector blue" name='tactal_settings[tactal_color]' <?php checked( $options['tactal_color'], "tactal-blue" ); ?> value='tactal-blue'></label></span>
        <span class="colors"><label><span class="tactal-green"></span><input type='checkbox' class="color_radio color-selector green" name='tactal_settings[tactal_color]' <?php checked( $options['tactal_color'], "tactal-green" ); ?> value='tactal-green'></label></span>
        <span class="colors"><label><span class="tactal-white"></span><input type='checkbox' class="color_radio color-selector white" name='tactal_settings[tactal_color]' <?php checked( $options['tactal_color'], "tactal-white" ); ?> value='tactal-white'></label></span>
        <span class="colors circle-not-available"><label><span class="tactal-grey"></span><input type='checkbox' class="color_radio color-selector grey" name='tactal_settings[tactal_color]' <?php checked( $options['tactal_color'], "tactal-grey" ); ?> value='tactal-grey'></label></span>
        <span class="colors circle-not-available"><label><span class="tactal-black"></span><input type='checkbox' class="color_radio color-selector black" name='tactal_settings[tactal_color]' <?php checked( $options['tactal_color'], "tactal-black" ); ?> value='tactal-black'></label></span>
        <span class="colors circle-not-available"><label><span class="tactal-text">Choose Your Own Colors</span> <input type='checkbox' class="show-more-colors color-selector custom" name='tactal_settings[tactal_color]' <?php checked( $options['tactal_color'], "custom" ); ?> value='custom'></label></span>
    </div>

    <?php

}

//Custom icon background color
function tactal_custom_bg_color_render(  ) {
    $options = get_option( 'tactal_settings' );
    ?>
    <div class="custom_half"><input type='text' class="color-picker" name='tactal_settings[tactal_custom_bg_color]' value='<?php echo esc_attr ($options['tactal_custom_bg_color']); ?>'></div>
    <?php

}

//Custom icon font color
function tactal_custom_text_color_render(  ) {

    $options = get_option( 'tactal_settings' );
    ?>
    <div class="custom_half"><input type='text' class="color-picker" name='tactal_settings[tactal_custom_text_color]' value='<?php echo esc_attr ($options['tactal_custom_text_color']); ?>'></div>
    <?php

}

//TACTAL Description
function tactal_settings_section_callback(  ) {

    echo  '<p class="config-info">Enter your Subscription ID number below. Your Subscription ID is a unique 16-digit alphanumerical ID at the end of your custom URL. <br />
    If you\'re not an i-Comm Connect customer, <a href="https://admin.icommconnect.com/Home/ClientSelfRegistration?vendorGuId=c11cca17ca91717a" target="_blank">click here</a> to sign up. </p>', '' ;

}

//TACTAL icon config description
function tactal_settings_section_callback_config(  ) {

    echo esc_html( 'Choose the icon style you\'d like to display on your website.', 'tactal' );

}

//Call the custom color section
function tactal_settings_section_callback_colors(  ) {


}

// TACTAL admin form

function tactal_options_page(  ) {

    ?>
    <form action='options.php' method='post'>

        <h1 class="title"><img width="45" src="<?php echo esc_url (plugin_dir_url( dirname( __FILE__ ) ) ) . 'tactal-website-call-button/admin/images/tactal_icon_logo.png'; ?>" /> TACTAL Icon Configuration Settings</h1>

        <p>The TACTAL by i-Comm Connect plug-in lets your customers call you and your business directly from your website! With just one click on the button, customers are instantly connected to a live representative through their browser from anywhere in the world with an internet connected device. </p>

        <?php

        $options = get_option('tactal_settings');

        $show = ($options['tactal_show_hide'] == 'show');

        ?>

        <div class="auth-section <?php echo "show-$show" ?>" >

            <?php settings_fields( 'tactal_pluginpage' ); ?>

            <?php do_settings_sections( 'tactal_pluginpage_main' );?>

            <?php submit_button( 'Save Settings' );?>

        </div>

        <div class="icon-section <?php echo "show-$show" ?>">

            <?php do_settings_sections( 'tactal_pluginpage' );?>

        </div>

        <div class="color-picker-section">

            <?php do_settings_sections( 'tactal_pluginpage_color' );?>

        </div>

        <?php submit_button( 'Save Settings' );?>

    </form>

    <div class="tactal-logo-section">

        <img width="350" src="<?php echo esc_url (plugin_dir_url( dirname( __FILE__ ) ) ) . 'tactal-website-call-button/admin/images/tactal_main_logo.png'; ?>" />

    </div>

<?php }

//TACTAL public facing code

add_action( 'wp_footer', 'tactal_click_to_call_code' );

//Load the icon when plugin is enabled.

function tactal_click_to_call_code() {

    $options = get_option('tactal_settings');

    $show = ($options['tactal_show_hide'] == 'show');

    if (!$show)
        return;

    $clientId = esc_attr($options['tactal_subscriberid']);
    if (trim($clientId) == "")
        return;

    $tactal_position = esc_attr($options['tactal_position']);

    $tactal_color = esc_attr($options['tactal_color']);

    $tactal_text = esc_attr($options['tactal_text']);

    $tactal_font = esc_attr($options['tactal_icon_font']);


    if ($options['tactal_icon_type'] == 'text_icon') {

        //If they want to use Lato - use this code.

        if ($tactal_font == 'tactal-default-font') {
            wp_enqueue_style( 'lato_font', plugins_url('public/css/tactal-font-lato.css', __FILE__) );
        }

        //If custom colors are being used - use this code.

        if ($tactal_color == "custom") {
            $tactal_custom_text = esc_attr($options['tactal_custom_text_color']);
            $tactal_custom_bg = esc_attr($options['tactal_custom_bg_color']);
            $custom_colors = 'style="background-color:'. $tactal_custom_bg .' !important; color:'. $tactal_custom_text .' !important;"';
            $custom_border = 'style="border-color:'. $tactal_custom_text .' !important;"';

            wp_enqueue_style( 'tactal-css', plugins_url('public/css/tactal-styles.min.css', __FILE__) );

            echo  '<a '.  $custom_colors .' id="tactal-button" class="tactal-button tactal-text-icon ' . $tactal_position .' ' . $tactal_color .' ' . $tactal_font .'" onclick="window.open(\'https://client.icommconnect.com//Home/Directory?clientSubscriptionGuId=' . $clientId . '\', \'\', \'width=360, height=640\')";><span '. $custom_border .' class="tactal-icon tactal-icon-call"></span> <span class="text-container">'. $tactal_text .'</span></a>';

        }

        //If no custom colors are being used - use this code.

        else {

            wp_enqueue_style( 'tactal-css', plugins_url('public/css/tactal-styles.min.css', __FILE__) );

            echo  '<a id="tactal-button" class="tactal-button tactal-text-icon ' . $tactal_position .' ' . $tactal_color .' ' . $tactal_font .'" onclick="window.open(\'https://client.icommconnect.com//Home/Directory?clientSubscriptionGuId=' . $clientId . '\', \'\', \'width=360, height=640\')";><span class="tactal-icon tactal-icon-call"></span> <span class="text-container">'. $tactal_text .'</span></a>';

        }

        //If the circle icon is used - use this code.

    } else {

            wp_enqueue_style( 'tactal-css', plugins_url('public/css/tactal-styles.min.css', __FILE__) );

            echo   '<a id="tactal-button" class="tactal-circle-icon ' . $tactal_position .'  " onclick="window.open(\'https://client.icommconnect.com//Home/Directory?clientSubscriptionGuId=' . $clientId . '\', \'\', \'width=360, height=640\')";> <span class="tactal-icon-container ' . $tactal_color .' "><span class="tactal-icon tactal-icon-call"></span></a>';

    }
}

?>

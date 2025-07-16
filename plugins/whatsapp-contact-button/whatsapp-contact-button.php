<?php
/**
 * Plugin Name: WhatsApp Contact Button
 * Plugin URI: https://github.com/your-username/whatsapp-contact-button
 * Description: Plugin WordPress para botão de contato WhatsApp com integração CF7, funcionalidades de rastreamento e painel administrativo.
 * Version: 1.0.1
 * Author: Manus AI
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: whatsapp-contact-button
 * Domain Path: /languages
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define("WCB_PLUGIN_URL", plugin_dir_url(__FILE__));
define("WCB_PLUGIN_PATH", plugin_dir_path(__FILE__));
define("WCB_PLUGIN_VERSION", "1.0.1");
define("WCB_PLUGIN_BASENAME", plugin_basename(__FILE__));

// Include database file early for activation hook
require_once WCB_PLUGIN_PATH . 'includes/database.php';

/**
 * Main WhatsApp Contact Button Class
 */
class WhatsAppContactButton {
    /**
     * Constructor
     */
    public function __construct() {
        add_action('init', array($this, 'init'));
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
        register_uninstall_hook(__FILE__, array('WhatsAppContactButton', 'uninstall'));
    }

    /**
     * Initialize the plugin
     */
    public function init() {
        // Load text domain for translations
        load_plugin_textdomain('whatsapp-contact-button', false, dirname(WCB_PLUGIN_BASENAME) . '/languages');

        // Include remaining required files
        $this->includes();

        // Initialize components
        $this->init_components();
    }

    /**
     * Include remaining required files
     */
    private function includes() {
        require_once WCB_PLUGIN_PATH . 'includes/admin.php';
        require_once WCB_PLUGIN_PATH . 'includes/frontend.php';
        require_once WCB_PLUGIN_PATH . 'includes/cf7-integration.php';
        require_once WCB_PLUGIN_PATH . 'includes/analytics.php';
        require_once WCB_PLUGIN_PATH . 'includes/notifications.php';
        require_once WCB_PLUGIN_PATH . 'includes/schedule.php';
    }

    /**
     * Initialize plugin components
     */
    private function init_components() {
        // Initialize admin area
        if (is_admin()) {
            new WCB_Admin();
        }

        // Initialize frontend
        if (!is_admin()) {
            new WCB_Frontend();
        }

        // Initialize CF7 integration
        new WCB_CF7_Integration();

        // Initialize analytics
        new WCB_Analytics();

        // Initialize notifications
        new WCB_Notifications();

        // Initialize schedule
        new WCB_Schedule();
    }

    /**
     * Plugin activation
     */
    public function activate() {
        // Create database tables
        WCB_Database::create_tables();

        // Set default options
        $this->set_default_options();

        // Flush rewrite rules
        flush_rewrite_rules();
    }

    /**
     * Plugin deactivation
     */
    public function deactivate() {
        // Flush rewrite rules
        flush_rewrite_rules();
    }

    /**
     * Plugin uninstall
     */
    public static function uninstall() {
        // Check if user wants to delete data
        $delete_data = get_option('wcb_delete_data_on_uninstall', false);

        if ($delete_data) {
            // Delete database tables
            WCB_Database::drop_tables();

            // Delete options
            self::delete_options();
        }
    }

    /**
     * Set default options
     */
    private function set_default_options() {
        $default_options = array(
            'wcb_enabled' => true,
            'wcb_button_position' => 'bottom-right',
            'wcb_working_hours' => array(
                'monday' => array('enabled' => true, 'start' => '09:00', 'end' => '18:00'),
                'tuesday' => array('enabled' => true, 'start' => '09:00', 'end' => '18:00'),
                'wednesday' => array('enabled' => true, 'start' => '09:00', 'end' => '18:00'),
                'thursday' => array('enabled' => true, 'start' => '09:00', 'end' => '18:00'),
                'friday' => array('enabled' => true, 'start' => '09:00', 'end' => '18:00'),
                'saturday' => array('enabled' => false, 'start' => '09:00', 'end' => '18:00'),
                'sunday' => array('enabled' => false, 'start' => '09:00', 'end' => '18:00')
            ),
            'wcb_form_mappings' => array(),
            'wcb_notification_emails' => array(get_option('admin_email')),
            'wcb_delete_data_on_uninstall' => false
        );

        foreach ($default_options as $option_name => $option_value) {
            if (get_option($option_name) === false) {
                add_option($option_name, $option_value);
            }
        }
    }

    /**
     * Delete all plugin options
     */
    private static function delete_options() {
        $options = array(
            'wcb_enabled',
            'wcb_button_position',
            'wcb_working_hours',
            'wcb_form_mappings',
            'wcb_notification_emails',
            'wcb_delete_data_on_uninstall'
        );

        foreach ($options as $option) {
            delete_option($option);
        }
    }

    /**
     * Get plugin option with default fallback
     */
    public static function get_option($option_name, $default = false) {
        return get_option($option_name, $default);
    }

    /**
     * Update plugin option
     */
    public static function update_option($option_name, $option_value) {
        return update_option($option_name, $option_value);
    }

    /**
     * Check if Contact Form 7 is active
     */
    public static function is_cf7_active() {
        return class_exists('WPCF7');
    }

    /**
     * Check if Advanced Custom Fields is active
     */
    public static function is_acf_active() {
        return function_exists('get_field');
    }

    /**
     * Clean WhatsApp number (remove formatting)
     */
    public static function clean_whatsapp_number($number) {
        return preg_replace('/[^0-9]/', '', $number);
    }

    /**
     * Get WhatsApp number from ACF
     */
    public static function get_whatsapp_number() {
        if (self::is_acf_active()) {
            $number = get_field('whatsapp', 'option');
            return self::clean_whatsapp_number($number);
        }
        return '';
    }

    /**
     * Get WhatsApp popup text from ACF
     */
    public static function get_popup_text() {
        if (self::is_acf_active()) {
            return get_field('whatsapp_texto_popup', 'option');
        }
        return __('Entre em contato conosco via WhatsApp!', 'whatsapp-contact-button');
    }

    /**
     * Get WhatsApp base message from ACF
     */
    public static function get_base_message() {
        if (self::is_acf_active()) {
            return get_field('whatsapp_mensagem_base', 'option');
        }
        return __('Olá! Gostaria de conversar sobre seus serviços.', 'whatsapp-contact-button');
    }
}

// Initialize the plugin
new WhatsAppContactButton();

/**
 * Shortcode for manual button placement
 */
function wcb_whatsapp_button_shortcode($atts) {
    $atts = shortcode_atts(array(
        'text' => __('Fale conosco no WhatsApp', 'whatsapp-contact-button'),
        'class' => 'wcb-manual-button',
        'style' => 'theme' // 'theme' usa --base-color, 'whatsapp' usa verde do WhatsApp
    ), $atts);

    if (!WhatsAppContactButton::get_option('wcb_enabled', true)) {
        return '';
    }

    $button_class = esc_attr($atts['class']);

    // Adiciona classe de estilo baseado no parâmetro 'style'
    if ($atts['style'] === 'whatsapp') {
        $button_class .= ' wcb-whatsapp-style';
    }

    return '<button class="' . $button_class . '" onclick="wcbOpenModal()">' . esc_html($atts['text']) . '</button>';
}
add_shortcode('whatsapp_button', 'wcb_whatsapp_button_shortcode'); 
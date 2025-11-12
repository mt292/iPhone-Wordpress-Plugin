<?php
/**
 * Plugin Name: iPhone Simulator for Digital Literacy
 * Plugin URI: https://github.com/mt292/iPhone-Wordpress-Plugin
 * Description: Interactive iPhone simulator widget for teaching seniors digital literacy. Includes realistic iOS interface with apps like FaceTime, Messages, and more.
 * Version: 1.0.0
 * Author: Martin Topp
 * Author URI: https://mtsaga.net
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: iphone-simulator
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('IPHONE_SIM_VERSION', '1.0.0');
define('IPHONE_SIM_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('IPHONE_SIM_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Main Plugin Class
 */
class iPhone_Simulator_Plugin {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        $this->init_hooks();
    }
    
    private function init_hooks() {
        // Enqueue scripts and styles
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
        
        // Register shortcode
        add_shortcode('iphone_simulator', array($this, 'render_shortcode'));
        
        // Register Elementor widget
        add_action('elementor/widgets/register', array($this, 'register_elementor_widget'));
        
        // Add admin menu
        add_action('admin_menu', array($this, 'add_admin_menu'));
        
        // Register settings
        add_action('admin_init', array($this, 'register_settings'));
    }
    
    /**
     * Enqueue CSS and JavaScript
     */
    public function enqueue_assets() {
        // Enqueue Framework7 CSS
        wp_enqueue_style(
            'framework7-bundle',
            'https://cdn.jsdelivr.net/npm/framework7@8.3.3/css/framework7.bundle.min.css',
            array(),
            '8.3.3'
        );
        
        // Enqueue custom CSS
        wp_enqueue_style(
            'iphone-simulator-f7-css',
            IPHONE_SIM_PLUGIN_URL . 'assets/css/iphone-simulator-f7.css',
            array('framework7-bundle'),
            IPHONE_SIM_VERSION
        );
        
        // Enqueue Framework7 JavaScript
        wp_enqueue_script(
            'framework7-bundle',
            'https://cdn.jsdelivr.net/npm/framework7@8.3.3/js/framework7.bundle.min.js',
            array(),
            '8.3.3',
            true
        );
        
        // Enqueue custom JavaScript
        wp_enqueue_script(
            'iphone-simulator-f7-js',
            IPHONE_SIM_PLUGIN_URL . 'assets/js/iphone-simulator-f7.js',
            array('jquery', 'framework7-bundle'),
            IPHONE_SIM_VERSION,
            true
        );
        
        // Localize script for AJAX
        wp_localize_script('iphone-simulator-f7-js', 'iphoneSimulator', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('iphone_simulator_nonce'),
            'pluginUrl' => IPHONE_SIM_PLUGIN_URL
        ));
    }
    
    /**
     * Render shortcode
     */
    public function render_shortcode($atts) {
        $atts = shortcode_atts(array(
            'app' => 'facetime',
            'lesson' => 'call-martin',
            'tutorial' => 'true',
            'apps' => 'facetime,messages,phone,facebook,twitter,whatsapp'
        ), $atts);
        
        return $this->render_iphone_simulator($atts);
    }
    
    /**
     * Register Elementor Widget
     */
    public function register_elementor_widget($widgets_manager) {
        require_once IPHONE_SIM_PLUGIN_DIR . 'includes/elementor-widget.php';
        $widgets_manager->register(new \iPhone_Simulator_Elementor_Widget());
    }
    
    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_menu_page(
            'iPhone Simulator',
            'iPhone Simulator',
            'manage_options',
            'iphone-simulator',
            array($this, 'render_admin_page'),
            'dashicons-smartphone',
            30
        );
    }
    
    /**
     * Register settings
     */
    public function register_settings() {
        register_setting('iphone_simulator_settings', 'iphone_sim_default_apps');
        register_setting('iphone_simulator_settings', 'iphone_sim_tutorial_speed');
        register_setting('iphone_simulator_settings', 'iphone_sim_avatar_style');
    }
    
    /**
     * Render admin page
     */
    public function render_admin_page() {
        include IPHONE_SIM_PLUGIN_DIR . 'admin/settings-page.php';
    }
    
    /**
     * Render iPhone Simulator HTML
     */
    public function render_iphone_simulator($atts) {
        ob_start();
        include IPHONE_SIM_PLUGIN_DIR . 'templates/iphone-simulator-f7.php';
        return ob_get_clean();
    }
}

// Initialize the plugin
function iphone_simulator_init() {
    return iPhone_Simulator_Plugin::get_instance();
}

// Start the plugin
add_action('plugins_loaded', 'iphone_simulator_init');

/**
 * Activation hook
 */
function iphone_simulator_activate() {
    // Set default options
    if (!get_option('iphone_sim_default_apps')) {
        update_option('iphone_sim_default_apps', 'facetime,messages,phone,facebook,twitter,whatsapp');
    }
    if (!get_option('iphone_sim_tutorial_speed')) {
        update_option('iphone_sim_tutorial_speed', 'normal');
    }
    if (!get_option('iphone_sim_avatar_style')) {
        update_option('iphone_sim_avatar_style', 'memoji');
    }
}
register_activation_hook(__FILE__, 'iphone_simulator_activate');

/**
 * Deactivation hook
 */
function iphone_simulator_deactivate() {
    // Cleanup if needed
}
register_deactivation_hook(__FILE__, 'iphone_simulator_deactivate');

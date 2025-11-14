<?php
/**
 * Plugin Name: Elementor Starter Kit
 * Description: A reusable starter kit for creating Elementor extension plugins with custom widgets and controls
 * Version: 1.0.0
 * Author: Ali Raza
 * Author URI: https://amrshah.github.io
 * Text Domain: elementor-starter-kit
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * Elementor tested up to: 3.20.0
 * Elementor Pro tested up to: 3.20.0
 */


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Main Plugin Class
 * 
 * The main class that initiates and runs the plugin.
 */
final class Elementor_Starter_Kit {

    /**
     * Plugin Version
     */
    const VERSION = '1.0.0';

    /**
     * Minimum Elementor Version
     */
    const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

    /**
     * Minimum PHP Version
     */
    const MINIMUM_PHP_VERSION = '7.4';

    /**
     * Instance
     */
    private static $_instance = null;

    /**
     * Instance
     * 
     * Ensures only one instance of the class is loaded or can be loaded.
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor
     */
    public function __construct() {
        add_action('plugins_loaded', [$this, 'on_plugins_loaded']);
    }

    /**
     * Load Textdomain
     */
    public function i18n() {
        load_plugin_textdomain('elementor-starter-kit', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }

    /**
     * On Plugins Loaded
     */
    public function on_plugins_loaded() {
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
            return;
        }

        // Check for required Elementor version
        if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
            return;
        }

        // Check for required PHP version
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
            return;
        }

        // Initialize the plugin
        $this->init();
    }

    /**
     * Admin notice for missing Elementor
     */
    public function admin_notice_missing_main_plugin() {
        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
            esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'elementor-starter-kit'),
            '<strong>' . esc_html__('Elementor Starter Kit', 'elementor-starter-kit') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'elementor-starter-kit') . '</strong>'
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Admin notice for minimum Elementor version
     */
    public function admin_notice_minimum_elementor_version() {
        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-starter-kit'),
            '<strong>' . esc_html__('Elementor Starter Kit', 'elementor-starter-kit') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'elementor-starter-kit') . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Admin notice for minimum PHP version
     */
    public function admin_notice_minimum_php_version() {
        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-starter-kit'),
            '<strong>' . esc_html__('Elementor Starter Kit', 'elementor-starter-kit') . '</strong>',
            '<strong>' . esc_html__('PHP', 'elementor-starter-kit') . '</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Initialize the plugin
     */
    public function init() {
        $this->i18n();

        // Include required files
        $this->include_files();

        // Register widget categories
        add_action('elementor/elements/categories_registered', [$this, 'register_categories']);

        // Initialize Widgets Manager (auto-discovers and registers all widgets)
        $this->init_widgets_manager();

        // Register controls
        add_action('elementor/controls/register', [$this, 'register_controls']);

        // Enqueue styles and scripts
        add_action('elementor/frontend/after_enqueue_styles', [$this, 'enqueue_frontend_styles']);
        add_action('elementor/frontend/after_register_scripts', [$this, 'enqueue_frontend_scripts']);
        add_action('elementor/editor/after_enqueue_styles', [$this, 'enqueue_editor_styles']);
    }

    /**
     * Include required files
     */
    private function include_files() {
        // Include Widgets Manager
        require_once(__DIR__ . '/includes/class-widgets-manager.php');
        
        // Note: Individual widget files are now auto-loaded by Widgets Manager
        // No need to manually require widget files anymore!
    }

    /**
     * Initialize Widgets Manager
     */
    private function init_widgets_manager() {
        new \Elementor_Starter_Kit\Widgets_Manager();
    }

    /**
     * Register Widget Categories
     */
    public function register_categories($elements_manager) {
        $elements_manager->add_category(
            'starter-kit-category',
            [
                'title' => esc_html__('Starter Kit Widgets', 'elementor-starter-kit'),
                'icon' => 'fa fa-plug',
            ]
        );
    }

    /**
     * Register Controls (if you create custom controls)
     */
    public function register_controls($controls_manager) {
        // Register custom controls here if needed
        // Example: $controls_manager->register(new Custom_Control());
    }

    /**
     * Enqueue Frontend Styles
     */
    public function enqueue_frontend_styles() {
        wp_enqueue_style(
            'elementor-starter-kit-frontend',
            plugins_url('assets/css/frontend.css', __FILE__),
            [],
            self::VERSION
        );
    }

    /**
     * Enqueue Frontend Scripts
     */
    public function enqueue_frontend_scripts() {
        wp_register_script(
            'elementor-starter-kit-frontend',
            plugins_url('assets/js/frontend.js', __FILE__),
            ['jquery'],
            self::VERSION,
            true
        );
    }

    /**
     * Enqueue Editor Styles
     */
    public function enqueue_editor_styles() {
        wp_enqueue_style(
            'elementor-starter-kit-editor',
            plugins_url('assets/css/editor.css', __FILE__),
            [],
            self::VERSION
        );
    }
}

// Initialize the plugin
Elementor_Starter_Kit::instance();
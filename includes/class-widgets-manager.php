<?php
namespace Elementor_Starter_Kit;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Widgets Manager
 * 
 * Handles auto-discovery and registration of widgets
 */
class Widgets_Manager {

    /**
     * Widgets directory path
     */
    private $widgets_dir;

    /**
     * Widgets namespace
     */
    private $widgets_namespace = 'Elementor_Starter_Kit\\Widgets\\';

    /**
     * Constructor
     */
    public function __construct() {
        $this->widgets_dir = plugin_dir_path(__FILE__) . 'widgets/';
        
        // Hook into Elementor
        add_action('elementor/widgets/register', [$this, 'register_widgets']);
    }

    /**
     * Get all widget files from the widgets directory
     * 
     * @return array Array of widget file paths
     */
    private function get_widget_files() {
        $widget_files = [];
        
        if (!is_dir($this->widgets_dir)) {
            return $widget_files;
        }

        // Scan the widgets directory
        $files = scandir($this->widgets_dir);
        
        foreach ($files as $file) {
            // Only include PHP files that start with 'class-'
            if (strpos($file, 'class-') === 0 && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                $widget_files[] = $this->widgets_dir . $file;
            }
        }

        return $widget_files;
    }

    /**
     * Get widget class name from file name
     * 
     * Converts: class-example-widget.php -> Example_Widget
     * 
     * @param string $file_path Full path to widget file
     * @return string Widget class name
     */
    private function get_widget_class_name($file_path) {
        $file_name = basename($file_path, '.php');
        
        // Remove 'class-' prefix
        $class_name = str_replace('class-', '', $file_name);
        
        // Convert kebab-case to Pascal_Case
        $class_name = str_replace('-', '_', $class_name);
        $class_name = ucwords($class_name, '_');
        
        return $class_name;
    }

    /**
     * Include widget files
     * 
     * @return array Array of successfully loaded widget class names
     */
    private function include_widget_files() {
        $widget_files = $this->get_widget_files();
        $loaded_widgets = [];

        foreach ($widget_files as $file_path) {
            if (file_exists($file_path)) {
                require_once $file_path;
                
                $class_name = $this->get_widget_class_name($file_path);
                $full_class_name = $this->widgets_namespace . $class_name;
                
                // Verify class exists
                if (class_exists($full_class_name)) {
                    $loaded_widgets[] = $full_class_name;
                } else {
                    // Log error if class doesn't match expected name
                    error_log(sprintf(
                        'Elementor Starter Kit: Widget class "%s" not found in file "%s"',
                        $full_class_name,
                        basename($file_path)
                    ));
                }
            }
        }

        return $loaded_widgets;
    }

    /**
     * Register all widgets with Elementor
     * 
     * @param object $widgets_manager Elementor widgets manager instance
     */
    public function register_widgets($widgets_manager) {
        // Include all widget files
        $widget_classes = $this->include_widget_files();

        // Register each widget
        foreach ($widget_classes as $widget_class) {
            try {
                $widget_instance = new $widget_class();
                $widgets_manager->register($widget_instance);
            } catch (\Exception $e) {
                // Log registration errors
                error_log(sprintf(
                    'Elementor Starter Kit: Failed to register widget "%s". Error: %s',
                    $widget_class,
                    $e->getMessage()
                ));
            }
        }

        // Log success message in debug mode
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log(sprintf(
                'Elementor Starter Kit: Successfully registered %d widget(s)',
                count($widget_classes)
            ));
        }
    }

    /**
     * Get list of registered widgets (for debugging)
     * 
     * @return array Array of widget class names
     */
    public function get_registered_widgets() {
        return $this->include_widget_files();
    }
}
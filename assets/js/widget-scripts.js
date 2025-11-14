/**
 * Elementor Starter Kit - Frontend Scripts
 * 
 * Add your custom widget JavaScript here
 */

(function($) {
    'use strict';

    /**
     * Example Widget Handler
     */
    var ExampleWidgetHandler = function($scope, $) {
        var $widget = $scope.find('.starter-widget-wrapper');
        
        if (!$widget.length) {
            return;
        }

        // Add your custom JavaScript logic here
        // Example: Add animation on scroll, AJAX interactions, etc.
        
        console.log('Example Widget initialized');
    };

    /**
     * Advanced Widget Handler
     */
    var AdvancedWidgetHandler = function($scope, $) {
        var $widget = $scope.find('.starter-features-grid');
        
        if (!$widget.length) {
            return;
        }

        // Add your custom JavaScript logic here
        // Example: Filtering, sorting, animations, etc.
        
        console.log('Advanced Widget initialized');
    };

    /**
     * Register handlers on Elementor Frontend Init
     */
    $(window).on('elementor/frontend/init', function() {
        // Register widget handlers
        // Widget name should match get_name() from your widget class
        
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/starter_example_widget.default',
            ExampleWidgetHandler
        );

        elementorFrontend.hooks.addAction(
            'frontend/element_ready/starter_advanced_widget.default',
            AdvancedWidgetHandler
        );
    });

})(jQuery);
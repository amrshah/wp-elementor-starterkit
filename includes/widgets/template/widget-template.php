<?php
/**
 * Widget Template
 * 
 * Copy this file and rename it following the convention: class-your-widget-name.php
 * Then update the class name to match: Your_Widget_Name
 * 
 * INSTRUCTIONS:
 * 1. Copy this file to: includes/widgets/class-your-widget-name.php
 * 2. Rename the class below to match your file name (in Pascal_Case)
 * 3. Update get_name(), get_title(), get_icon()
 * 4. Add your controls in register_controls()
 * 5. Build your output in render()
 * 6. Save - widget auto-registers!
 */

namespace Elementor_Starter_Kit\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Widget_Template Class
 * 
 * Change this class name to match your widget!
 * Example: Post_Grid, Contact_Form, Testimonial_Slider
 */
class Widget_Template extends Widget_Base {

    /**
     * Get widget name
     * 
     * Retrieve widget name (should be unique)
     * 
     * @return string Widget name
     */
    public function get_name() {
        return 'your_widget_name'; // Change this! Use lowercase with underscores
    }

    /**
     * Get widget title
     * 
     * Retrieve widget title (appears in Elementor panel)
     * 
     * @return string Widget title
     */
    public function get_title() {
        return esc_html__('Your Widget Title', 'elementor-starter-kit'); // Change this!
    }

    /**
     * Get widget icon
     * 
     * Retrieve widget icon (from Elementor icons library)
     * See: https://elementor.github.io/elementor-icons/
     * 
     * @return string Widget icon class
     */
    public function get_icon() {
        return 'eicon-code'; // Change this to any Elementor icon
    }

    /**
     * Get widget categories
     * 
     * Retrieve the list of categories the widget belongs to
     * 
     * @return array Widget categories
     */
    public function get_categories() {
        return ['starter-kit-category']; // Change or add more categories
    }

    /**
     * Get widget keywords
     * 
     * Retrieve the list of keywords for search functionality
     * 
     * @return array Widget keywords
     */
    public function get_keywords() {
        return ['your', 'keywords', 'here']; // Add relevant keywords
    }

    /**
     * Register widget controls
     * 
     * Add controls to your widget here
     */
    protected function register_controls() {

        // ===================================
        // CONTENT TAB - Content Section
        // ===================================
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'elementor-starter-kit'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Example: Text Control
        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'elementor-starter-kit'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Default Title', 'elementor-starter-kit'),
                'placeholder' => esc_html__('Enter your title', 'elementor-starter-kit'),
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        // Example: Textarea Control
        $this->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'elementor-starter-kit'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('Default description text', 'elementor-starter-kit'),
                'placeholder' => esc_html__('Enter your description', 'elementor-starter-kit'),
                'rows' => 5,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        // Example: Switcher Control
        $this->add_control(
            'show_element',
            [
                'label' => esc_html__('Show Element', 'elementor-starter-kit'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'elementor-starter-kit'),
                'label_off' => esc_html__('No', 'elementor-starter-kit'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        // ===================================
        // STYLE TAB - Title Style
        // ===================================
        $this->start_controls_section(
            'title_style_section',
            [
                'label' => esc_html__('Title', 'elementor-starter-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Example: Color Control
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'elementor-starter-kit'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .widget-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Example: Typography Control
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Typography', 'elementor-starter-kit'),
                'selector' => '{{WRAPPER}} .widget-title',
            ]
        );

        // Example: Responsive Spacing Control
        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'elementor-starter-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .widget-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ===================================
        // ADD MORE SECTIONS AS NEEDED
        // ===================================
        
        // You can add more control sections here following the same pattern
    }

    /**
     * Render widget output on the frontend
     * 
     * Build the HTML structure for your widget here
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        // Add wrapper attributes
        $this->add_render_attribute('wrapper', 'class', 'widget-wrapper');

        ?>
        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
            
            <?php if (!empty($settings['title'])) : ?>
                <h2 class="widget-title">
                    <?php echo esc_html($settings['title']); ?>
                </h2>
            <?php endif; ?>

            <?php if (!empty($settings['description'])) : ?>
                <div class="widget-description">
                    <?php echo esc_html($settings['description']); ?>
                </div>
            <?php endif; ?>

            <?php if ('yes' === $settings['show_element']) : ?>
                <div class="widget-element">
                    <!-- Your custom HTML here -->
                </div>
            <?php endif; ?>

        </div>
        <?php
    }

    /**
     * Render widget output in the editor (optional)
     * 
     * Use JavaScript template for live editing in Elementor editor
     * This is optional but provides better UX
     */
    protected function content_template() {
        ?>
        <#
        view.addRenderAttribute('wrapper', 'class', 'widget-wrapper');
        #>
        <div {{{ view.getRenderAttributeString('wrapper') }}}>
            
            <# if (settings.title) { #>
                <h2 class="widget-title">{{{ settings.title }}}</h2>
            <# } #>

            <# if (settings.description) { #>
                <div class="widget-description">{{{ settings.description }}}</div>
            <# } #>

            <# if ('yes' === settings.show_element) { #>
                <div class="widget-element">
                    <!-- Your custom HTML here -->
                </div>
            <# } #>

        </div>
        <?php
    }
}

/**
 * QUICK REFERENCE - Common Control Types
 * 
 * TEXT:
 * 'type' => Controls_Manager::TEXT
 * 
 * TEXTAREA:
 * 'type' => Controls_Manager::TEXTAREA
 * 
 * NUMBER:
 * 'type' => Controls_Manager::NUMBER
 * 
 * SELECT:
 * 'type' => Controls_Manager::SELECT
 * 'options' => ['value1' => 'Label 1', 'value2' => 'Label 2']
 * 
 * SWITCHER:
 * 'type' => Controls_Manager::SWITCHER
 * 
 * COLOR:
 * 'type' => Controls_Manager::COLOR
 * 
 * MEDIA (Image Upload):
 * 'type' => Controls_Manager::MEDIA
 * 
 * URL:
 * 'type' => Controls_Manager::URL
 * 
 * WYSIWYG:
 * 'type' => Controls_Manager::WYSIWYG
 * 
 * CODE:
 * 'type' => Controls_Manager::CODE
 * 
 * SLIDER:
 * 'type' => Controls_Manager::SLIDER
 * 
 * DIMENSIONS:
 * 'type' => Controls_Manager::DIMENSIONS
 * 
 * REPEATER:
 * 'type' => Controls_Manager::REPEATER
 * 
 * ICONS:
 * 'type' => Controls_Manager::ICONS
 * 
 * GALLERY:
 * 'type' => Controls_Manager::GALLERY
 * 
 * GROUP CONTROLS:
 * Group_Control_Typography::get_type()
 * Group_Control_Border::get_type()
 * Group_Control_Box_Shadow::get_type()
 * Group_Control_Background::get_type()
 */
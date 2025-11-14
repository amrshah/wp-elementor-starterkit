<?php
namespace Elementor_Starter_Kit\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Example Widget
 * 
 * Basic widget with common controls for text content and styling
 */
class Example_Widget extends Widget_Base {

    /**
     * Get widget name
     */
    public function get_name() {
        return 'starter_example_widget';
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return esc_html__('Example Widget', 'elementor-starter-kit');
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-text';
    }

    /**
     * Get widget categories
     */
    public function get_categories() {
        return ['starter-kit-category'];
    }

    /**
     * Get widget keywords
     */
    public function get_keywords() {
        return ['example', 'starter', 'text'];
    }

    /**
     * Register widget controls
     */
    protected function register_controls() {

        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'elementor-starter-kit'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'elementor-starter-kit'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Example Title', 'elementor-starter-kit'),
                'placeholder' => esc_html__('Enter your title', 'elementor-starter-kit'),
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'elementor-starter-kit'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('This is an example widget description. Replace this with your own content.', 'elementor-starter-kit'),
                'placeholder' => esc_html__('Enter your description', 'elementor-starter-kit'),
                'rows' => 5,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'elementor-starter-kit'),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'elementor-starter-kit'),
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => false,
                ],
            ]
        );

        $this->add_control(
            'show_button',
            [
                'label' => esc_html__('Show Button', 'elementor-starter-kit'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'elementor-starter-kit'),
                'label_off' => esc_html__('No', 'elementor-starter-kit'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Button Text', 'elementor-starter-kit'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Learn More', 'elementor-starter-kit'),
                'condition' => [
                    'show_button' => 'yes',
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Title
        $this->start_controls_section(
            'title_style_section',
            [
                'label' => esc_html__('Title', 'elementor-starter-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'elementor-starter-kit'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .starter-widget-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .starter-widget-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'title_text_shadow',
                'selector' => '{{WRAPPER}} .starter-widget-title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'elementor-starter-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .starter-widget-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Description
        $this->start_controls_section(
            'description_style_section',
            [
                'label' => esc_html__('Description', 'elementor-starter-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => esc_html__('Color', 'elementor-starter-kit'),
                'type' => Controls_Manager::COLOR,
                'default' => '#666666',
                'selectors' => [
                    '{{WRAPPER}} .starter-widget-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .starter-widget-description',
            ]
        );

        $this->end_controls_section();

        // Style Section - Button
        $this->start_controls_section(
            'button_style_section',
            [
                'label' => esc_html__('Button', 'elementor-starter-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_button' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'button_bg_color',
            [
                'label' => esc_html__('Background Color', 'elementor-starter-kit'),
                'type' => Controls_Manager::COLOR,
                'default' => '#0073aa',
                'selectors' => [
                    '{{WRAPPER}} .starter-widget-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => esc_html__('Text Color', 'elementor-starter-kit'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .starter-widget-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__('Padding', 'elementor-starter-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default' => [
                    'top' => '12',
                    'right' => '24',
                    'bottom' => '12',
                    'left' => '24',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .starter-widget-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('wrapper', 'class', 'starter-widget-wrapper');

        $target = $settings['link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $settings['link']['nofollow'] ? ' rel="nofollow"' : '';

        ?>
        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
            <?php if (!empty($settings['title'])) : ?>
                <h2 class="starter-widget-title"><?php echo esc_html($settings['title']); ?></h2>
            <?php endif; ?>

            <?php if (!empty($settings['description'])) : ?>
                <p class="starter-widget-description"><?php echo esc_html($settings['description']); ?></p>
            <?php endif; ?>

            <?php if ('yes' === $settings['show_button'] && !empty($settings['button_text']) && !empty($settings['link']['url'])) : ?>
                <a href="<?php echo esc_url($settings['link']['url']); ?>" class="starter-widget-button"<?php echo $target . $nofollow; ?>>
                    <?php echo esc_html($settings['button_text']); ?>
                </a>
            <?php endif; ?>
        </div>
        <?php
    }

    /**
     * Render widget output in the editor (optional)
     */
    protected function content_template() {
        ?>
        <#
        var target = settings.link.is_external ? ' target="_blank"' : '';
        var nofollow = settings.link.nofollow ? ' rel="nofollow"' : '';
        #>
        <div class="starter-widget-wrapper">
            <# if (settings.title) { #>
                <h2 class="starter-widget-title">{{{ settings.title }}}</h2>
            <# } #>

            <# if (settings.description) { #>
                <p class="starter-widget-description">{{{ settings.description }}}</p>
            <# } #>

            <# if ('yes' === settings.show_button && settings.button_text && settings.link.url) { #>
                <a href="{{ settings.link.url }}" class="starter-widget-button"{{{ target }}}{{{ nofollow }}}>
                    {{{ settings.button_text }}}
                </a>
            <# } #>
        </div>
        <?php
    }
}
<?php
namespace Elementor_Starter_Kit\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Utils;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Advanced Widget
 * 
 * Widget with repeater controls for creating lists of items
 */
class Advanced_Widget extends Widget_Base {

    /**
     * Get widget name
     */
    public function get_name() {
        return 'starter_advanced_widget';
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return esc_html__('Advanced Features List', 'elementor-starter-kit');
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-bullet-list';
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
        return ['advanced', 'list', 'features', 'repeater'];
    }

    /**
     * Register widget controls
     */
    protected function register_controls() {

        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Features', 'elementor-starter-kit'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'feature_icon',
            [
                'label' => esc_html__('Icon', 'elementor-starter-kit'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-check-circle',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $repeater->add_control(
            'feature_title',
            [
                'label' => esc_html__('Title', 'elementor-starter-kit'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Feature Title', 'elementor-starter-kit'),
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'feature_description',
            [
                'label' => esc_html__('Description', 'elementor-starter-kit'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('Feature description goes here.', 'elementor-starter-kit'),
                'rows' => 3,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'feature_link',
            [
                'label' => esc_html__('Link', 'elementor-starter-kit'),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'elementor-starter-kit'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'feature_image',
            [
                'label' => esc_html__('Image', 'elementor-starter-kit'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'features_list',
            [
                'label' => esc_html__('Features List', 'elementor-starter-kit'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'feature_title' => esc_html__('Feature #1', 'elementor-starter-kit'),
                        'feature_description' => esc_html__('Description for feature one.', 'elementor-starter-kit'),
                    ],
                    [
                        'feature_title' => esc_html__('Feature #2', 'elementor-starter-kit'),
                        'feature_description' => esc_html__('Description for feature two.', 'elementor-starter-kit'),
                    ],
                    [
                        'feature_title' => esc_html__('Feature #3', 'elementor-starter-kit'),
                        'feature_description' => esc_html__('Description for feature three.', 'elementor-starter-kit'),
                    ],
                ],
                'title_field' => '{{{ feature_title }}}',
            ]
        );

        $this->end_controls_section();

        // Layout Section
        $this->start_controls_section(
            'layout_section',
            [
                'label' => esc_html__('Layout', 'elementor-starter-kit'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label' => esc_html__('Columns', 'elementor-starter-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ],
                'selectors' => [
                    '{{WRAPPER}} .starter-features-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ],
            ]
        );

        $this->add_responsive_control(
            'column_gap',
            [
                'label' => esc_html__('Column Gap', 'elementor-starter-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .starter-features-grid' => 'column-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'row_gap',
            [
                'label' => esc_html__('Row Gap', 'elementor-starter-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .starter-features-grid' => 'row-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Items
        $this->start_controls_section(
            'items_style_section',
            [
                'label' => esc_html__('Items', 'elementor-starter-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'item_background',
            [
                'label' => esc_html__('Background Color', 'elementor-starter-kit'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .starter-feature-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'selector' => '{{WRAPPER}} .starter-feature-item',
            ]
        );

        $this->add_responsive_control(
            'item_border_radius',
            [
                'label' => esc_html__('Border Radius', 'elementor-starter-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .starter-feature-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_box_shadow',
                'selector' => '{{WRAPPER}} .starter-feature-item',
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label' => esc_html__('Padding', 'elementor-starter-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default' => [
                    'top' => '30',
                    'right' => '30',
                    'bottom' => '30',
                    'left' => '30',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .starter-feature-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Icon
        $this->start_controls_section(
            'icon_style_section',
            [
                'label' => esc_html__('Icon', 'elementor-starter-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Color', 'elementor-starter-kit'),
                'type' => Controls_Manager::COLOR,
                'default' => '#0073aa',
                'selectors' => [
                    '{{WRAPPER}} .starter-feature-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .starter-feature-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Size', 'elementor-starter-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 200,
                    ],
                ],
                'default' => [
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .starter-feature-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .starter-feature-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .starter-feature-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .starter-feature-title',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        if (empty($settings['features_list'])) {
            return;
        }

        ?>
        <div class="starter-features-grid">
            <?php foreach ($settings['features_list'] as $index => $item) :
                $link_key = 'link_' . $index;
                
                if (!empty($item['feature_link']['url'])) {
                    $this->add_link_attributes($link_key, $item['feature_link']);
                }
                ?>
                <div class="starter-feature-item">
                    <?php if (!empty($item['feature_icon']['value'])) : ?>
                        <div class="starter-feature-icon">
                            <?php \Elementor\Icons_Manager::render_icon($item['feature_icon'], ['aria-hidden' => 'true']); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($item['feature_image']['url'])) : ?>
                        <div class="starter-feature-image">
                            <img src="<?php echo esc_url($item['feature_image']['url']); ?>" alt="<?php echo esc_attr($item['feature_title']); ?>">
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($item['feature_title'])) : ?>
                        <h3 class="starter-feature-title">
                            <?php if (!empty($item['feature_link']['url'])) : ?>
                                <a <?php echo $this->get_render_attribute_string($link_key); ?>>
                                    <?php echo esc_html($item['feature_title']); ?>
                                </a>
                            <?php else : ?>
                                <?php echo esc_html($item['feature_title']); ?>
                            <?php endif; ?>
                        </h3>
                    <?php endif; ?>

                    <?php if (!empty($item['feature_description'])) : ?>
                        <p class="starter-feature-description"><?php echo esc_html($item['feature_description']); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }
}
# Elementor Starter Kit

A reusable boilerplate for creating WordPress plugins that extend Elementor with custom widgets, controls, and panels.

## File Structure

```
elementor-starter-kit/
├── elementor-starter-kit.php              # Main plugin file
├── includes/
│   ├── class-widgets-manager.php          # Auto-discovers & registers widgets
│   └── widgets/
│       ├── class-example-widget.php       # Basic widget example
│       └── class-advanced-widget.php      # Advanced widget with repeater
├── assets/
│   ├── css/
│   │   ├── frontend.css                  # Frontend styles
│   │   └── editor.css                    # Editor-only styles
│   └── js/
│       └── frontend.js                   # Frontend JavaScript
├── languages/                             # Translation files
└── README.md                              # This file
```

## Quick Start

### 1. Clone or Download
Download this starter kit and place it in your `wp-content/plugins/` directory.

### 2. Rename for Your Project
To create a new plugin (e.g., "Dynamic Content"):

**Find and Replace:**
- `Elementor Starter Kit` → `Dynamic Content`
- `elementor-starter-kit` → `dynamic-content`
- `elementor_starter_kit` → `dynamic_content`
- `Elementor_Starter_Kit` → `Dynamic_Content`

**Rename Files:**
- `elementor-starter-kit.php` → `dynamic-content.php`
- Folder: `elementor-starter-kit/` → `dynamic-content/`

### 3. Update Plugin Header
Edit the main plugin file header:
```php
/**
 * Plugin Name: Dynamic Content
 * Description: Add dynamic content widgets to Elementor
 * Version: 1.0.0
 * Author: Your Name
 * Text Domain: dynamic-content
 */
```

### 4. Activate Plugin
Go to WordPress admin → Plugins → Activate your plugin.

## Creating New Widgets

### Basic Widget Template

Create a new file in `includes/widgets/class-my-widget.php`:

```php
<?php
namespace Your_Plugin_Name\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class My_Widget extends Widget_Base {
    
    public function get_name() {
        return 'my_widget_name';
    }
    
    public function get_title() {
        return esc_html__('My Widget', 'text-domain');
    }
    
    public function get_icon() {
        return 'eicon-code';
    }
    
    public function get_categories() {
        return ['starter-kit-category']; // or your custom category
    }
    
    protected function register_controls() {
        // Add your controls here
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'text-domain'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $this->add_control(
            'my_control',
            [
                'label' => esc_html__('Title', 'text-domain'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Default text', 'text-domain'),
            ]
        );
        
        $this->end_controls_section();
    }
    
    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="my-widget-wrapper">
            <h2><?php echo esc_html($settings['my_control']); ?></h2>
        </div>
        <?php
    }
}
```

### Register Your Widget

In the main plugin file, add:

```php
// Include the widget file
require_once(__DIR__ . '/includes/widgets/class-my-widget.php');

// Register in the register_widgets() method
public function register_widgets($widgets_manager) {
    $widgets_manager->register(new \Your_Plugin_Name\Widgets\My_Widget());
}
```

## Common Control Types

```php
// Text Input
$this->add_control('title', [
    'label' => 'Title',
    'type' => Controls_Manager::TEXT,
    'default' => 'Default text',
]);

// Textarea
$this->add_control('description', [
    'label' => 'Description',
    'type' => Controls_Manager::TEXTAREA,
    'rows' => 5,
]);

// Color Picker
$this->add_control('color', [
    'label' => 'Color',
    'type' => Controls_Manager::COLOR,
    'selectors' => [
        '{{WRAPPER}} .element' => 'color: {{VALUE}};',
    ],
]);

// Image Upload
$this->add_control('image', [
    'label' => 'Image',
    'type' => Controls_Manager::MEDIA,
]);

// Select Dropdown
$this->add_control('layout', [
    'label' => 'Layout',
    'type' => Controls_Manager::SELECT,
    'options' => [
        'grid' => 'Grid',
        'list' => 'List',
    ],
    'default' => 'grid',
]);

// Switcher (Toggle)
$this->add_control('show_title', [
    'label' => 'Show Title',
    'type' => Controls_Manager::SWITCHER,
    'label_on' => 'Yes',
    'label_off' => 'No',
    'return_value' => 'yes',
    'default' => 'yes',
]);

// URL Input
$this->add_control('link', [
    'label' => 'Link',
    'type' => Controls_Manager::URL,
    'placeholder' => 'https://example.com',
]);

// Typography Group Control
$this->add_group_control(
    Group_Control_Typography::get_type(),
    [
        'name' => 'title_typography',
        'selector' => '{{WRAPPER}} .title',
    ]
);

// Repeater (for lists)
$repeater = new Repeater();
$repeater->add_control('item_title', [
    'label' => 'Title',
    'type' => Controls_Manager::TEXT,
]);

$this->add_control('items', [
    'label' => 'Items',
    'type' => Controls_Manager::REPEATER,
    'fields' => $repeater->get_controls(),
]);
```

## Adding Custom Widget Categories

In the main plugin file:

```php
public function register_categories($elements_manager) {
    $elements_manager->add_category(
        'my-custom-category',
        [
            'title' => esc_html__('My Widgets', 'text-domain'),
            'icon' => 'fa fa-plug',
        ]
    );
}
```

## Styling Your Widgets

### Frontend Styles
Add styles in `assets/css/frontend.css` - these load on the public site.

### Editor Styles
Add styles in `assets/css/editor.css` - these only load in the Elementor editor.

### Dynamic Styles
Use selectors in your controls:
```php
'selectors' => [
    '{{WRAPPER}} .my-element' => 'color: {{VALUE}};',
],
```

## Common Customizations

### Change Widget Icon
Available icons: https://elementor.github.io/elementor-icons/

```php
public function get_icon() {
    return 'eicon-posts-ticker'; // Change to any Elementor icon
}
```

### Add Widget Keywords (for search)
```php
public function get_keywords() {
    return ['keyword1', 'keyword2', 'search-term'];
}
```

### Make Widget Pro Only
```php
public function get_custom_help_url() {
    return 'https://your-docs-url.com';
}

public function is_reload_preview_required() {
    return true; // Reload preview when settings change
}
```

## Translation Ready

### Generate Translation Files
1. Install Poedit or use WP-CLI
2. Scan the plugin for translatable strings
3. Create `.pot` file in `languages/` folder

### Using Translations
All strings use the text domain specified in plugin header:
```php
esc_html__('Text to translate', 'your-text-domain');
```

## Useful Resources

- [Elementor Developers Documentation](https://developers.elementor.com/)
- [Widget Development Guide](https://developers.elementor.com/docs/widgets/)
- [Controls Reference](https://developers.elementor.com/docs/controls/)
- [Dynamic Tags](https://developers.elementor.com/docs/dynamic-tags/)

## Debugging

Enable WordPress debug mode in `wp-config.php`:
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

Check logs in `wp-content/debug.log`

## Checklist for New Plugin

- [ ] Find/Replace all names and namespaces
- [ ] Update plugin header information
- [ ] Rename main plugin file and folder
- [ ] Update text domain throughout
- [ ] Create your custom widgets
- [ ] Test in Elementor editor
- [ ] Test on frontend
- [ ] Add custom CSS if needed
- [ ] Add custom JavaScript if needed
- [ ] Test on different screen sizes
- [ ] Check for PHP/WordPress errors

## Example Use Cases

**Dynamic Content Plugin:**
- Posts grid widget
- Custom post type widget
- User profile widget
- ACF fields widget

**Forms Plugin:**
- Contact form widget
- Newsletter signup widget
- Multi-step form widget

**Social Plugin:**
- Social share buttons
- Social feed widget
- Review/testimonial widget

## Tips

1. **Keep widgets focused** - One widget, one purpose
2. **Use dynamic tags** - Let users insert dynamic content
3. **Responsive controls** - Always add responsive options
4. **Performance** - Minimize external API calls
5. **Security** - Always escape and sanitize output
6. **Documentation** - Comment your code thoroughly

## Contributing

Feel free to fork this starter kit and make it your own!

## License

GPL v2 or later

---

## Credits

Developed by **AmrShah** & Team

For support, improvements, or contributions, please open an issue or submit a pull request on GitHub.

## Developer Contact

For professional WordPress development, performance optimization, or custom plugin work,  
contact **Amr Shah** - creator of this plugin and lead developer at [AlamiaSoft](https://amrshah.github.io).

- **Website:** [https://amrshah.github.io](https://amrshah.github.io)  
- **GitHub:** [https://github.com/amrshah](https://github.com/amrshah)  
- **Email:** amr.shah@gmail.com  


We build scalable tools, custom dashboards, and performance-focused WordPress/custom solutions for businesses worldwide.

**Happy Widget Building! **

# Quick Installation Guide

## For First Time Use (Testing the Starter Kit)

### 1. Upload to WordPress
```bash
# Upload the entire folder to:
wp-content/plugins/elementor-starter-kit/
```

### 2. Activate Plugin
- Go to: **WordPress Admin → Plugins**
- Find: **Elementor Starter Kit**
- Click: **Activate**

### 3. Test the Widgets
- Edit any page with Elementor
- Search for: **"Example Widget"** or **"Advanced Features"**
- Drag widgets to your page
- Customize and preview!

---

## For Creating Your Own Plugin

### Method 1: Using Find & Replace (Recommended)

#### Step 1: Duplicate the Folder
```bash
# Copy the entire starter kit folder
cp -r elementor-starter-kit/ my-awesome-plugin/
```

#### Step 2: Find & Replace ALL Files
Use your code editor's "Find in Files" feature:

| Find This | Replace With |
|-----------|--------------|
| `Elementor Starter Kit` | `My Awesome Plugin` |
| `elementor-starter-kit` | `my-awesome-plugin` |
| `elementor_starter_kit` | `my_awesome_plugin` |
| `Elementor_Starter_Kit` | `My_Awesome_Plugin` |

**Tools:**
- VS Code: `Ctrl+Shift+H` (Find & Replace in Files)
- PHPStorm: `Ctrl+Shift+R`
- Sublime Text: `Ctrl+Shift+F`

#### Step 3: Rename Files
```bash
# Rename the main plugin file
mv elementor-starter-kit.php my-awesome-plugin.php

# Rename the folder
mv elementor-starter-kit/ my-awesome-plugin/
```

#### Step 4: Update Plugin Header
Open `my-awesome-plugin.php` and update:

```php
/**
 * Plugin Name: My Awesome Plugin
 * Description: Amazing Elementor widgets for awesome things
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://yourwebsite.com
 * Text Domain: my-awesome-plugin
 */
```

#### Step 5: Upload & Activate
```bash
# Upload to WordPress
wp-content/plugins/my-awesome-plugin/

# Then activate in WordPress admin
```

---

### Method 2: Using Command Line (Linux/Mac)

```bash
#!/bin/bash

# Set your new plugin details
OLD_NAME="elementor-starter-kit"
NEW_NAME="my-awesome-plugin"
OLD_CLASS="Elementor_Starter_Kit"
NEW_CLASS="My_Awesome_Plugin"

# Copy folder
cp -r $OLD_NAME $NEW_NAME
cd $NEW_NAME

# Find and replace in all files
find . -type f -name "*.php" -exec sed -i "s/$OLD_NAME/$NEW_NAME/g" {} +
find . -type f -name "*.php" -exec sed -i "s/$OLD_CLASS/$NEW_CLASS/g" {} +

# Rename main file
mv $OLD_NAME.php $NEW_NAME.php

echo "Plugin renamed successfully!"
```

---

### Method 3: Using WP-CLI

```bash
# Navigate to plugins directory
cd wp-content/plugins/

# Duplicate the starter kit
wp scaffold plugin my-awesome-plugin --skip-tests
rm -rf my-awesome-plugin/*
cp -r elementor-starter-kit/* my-awesome-plugin/

# Now do find & replace as in Method 1
```

---

## Post-Installation Checklist

After renaming, verify:

- [ ] Main plugin file renamed correctly
- [ ] Plugin activates without errors
- [ ] Widgets appear in Elementor panel
- [ ] Widget category shows your plugin name
- [ ] No PHP errors in debug log
- [ ] Text domain updated throughout
- [ ] Plugin header information updated

---

## Customization After Installation

### 1. Add Your First Widget

Create: `includes/widgets/class-my-first-widget.php`

```php
<?php
namespace My_Awesome_Plugin\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class My_First_Widget extends Widget_Base {
    
    public function get_name() {
        return 'my_first_widget';
    }
    
    public function get_title() {
        return esc_html__('My First Widget', 'my-awesome-plugin');
    }
    
    public function get_icon() {
        return 'eicon-star';
    }
    
    public function get_categories() {
        return ['my-plugin-category']; // Update category name
    }
    
    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'my-awesome-plugin'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'my-awesome-plugin'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Hello World', 'my-awesome-plugin'),
            ]
        );
        
        $this->end_controls_section();
    }
    
    protected function render() {
        $settings = $this->get_settings_for_display();
        echo '<h2>' . esc_html($settings['title']) . '</h2>';
    }
}
```

**Save and refresh Elementor - your widget appears automatically!** 

### 2. Update Widget Category

In main plugin file, find `register_categories()`:

```php
public function register_categories($elements_manager) {
    $elements_manager->add_category(
        'my-plugin-category', // Change this
        [
            'title' => esc_html__('My Plugin Widgets', 'my-awesome-plugin'), // And this
            'icon' => 'fa fa-rocket', // Custom icon
        ]
    );
}
```

### 3. Delete Example Widgets (Optional)

If you don't need the example widgets:

```bash
# Delete example widget files
rm includes/widgets/class-example-widget.php
rm includes/widgets/class-advanced-widget.php
```

They won't be loaded anymore (auto-discovery only loads existing files).

---

## Troubleshooting

### Plugin doesn't activate
- Check PHP version (requires 7.4+)
- Check if Elementor is installed and activated
- Check for PHP syntax errors

### Widgets don't appear
- Clear Elementor cache: **Elementor → Tools → Regenerate Files**
- Check file naming: must start with `class-` 
- Check class name matches file name
- Enable WP_DEBUG and check logs

### Find & Replace missed some text
- Search your codebase for the old plugin name
- Update manually
- Common places: comments, documentation, CSS classes

---

## Next Steps

1. Read the main [README.md](README.md) for detailed documentation
2. Copy [widget-template.php](includes/widgets/widget-template.php) to create new widgets
3. Customize styles in `assets/css/frontend.css`
4. Add JavaScript in `assets/js/frontend.js`
5. Create more widgets!

---

## Quick Commands Reference

```bash
# Activate plugin via WP-CLI
wp plugin activate my-awesome-plugin

# Check for PHP errors
tail -f wp-content/debug.log

# Clear Elementor cache
wp elementor flush_css

# List all active plugins
wp plugin list --status=active
```

---

**Need Help?** Check the [README.md](README.md) for detailed documentation!

## Credits

Developed by the **AmrShah**

For support, improvements, or contributions, please open an issue or submit a pull request on GitHub.

## Developer Contact

For professional WordPress development, performance optimization, or custom plugin work,  
contact **Amr Shah** - creator of this plugin and lead developer at [AlamiaSoft](https://amrshah.github.io).

- **Website:** [https://amrshah.github.io](https://amrshah.github.io)  
- **GitHub:** [https://github.com/amrshah](https://github.com/amrshah)  
- **Email:** amr.shah@gmail.com  


We build scalable tools, custom dashboards, and performance-focused WordPress/custom solutions for businesses worldwide.

**Happy Widget Building! **
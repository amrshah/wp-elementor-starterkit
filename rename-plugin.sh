#!/bin/bash

# ============================================
# Elementor Starter Kit - Rename Script
# ============================================
# 
# This script automates the process of renaming
# the starter kit for your new plugin.
# 
# Usage: ./rename-plugin.sh "My Awesome Plugin"
# 
# ============================================

set -e  # Exit on error

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored messages
print_success() {
    echo -e "${GREEN}✓ $1${NC}"
}

print_error() {
    echo -e "${RED}✗ $1${NC}"
}

print_info() {
    echo -e "${BLUE}ℹ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠ $1${NC}"
}

# Function to convert string to different cases
to_lowercase_hyphen() {
    echo "$1" | tr '[:upper:]' '[:lower:]' | tr ' ' '-'
}

to_lowercase_underscore() {
    echo "$1" | tr '[:upper:]' '[:lower:]' | tr ' ' '_' | tr '-' '_'
}

to_pascalcase_underscore() {
    echo "$1" | sed -r 's/(^|[- ])(\w)/\U\2/g' | tr '-' '_' | tr ' ' '_'
}

# Banner
echo ""
echo "╔════════════════════════════════════════════╗"
echo "║   Elementor Starter Kit - Rename Tool     ║"
echo "╚════════════════════════════════════════════╝"
echo ""

# Check if plugin name is provided
if [ -z "$1" ]; then
    print_error "Please provide a plugin name!"
    echo ""
    echo "Usage: ./rename-plugin.sh \"My Awesome Plugin\""
    echo ""
    echo "Examples:"
    echo "  ./rename-plugin.sh \"Dynamic Content\""
    echo "  ./rename-plugin.sh \"Custom Forms\""
    echo "  ./rename-plugin.sh \"Advanced Widgets\""
    echo ""
    exit 1
fi

NEW_PLUGIN_NAME="$1"

# Generate different naming conventions
NEW_SLUG=$(to_lowercase_hyphen "$NEW_PLUGIN_NAME")
NEW_SLUG_UNDERSCORE=$(to_lowercase_underscore "$NEW_PLUGIN_NAME")
NEW_CLASS_NAME=$(to_pascalcase_underscore "$NEW_PLUGIN_NAME")

# Old values
OLD_NAME="Elementor Starter Kit"
OLD_SLUG="elementor-starter-kit"
OLD_SLUG_UNDERSCORE="elementor_starter_kit"
OLD_CLASS_NAME="Elementor_Starter_Kit"

# Display conversion plan
print_info "Conversion Plan:"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "Plugin Name:       $NEW_PLUGIN_NAME"
echo "Slug (hyphen):     $NEW_SLUG"
echo "Slug (underscore): $NEW_SLUG_UNDERSCORE"
echo "Class Name:        $NEW_CLASS_NAME"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

# Confirmation
read -p "Continue with rename? (y/n): " -n 1 -r
echo ""
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    print_warning "Rename cancelled."
    exit 0
fi

echo ""
print_info "Starting rename process..."
echo ""

# Step 1: Find and replace in all PHP files
print_info "Step 1/5: Updating PHP files..."

find . -type f -name "*.php" ! -path "./vendor/*" ! -path "./node_modules/*" -exec sed -i.bak \
    -e "s/$OLD_NAME/$NEW_PLUGIN_NAME/g" \
    -e "s/$OLD_SLUG/$NEW_SLUG/g" \
    -e "s/$OLD_SLUG_UNDERSCORE/$NEW_SLUG_UNDERSCORE/g" \
    -e "s/$OLD_CLASS_NAME/$NEW_CLASS_NAME/g" \
    {} +

# Remove backup files
find . -name "*.bak" -type f -delete

print_success "PHP files updated"

# Step 2: Update CSS files
print_info "Step 2/5: Updating CSS files..."

find . -type f -name "*.css" -exec sed -i.bak \
    -e "s/$OLD_SLUG/$NEW_SLUG/g" \
    {} +

find . -name "*.bak" -type f -delete

print_success "CSS files updated"

# Step 3: Update JavaScript files
print_info "Step 3/5: Updating JavaScript files..."

find . -type f -name "*.js" -exec sed -i.bak \
    -e "s/$OLD_SLUG/$NEW_SLUG/g" \
    -e "s/$OLD_SLUG_UNDERSCORE/$NEW_SLUG_UNDERSCORE/g" \
    -e "s/$OLD_CLASS_NAME/$NEW_CLASS_NAME/g" \
    {} +

find . -name "*.bak" -type f -delete

print_success "JavaScript files updated"

# Step 4: Update README and documentation
print_info "Step 4/5: Updating documentation..."

find . -type f \( -name "*.md" -o -name "*.txt" \) -exec sed -i.bak \
    -e "s/$OLD_NAME/$NEW_PLUGIN_NAME/g" \
    -e "s/$OLD_SLUG/$NEW_SLUG/g" \
    -e "s/$OLD_SLUG_UNDERSCORE/$NEW_SLUG_UNDERSCORE/g" \
    -e "s/$OLD_CLASS_NAME/$NEW_CLASS_NAME/g" \
    {} +

find . -name "*.bak" -type f -delete

print_success "Documentation updated"

# Step 5: Rename main plugin file
print_info "Step 5/5: Renaming main plugin file..."

if [ -f "$OLD_SLUG.php" ]; then
    mv "$OLD_SLUG.php" "$NEW_SLUG.php"
    print_success "Main plugin file renamed to $NEW_SLUG.php"
else
    print_warning "Main plugin file not found at expected location"
fi

echo ""
echo "╔════════════════════════════════════════════╗"
echo "║           Rename Complete! ✓               ║"
echo "╚════════════════════════════════════════════╝"
echo ""

print_success "Plugin successfully renamed to: $NEW_PLUGIN_NAME"
echo ""

# Next steps
print_info "Next Steps:"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "1. Rename this folder to: $NEW_SLUG"
echo "2. Move to WordPress plugins directory:"
echo "   wp-content/plugins/$NEW_SLUG/"
echo "3. Activate plugin in WordPress admin"
echo "4. Start creating your widgets!"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

print_info "Optional: Update plugin header details in $NEW_SLUG.php"
echo "  - Author name"
echo "  - Author URI"
echo "  - Description"
echo "  - Version"
echo ""

print_warning "Don't forget to:"
echo "  ✓ Update widget category name in main file"
echo "  ✓ Delete example widgets if not needed"
echo "  ✓ Clear Elementor cache after activation"
echo ""

# Check if we're in a git repository
if [ -d ".git" ]; then
    print_info "Git repository detected."
    read -p "Initialize new git repository? (y/n): " -n 1 -r
    echo ""
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        rm -rf .git
        git init
        git add .
        git commit -m "Initial commit: $NEW_PLUGIN_NAME"
        print_success "New git repository initialized"
    fi
fi

echo ""
print_success "All done! Happy coding! "
echo ""
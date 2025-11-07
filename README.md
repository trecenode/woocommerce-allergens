# Allergens System for WooCommerce

![WordPress Plugin Version](https://img.shields.io/badge/version-1.6.1-blue)
![WordPress](https://img.shields.io/badge/WordPress-3.8%2B-brightgreen)
![WooCommerce](https://img.shields.io/badge/WooCommerce-required-purple)
![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4)
![License](https://img.shields.io/badge/license-GPLv2%2B-red)

A comprehensive WordPress plugin that adds allergen information to WooCommerce products with full WPML and page builder compatibility.

## 📋 Description

This plugin adds **allergens** to each product in your WooCommerce store, helping you comply with food labeling regulations and inform your customers about potential allergens.

## ✨ Features

- ✅ Add allergens to simple and variable products
- 🎨 Display allergens with customizable icons (Classic or Trece theme)
- 🌍 **Full WPML compatibility** - allergens automatically copy to translations
- 🏗️ **Page builder compatible** (Oxygen, Elementor, Bricks, Divi, etc.)
- ⚡ Pure JavaScript system for maximum compatibility (no template overrides)
- ♿ Accessibility friendly with proper ARIA labels
- 📂 Custom tab in product admin for easy management
- 👨‍💻 Developer-friendly function for custom themes: `treceafw_show_allergens_out()`

## 🚀 Installation

1. Upload the `allergens-woocommerce` plugin folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure allergen icons under **WooCommerce > Allergens**
4. Start adding allergens to your products!

## 👨‍💻 For Developers

Use the `treceafw_show_allergens_out($product)` function to display allergens in your custom theme or plugin:

```php
<?php
if (function_exists('treceafw_show_allergens_out')) {
    echo treceafw_show_allergens_out($product);
}
?>
```

For more information, see [DEVELOPER-GUIDE.md](DEVELOPER-GUIDE.md)

## 🌍 WPML Compatibility

When using WPML, allergen settings are **automatically copied** to product translations. No need to manually reconfigure allergens for each language - they will be inherited from the original product.

**Key features:**
- Automatic synchronization on product save
- Works with simple and variable products
- Auto-configuration via `wpml-config.xml`

See [WPML-COMPATIBILITY.md](WPML-COMPATIBILITY.md) for more details.

## 🏗️ Page Builder Compatibility

Works seamlessly with modern page builders:
- ✅ Oxygen Builder
- ✅ Elementor
- ✅ Bricks Builder
- ✅ Divi Builder
- ✅ And any other page builder!

Uses pure JavaScript to dynamically inject allergens, avoiding template conflicts.

## 📸 Screenshots

![Product Page](screenshot-1.png)

## 🎨 Credits

- **Classic Icons**: Allergen icons by Icon Icons ([link](https://blog.icon-icons.com/food-allergen-icons/))
- **Trece Icons**: By 13Node ([13node.com](https://13node.com))

## 📝 Changelog

### 1.6.1
- Documentation improvements
- GitHub README.md added

### 1.6.0
- **Page Builder Compatibility**: Works with Oxygen, Elementor, Bricks, Divi, etc.
- Pure JavaScript system for maximum compatibility (no template overrides)
- Dynamic allergen display using WooCommerce events
- Re-added `treceafw_show_allergens_out()` function for custom themes/plugins
- Simplified codebase - removed template override system

### 1.5.0
- **WPML Compatibility**: Allergens now automatically copy to product translations
- Auto-configuration of WPML custom fields for allergens
- Support for variable products with WPML
- Added `wpml-config.xml` for automatic field configuration

### 1.4.0
- Accessibility fixes and icon design options under WooCommerce > Allergens

### 1.3.5.1
- Better view in smaller screens
- Fixed PHP error in some WordPress installations

### 1.3.4
- CSS Hotfix

### 1.3.3
- Hotfix: not deleting on variation

### 1.3.2
- Added Pistachio allergen
- Better CSS in variations
- Added `treceafw_show_allergens_out()` function for developers

### 1.3.1
- CSS fixes
- Now doesn't replace the short description

### 1.3
- Added allergens for variations
- Added custom tab for allergens

### 1.2
- Better code structure and function names

### 1.1
- Added missing allergen icons

### 1.0
- Initial release

## 📧 Support

We do web development and if you need a developer or if you think you have found a bug in the plugin, please feel free to contact us at **info@13node.com**

## 📄 License

This plugin is licensed under the GPLv2 or later.
[https://www.gnu.org/licenses/gpl-2.0.html](https://www.gnu.org/licenses/gpl-2.0.html)
=== Allergens System for Woocommerce ===
Contributors: ulloa
Tags: woocommerce, allergens
Requires at least: 3.8
Tested up to: 6.8
Stable tag: 1.6.2
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Tags: woocommerce, allergens 

Allergens System for Woocommerce

== Description ==
This plugin add <strong>allergens</strong> to each product in your store.

<strong>Features:</strong>
* Add allergens to simple and variable products
* Display allergens with customizable icons (Classic or Trece theme)
* Full WPML compatibility - allergens automatically copy to translations
* Page builder compatible (Oxygen, Elementor, Bricks, Divi, etc.)
* Pure JavaScript system for maximum compatibility (no template overrides)
* Accessibility friendly with proper ARIA labels
* Custom tab in product admin for easy management
* Developer-friendly function for custom themes: treceafw_show_allergens_out()

<strong>For Developers:</strong>
Use the `treceafw_show_allergens_out($product)` function to display allergens in your custom theme or plugin:
```php
<?php
if (function_exists('treceafw_show_allergens_out')) {
    echo treceafw_show_allergens_out($product);
}
?>
```

<strong>WPML Compatibility:</strong>
When using WPML, allergen settings are automatically copied to product translations. No need to manually reconfigure allergens for each language - they will be inherited from the original product.

<strong>Page Builder Compatibility:</strong>
Works seamlessly with modern page builders like Oxygen Builder, Elementor, Bricks, and Divi. Uses pure JavaScript to dynamically inject allergens, avoiding template conflicts.

We do web development and if you need a developer or if you think you have found a bug in plugin, if you have any question, please feel free to contact us by this email info@13node.com.

== Credits ==
Classic Icons by Allergens icons by Icon Icons (https://blog.icon-icons.com/food-allergen-icons/)
Trece Icons by 13Node (https://13node.com)

== Installation ==

1. Upload the 'allergens-woocommerce' plugin folder to the '/wp-content/plugins/' directory.
2. Activate the "allergens-woocommerce" list plugin through the 'Plugins' menu in WordPress.
3. Ready, add some sales with date and watch.

== Screenshots ==
1- Product Page

== Changelog ==
= 1.6.2 =
* Fixed fatal error: Call to a member function is_type() on string
* Added proper validation for $product object before calling methods
= 1.6.1 =
* Fixes
= 1.6.0 =
* Page Builder Compatibility: Works with Oxygen, Elementor, Bricks, Divi, etc.
* Pure JavaScript system for maximum compatibility (no template overrides)
* Dynamic allergen display using WooCommerce events
* Re-added treceafw_show_allergens_out() function for custom themes/plugins
* Simplified codebase - removed template override system
= 1.5.0 =
* WPML Compatibility: Allergens now automatically copy to product translations
* Auto-configuration of WPML custom fields for allergens
* Support for variable products with WPML
* Added wpml-config.xml for automatic field configuration
= 1.4.0 =
* Accesibility Fixes and Icons Designs options under Woocommerce > Allergens
= 1.3.5.1 =
* Better view in smaller screens and fixed a php error in some wordpress.
= 1.3.4 =
* CSS Hotfix
= 1.3.3 =
* Hotfix: not deleting on variation
= 1.3.2 =
* Added the Pistacho due to a client's needs
* Better css in variations
* Added treceafw_show_allergens_out() function for developers
= 1.3.1 =
* A lot of css fixes and now dont replace the short description.
= 1.3 =
* Added Allergens for variations and add a custom tab for allergens.
= 1.2 =
* Better code structure and functions names.
= 1.1 =
* Added missing allergens icons
= 1.0 =
* Plugin publish
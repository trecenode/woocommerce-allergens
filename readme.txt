=== Allergens System for Woocommerce ===
Contributors: ulloa
Tags: woocommerce, allergens
Requires at least: 3.8
Tested up to: 5.9
Stable tag: 1.3
Requires PHP: 5.3
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Tags: woocommerce, allergens 

Allergens System for Woocommerce

== Description ==
This plugin add <strong>allergens</strong> to each product in your store.

We do web development and if you need a developer or if you think you have found a bug in plugin, if you have any question, please feel free to contact us by this email info@13node.com.

== Credits ==
Allergens icons by Icon Icons (https://blog.icon-icons.com/food-allergen-icons/)

== Installation ==

1. Upload the 'allergens-woocommerce' plugin folder to the '/wp-content/plugins/' directory.
2. Activate the "allergens-woocommerce" list plugin through the 'Plugins' menu in WordPress.
3. Ready, add some products with allergens.

== Screenshots ==
1- Product Page

== Changelog ==
= 1.3.2 =
Added `treceafw_show_allergens_out($product)` function, to allow developers to call allergens in their theme/plugin. For avoid problems you can add a checking before call the function.

`<?php
if ( !function_exists( 'treceafw_show_allergens' ) ) {
    return;
} else {
    echo treceafw_show_allergensout($product);
}
?>`
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
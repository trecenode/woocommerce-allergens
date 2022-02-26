<?php
/**
 * Plugin Name: Allergens for Woocommerce
 * Plugin URI:  https://13node.com/informatica/wordpress/allergens-for-woocommerce/
 * Description: Show allergens in your product page.
 * Version: 1.0
 * Author: Danilo Ulloa
 * Author URI: https://13node.com
 * Text Domain: allergens-for-woocommerce
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'TRECE_TEXT_DOMAIN' ) ) {
	define( 'TRECE_TEXT_DOMAIN', 'allergens-for-woocommerce' );
}

add_action( 'after_setup_theme', 'trece_allergens_setup' );
function trece_allergens_setup(){
	load_plugin_textdomain( TRECE_TEXT_DOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

// Add custom CSS
function trece_allergens_css() {
    wp_enqueue_style( 'prefix-style', plugins_url('css/style.css', __FILE__) );
}
add_action( 'wp_enqueue_scripts', 'trece_allergens_css' );

// Woocommerce Allergens
$allergens_checkbox =array(
    'gluten' => __('Gluten', 'allergens-for-woocommerce'),
    'eggs' => __('Eggs', 'allergens-for-woocommerce'),
    'milk' => __('Milk', 'allergens-for-woocommerce'),
    'fish' => __('Fish', 'allergens-for-woocommerce'),
    'shellfish' => __('Shellfish', 'allergens-for-woocommerce'),
    'crustaceans' => __('Crustaceans', 'allergens-for-woocommerce'),
    'peanut' => __('Peanut', 'allergens-for-woocommerce'),
    'soy' => __('Soy', 'allergens-for-woocommerce'),
    'nuts' => __('Nuts', 'allergens-for-woocommerce'),
    'sesame' => __('Sesame', 'allergens-for-woocommerce'),
    'celery' => __('Celery', 'allergens-for-woocommerce'),
    'mustard' => __('Mustard', 'allergens-for-woocommerce'),
    'lupins' => __('Lupins', 'allergens-for-woocommerce'),
    'sulfites' => __('Sulfites', 'allergens-for-woocommerce'),
);
$allergens_icons =array(
    'gluten' => plugins_url().'/allergens-woocommerce/images/gluten.png',
    'eggs' => plugins_url().'/allergens-woocommerce/images/egg.png',
    'milk' => plugins_url().'/allergens-woocommerce/images/milk.png',
    'fish' => plugins_url().'/allergens-woocommerce/images/fish.png',
    'shellfish' => plugins_url().'/allergens-woocommerce/images/shellfish.png',
    'crustaceans' => plugins_url().'/allergens-woocommerce/images/crustaceans.png',
    'peanut' => plugins_url().'/allergens-woocommerce/images/peanut.png',
    'soy' => plugins_url().'/allergens-woocommerce/images/soy.png',
    'nuts' => plugins_url().'/allergens-woocommerce/images/nuts.png',
    'sesame' => plugins_url().'/allergens-woocommerce/images/sesame.png',
    'celery' => plugins_url().'/allergens-woocommerce/images/celery.png',
    'mustard' => plugins_url().'/allergens-woocommerce/images/mustard.png',
    'lupins' => plugins_url().'/allergens-woocommerce/images/lupins.png',
    'sulfites' => plugins_url().'/allergens-woocommerce/images/sulfites.png',

);
 
//Add Custom Fields
function trece_admin_allergens() {
    global $allergens_checkbox;

    foreach( $allergens_checkbox as $id => $label ) {
        woocommerce_wp_checkbox( array( 
            'id' => $id, 
            'label' => __( $label, 'woocommerce' )
        ) );
    }
}
add_action( 'woocommerce_product_options_pricing', 'trece_admin_allergens' );
 
//Update the values added in each field
function trece_save_allergens( $product_id ) {
    global $allergens_checkbox;
 
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    $trece_fields = array_merge($allergens_checkbox);
     
    foreach( $trece_fields as $field => $field_name ) {
        if ( isset( $_POST[$field] ) ) {
            update_post_meta( $product_id, $field, $_POST[$field] );
        } else {
            delete_post_meta( $product_id, $field );
        }
    }
}
add_action( 'save_post', 'trece_save_allergens' );
 
//Show the fields as icons in the product page
function trece_show_allergens() {
    global $product, $allergens_checkbox, $allergens_icons;
    if ( $product->product_type != 'variable' ) {
        $trece_fields = array_merge($allergens_checkbox);
     
        echo '<div class="allergen_title">'.__('Allergens', 'allergens-for-woocommerce').'</div>'. PHP_EOL;
        echo '<div class="allergens_wrapper">'. PHP_EOL;
        foreach( $trece_fields as $field => $field_name ) {
            $field_value = get_post_meta( $product->id, $field, true );
			
            if ( $field_value ) {
                echo '<div class="allergen_col">';
                echo '<img src="' . $allergens_icons[$field] . '" alt="' . $field_name . '" width="75" height="75" />'. PHP_EOL;
                echo '<span class="allergen_text">' . $field_name . '</span>'. PHP_EOL;
                echo '</div>'. PHP_EOL;
            }
        }
        echo '</div>'. PHP_EOL;
    }
}
add_action('woocommerce_short_description', 'trece_show_allergens');
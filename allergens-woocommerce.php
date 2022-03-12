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

add_action( 'init', 'trece_load_textdomain' );
function trece_load_textdomain(){
	load_plugin_textdomain( TRECE_TEXT_DOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

// Add custom CSS
function trece_allergens_css() {
    wp_enqueue_style( 'prefix-style', plugins_url('css/style.css', __FILE__) );
}
add_action( 'wp_enqueue_scripts', 'trece_allergens_css' );

// Woocommerce Allergens
$allergens_checkbox = array(
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

$allergens_icons = array(
    'gluten' => plugins_url( 'images/gluten.png', __FILE__ ),
    'eggs' => plugins_url( 'images/egg.png', __FILE__ ),
    'milk' => plugins_url( 'images/milk.png', __FILE__ ),
    'fish' => plugins_url( 'images/fish.png', __FILE__ ),
    'shellfish' => plugins_url( 'images/shellfish.png', __FILE__ ),
    'crustaceans' => plugins_url( 'images/crustaceans.png', __FILE__ ),
    'peanut' => plugins_url( 'images/peanut.png', __FILE__ ),
    'soy' => plugins_url( 'images/soy.png', __FILE__ ),
    'nuts' => plugins_url( 'images/nuts.png', __FILE__ ),
    'sesame' => plugins_url( 'images/sesame.png', __FILE__ ),
    'celery' => plugins_url( 'images/celery.png', __FILE__ ),
    'mustard' => plugins_url( 'images/mustard.png', __FILE__ ),
    'lupins' => plugins_url( 'images/lupins.png', __FILE__ ),
    'sulfites' => plugins_url( 'images/sulfites.png', __FILE__ ),

);
 
//Add Custom Fields
function trece_admin_allergens() {
    global $allergens_checkbox;

    foreach( $allergens_checkbox as $id => $label ) {
        woocommerce_wp_checkbox( array( 
            'id' => $id, 
            'label' => $label,
        ) );
    }
}
add_action( 'woocommerce_product_options_pricing', 'trece_admin_allergens' );

//Update the values added in each field
function trece_save_allergens($product_id) {
    global $allergens_checkbox;
 
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
        return;
    }
     
    foreach( $allergens_checkbox as $field => $field_name ) {
        $trece_checkbox = sanitize_text_field($_POST[$field]);

        if (isset($trece_checkbox)) {
            update_post_meta($product_id, $field, $trece_checkbox);
        } else {
            delete_post_meta($product_id, $field);
        }
    }
}
add_action( 'woocommerce_process_product_meta', 'trece_save_allergens' );
 
//Show the fields as icons in the product page
function trece_show_allergens() {
    global $product, $allergens_checkbox, $allergens_icons;
    if ( $product->product_type != 'variable' ) {

        echo '<div class="allergen_title">'.__('Allergens', 'allergens-for-woocommerce').'</div>'. PHP_EOL;
        echo '<div class="allergens_wrapper">'. PHP_EOL;
        foreach( $allergens_checkbox as $field => $field_name ) {
            $field_value = get_post_meta( $product->id, $field, true );
			
            if ( $field_value ) {
                echo '<div class="allergen_col">'. PHP_EOL;
                echo '<img src="'.esc_url($allergens_icons[$field]).'" alt="'.esc_html__($field_name).'" width="75" height="75" /><br />'. PHP_EOL;
                echo '<span class="allergen_text">'.esc_html__($field_name).'</span>'. PHP_EOL;
                echo '</div>'. PHP_EOL;
            }
        } 
        echo '</div>';
    }
}
add_action('woocommerce_short_description', 'trece_show_allergens');

<?php
/**
 * Plugin Name: Allergens for Woocommerce
 * Plugin URI:  https://13node.com/informatica/wordpress/allergens-for-woocommerce/
 * Description: Show allergens in your product page.
 * Version: 1.3.4
 * Author: Danilo Ulloa
 * Author URI: https://13node.com
 * Text Domain: allergens-for-woocommerce
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'TRECEAFW_TEXT_DOMAIN' ) ) {
	define( 'TRECEAFW_TEXT_DOMAIN', 'allergens-for-woocommerce' );
}

add_action( 'init', 'treceafw_load_textdomain' );
function treceafw_load_textdomain(){
	load_plugin_textdomain( TRECEAFW_TEXT_DOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

// Add custom CSS
function treceafw_allergens_css() {
    wp_enqueue_style( 'prefix-style', plugins_url('css/style.css', __FILE__) );
}
add_action('wp_enqueue_scripts', 'treceafw_allergens_css');

function treceafw_allergens_admin_css() {
    wp_enqueue_style('admin-styles', plugins_url('css/admin.css', __FILE__) );
}
add_action('admin_enqueue_scripts', 'treceafw_allergens_admin_css');

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
    'pistachio' => __('Pistachio', 'allergens-for-woocommerce'),
);

$allergens_icons = array(
    'gluten' => plugins_url( 'images/gluten.png', __FILE__ ),
    'eggs' => plugins_url( 'images/egg.png', __FILE__ ),
    'milk' => plugins_url( 'images/milk.png', __FILE__ ),
    'fish' => plugins_url( 'images/fish.png', __FILE__ ),
    'shellfish' => plugins_url( 'images/shellfish.png', __FILE__ ),
    'crustaceans' => plugins_url( 'images/crustacean.png', __FILE__ ),
    'peanut' => plugins_url( 'images/peanuts.png', __FILE__ ),
    'soy' => plugins_url( 'images/soy.png', __FILE__ ),
    'nuts' => plugins_url( 'images/nuts.png', __FILE__ ),
    'sesame' => plugins_url( 'images/sesame.png', __FILE__ ),
    'celery' => plugins_url( 'images/celery.png', __FILE__ ),
    'mustard' => plugins_url( 'images/mustard.png', __FILE__ ),
    'lupins' => plugins_url( 'images/lupins.png', __FILE__ ),
    'sulfites' => plugins_url( 'images/sulfites.png', __FILE__ ),
    'pistachio' => plugins_url( 'images/pistachio.png', __FILE__ ),

);
 
/* 
* Add Custom Fields to Single 
*/
add_filter('woocommerce_product_data_tabs', 'treceafw_custom_product_tab');
function treceafw_custom_product_tab($tabs) {
    $tabs['treceafw_tab'] = array(
        'label'   =>  __('Allergens', 'allergens-for-woocommerce'),
        'target'  =>  'treceafw_admin_allergens',
        'class'    => array( 'show_if_simple', 'show_if_external' ),
        'priority' => 80,
    );
    return $tabs;
}
add_action( 'woocommerce_product_data_panels', 'treceafw_admin_allergens' );
function treceafw_admin_allergens() {
    global $allergens_checkbox;

    echo '<div id="treceafw_admin_allergens" class="panel woocommerce_options_panel hidden">';
    echo '<div class="allergens_title">'.__('Allergens', 'allergens-for-woocommerce').'</div>'. PHP_EOL;
    echo '<div class="allergens_container">'. PHP_EOL;
    echo '<div class="allergens_row">'. PHP_EOL;
        foreach( $allergens_checkbox as $id => $label ) {
            echo '<div class="colu-3 dottedb">'. PHP_EOL;
            woocommerce_wp_checkbox( array( 
                'id' => $id, 
                'label' => $label,
            ) );
            echo '</div>';
        }
    echo '</div>';
    echo '</div>';
    echo '</div>';
}

//Update the values added in each field
function treceafw_save_allergens($product_id) {
    global $allergens_checkbox;
 
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
        return;
    }
     
    foreach( $allergens_checkbox as $field => $field_name ) {
        $treceafw_checkbox = sanitize_text_field($_POST[$field]);

        if (isset($treceafw_checkbox)) {
            update_post_meta($product_id, $field, $treceafw_checkbox);
        } else {
            delete_post_meta($product_id, $field);
        }
    }
}
add_action( 'woocommerce_process_product_meta', 'treceafw_save_allergens' );
 
//Show the fields as icons in the product page
function treceafw_show_allergens() {
    global $product, $allergens_checkbox, $allergens_icons;
    if ( $product->product_type != 'variable' ) {

        echo '<div class="allergen_title">'.__('Allergens', 'allergens-for-woocommerce').'</div>'. PHP_EOL;
        echo '<div class="allergens_container">'. PHP_EOL;
        echo '<div class="allergens_row">'. PHP_EOL;
        foreach( $allergens_checkbox as $field => $field_name ) {
            $field_value = get_post_meta( $product->id, $field, true );
			
            if ( $field_value ) {
                echo '<div class="colu-3">'. PHP_EOL;
                echo '<img src="'.esc_url($allergens_icons[$field]).'" alt="'.esc_html__($field_name).'" width="50" height="50" /><br />'. PHP_EOL;
                echo '<span class="allergen_text">'.esc_html__($field_name).'</span>'. PHP_EOL;
                echo '</div>'. PHP_EOL;
            }
        } 
        echo '</div>';
        echo '</div>';
    }
}
add_action('woocommerce_before_add_to_cart_form', 'treceafw_show_allergens');

/*
 Add Custom field to Variations
*/
add_action('woocommerce_product_after_variable_attributes', 'treceafw_variation_admin_allergens', 10, 3);
function treceafw_variation_admin_allergens($loop, $variation_data, $variation) {
    global $allergens_checkbox;

    echo '<div class="allergen_title">'.__('Allergens', 'allergens-for-woocommerce').'</div>'. PHP_EOL;
    echo '<div class="allergens_container">'. PHP_EOL;
    echo '<div class="allergens_row">'. PHP_EOL;
    foreach( $allergens_checkbox as $id => $label ) {
        echo '<div class="colu-3">'. PHP_EOL;
        woocommerce_wp_checkbox( array( 
            'id' => '_afwv_'.$id.'['. $loop.']', 
            'label' => $label,
            'value' => get_post_meta( $variation->ID, '_afwv_'.$id, true )
        ) );
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';
}
add_action('woocommerce_save_product_variation', 'treceafw_save_variations_allergens', 10, 2);
function treceafw_save_variations_allergens($variation_id, $i) {
    global $allergens_checkbox;

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
     
    foreach($allergens_checkbox as $field => $field_name) {
        $_treceafw_checkbox = $_POST['_afwv_'.$field][$i];

        if (isset($_treceafw_checkbox)) {
            update_post_meta($variation_id, '_afwv_'.$field, $_treceafw_checkbox);
        } else {
            delete_post_meta($variation_id, '_afwv_'.$field);
        }
    }
}
add_action( 'woocommerce_available_variation', 'treceafw_show_variations_allergens');
function treceafw_show_variations_allergens($variation) {
    global $product, $allergens_checkbox, $allergens_icons;

    if ($product->product_type == 'variable') {
        foreach( $allergens_checkbox as $field => $field_name ) {
            $variation['_afwv_'.$field] = get_post_meta($variation['variation_id'], '_afwv_'.$field, true);
            if ( $variation['_afwv_'.$field] == true) {
                $variation['_afwv_'.$field] = '<div class="colu-3"><img src="'.esc_url($allergens_icons[$field]).'" alt="'.esc_html__($field_name).'" width="48" height="48" /><br /><span class="allergen_text">'.esc_html__($field_name).'</span></div>';
            }
        }
        return $variation;
    }
}
// Add Template Files
add_filter('woocommerce_locate_template', 'treceafw_template', 1, 3);
   function treceafw_template( $template, $template_name, $template_path ) {
     global $woocommerce;
     $_template = $template;
     if ( ! $template_path ) 
        $template_path = $woocommerce->template_url;
 
        $plugin_path  = untrailingslashit( plugin_dir_path( __FILE__ ) )  . '/template/woocommerce/';
 
    // Look within passed path within the theme - this is priority
    $template = locate_template(
    array(
      $template_path . $template_name,
      $template_name
    )
   );
 
   if( ! $template && file_exists( $plugin_path . $template_name ) )
    $template = $plugin_path . $template_name;
 
   if ( ! $template )
    $template = $_template;

   return $template;
}
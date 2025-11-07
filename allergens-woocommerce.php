<?php
/**
 * Plugin Name: Allergens for Woocommerce
 * Plugin URI:  https://13node.com/en/producto/allergens-for-woocommerce/
 * Description: Show allergens in your product page.
 * Version: 1.6.0
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

// Add custom JavaScript for variation allergens (Page builder compatibility)
function treceafw_allergens_variation_js() {
    if (is_product()) {
        global $product;
        if ($product && $product->is_type('variable')) {
            wp_enqueue_script('treceafw-variations', plugins_url('js/variations.js', __FILE__), array('jquery'), '1.5.0', true);
            
            // Pass allergen labels and icon URLs to JavaScript
            global $allergens_checkbox;
            $allergens_icons = treceafw_get_allergen_icons();
            
            $allergens_data = array();
            foreach ($allergens_checkbox as $key => $label) {
                $allergens_data[$key] = array(
                    'label' => $label,
                    'icon' => $allergens_icons[$key]
                );
            }
            
            wp_localize_script('treceafw-variations', 'treceafwData', array(
                'allergens' => $allergens_data,
                'title' => __('Allergens', 'allergens-for-woocommerce'),
                'ariaLabel' => __('Product allergen information', 'allergens-for-woocommerce')
            ));
        }
    }
}
add_action('wp_enqueue_scripts', 'treceafw_allergens_variation_js');

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

// Function to get selected icon theme
function treceafw_get_icon_theme() {
    $theme = get_option('treceafw_icon_theme', 'classic');
    return $theme;
}

// Function to get icons based on selected theme
function treceafw_get_allergen_icons() {
    $theme = treceafw_get_icon_theme();
    $base_path = 'images/' . $theme . '/';

    return array(
        'gluten' => plugins_url( $base_path . 'gluten.png', __FILE__ ),
        'eggs' => plugins_url( $base_path . 'egg.png', __FILE__ ),
        'milk' => plugins_url( $base_path . 'milk.png', __FILE__ ),
        'fish' => plugins_url( $base_path . 'fish.png', __FILE__ ),
        'shellfish' => plugins_url( $base_path . 'shellfish.png', __FILE__ ),
        'crustaceans' => plugins_url( $base_path . 'crustacean.png', __FILE__ ),
        'peanut' => plugins_url( $base_path . 'peanuts.png', __FILE__ ),
        'soy' => plugins_url( $base_path . 'soy.png', __FILE__ ),
        'nuts' => plugins_url( $base_path . 'nuts.png', __FILE__ ),
        'sesame' => plugins_url( $base_path . 'sesame.png', __FILE__ ),
        'celery' => plugins_url( $base_path . 'celery.png', __FILE__ ),
        'mustard' => plugins_url( $base_path . 'mustard.png', __FILE__ ),
        'lupins' => plugins_url( $base_path . 'lupins.png', __FILE__ ),
        'sulfites' => plugins_url( $base_path . 'sulfites.png', __FILE__ ),
        'pistachio' => plugins_url( $base_path . 'pistachio.png', __FILE__ ),
    );
}

$allergens_icons = treceafw_get_allergen_icons();

// Add settings page to WooCommerce menu
add_action('admin_menu', 'treceafw_add_settings_page', 99);
function treceafw_add_settings_page() {
    add_submenu_page(
        'woocommerce',
        __('Allergens Settings', 'allergens-for-woocommerce'),
        __('Allergens', 'allergens-for-woocommerce'),
        'manage_woocommerce',
        'allergens-settings',
        'treceafw_render_settings_page'
    );
}

// Render settings page
function treceafw_render_settings_page() {
    // Save settings if form submitted
    if (isset($_POST['treceafw_save_settings']) && check_admin_referer('treceafw_settings_nonce')) {
        $icon_theme = sanitize_text_field($_POST['treceafw_icon_theme']);
        update_option('treceafw_icon_theme', $icon_theme);
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Settings saved successfully!', 'allergens-for-woocommerce') . '</p></div>';
    }

    $current_theme = treceafw_get_icon_theme();
    $available_themes = treceafw_get_available_themes();
    global $allergens_checkbox;
    ?>
    <div class="wrap treceafw-settings-wrap">
        <h1><?php echo esc_html__('Allergens for WooCommerce - Settings', 'allergens-for-woocommerce'); ?></h1>

        <form method="post" action="">
            <?php wp_nonce_field('treceafw_settings_nonce'); ?>

            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="treceafw_icon_theme"><?php echo esc_html__('Icon Theme', 'allergens-for-woocommerce'); ?></label>
                    </th>
                    <td>
                        <select name="treceafw_icon_theme" id="treceafw_icon_theme" class="treceafw-theme-selector">
                            <?php foreach ($available_themes as $theme_key => $theme_name): ?>
                                <option value="<?php echo esc_attr($theme_key); ?>" <?php selected($current_theme, $theme_key); ?>>
                                    <?php echo esc_html($theme_name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <p class="description"><?php echo esc_html__('Select the icon style for allergens display.', 'allergens-for-woocommerce'); ?></p>
                    </td>
                </tr>
            </table>

            <div class="treceafw-preview-section">
                <h2><?php echo esc_html__('Icon Preview', 'allergens-for-woocommerce'); ?></h2>
                <div class="treceafw-icons-preview" id="treceafw-icons-preview">
                    <?php treceafw_render_icons_preview($current_theme); ?>
                </div>
            </div>

            <p class="submit">
                <input type="submit" name="treceafw_save_settings" class="button button-primary" value="<?php echo esc_attr__('Save Settings', 'allergens-for-woocommerce'); ?>">
            </p>
        </form>
    </div>

    <script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#treceafw_icon_theme').on('change', function() {
            var selectedTheme = $(this).val();
            var previewContainer = $('#treceafw-icons-preview');

            // Show loading state
            previewContainer.html('<p><?php echo esc_js(__('Loading preview...', 'allergens-for-woocommerce')); ?></p>');

            // Load preview via AJAX
            $.post(ajaxurl, {
                action: 'treceafw_preview_icons',
                theme: selectedTheme,
                nonce: '<?php echo wp_create_nonce('treceafw_preview_nonce'); ?>'
            }, function(response) {
                if (response.success) {
                    previewContainer.html(response.data);
                }
            });
        });
    });
    </script>
    <?php
}

// Get available themes
function treceafw_get_available_themes() {
    return array(
        'classic' => __('Classic', 'allergens-for-woocommerce'),
        'trece' => __('Trece', 'allergens-for-woocommerce'),
    );
}

// Render icons preview
function treceafw_render_icons_preview($theme) {
    global $allergens_checkbox;
    $base_path = plugin_dir_path(__FILE__) . 'images/' . $theme . '/';
    $base_url = plugins_url('images/' . $theme . '/', __FILE__);

    echo '<div class="treceafw-preview-grid">';
    foreach ($allergens_checkbox as $key => $label) {
        $icon_files = array(
            'gluten' => 'gluten.png',
            'eggs' => 'egg.png',
            'milk' => 'milk.png',
            'fish' => 'fish.png',
            'shellfish' => 'shellfish.png',
            'crustaceans' => 'crustacean.png',
            'peanut' => 'peanuts.png',
            'soy' => 'soy.png',
            'nuts' => 'nuts.png',
            'sesame' => 'sesame.png',
            'celery' => 'celery.png',
            'mustard' => 'mustard.png',
            'lupins' => 'lupins.png',
            'sulfites' => 'sulfites.png',
            'pistachio' => 'pistachio.png',
        );

        $icon_file = isset($icon_files[$key]) ? $icon_files[$key] : $key . '.png';
        $icon_path = $base_path . $icon_file;

        if (file_exists($icon_path)) {
            echo '<div class="treceafw-preview-item">';
            echo '<img src="' . esc_url($base_url . $icon_file) . '" alt="' . esc_attr($label) . '" width="48" height="48" />';
            echo '<span>' . esc_html($label) . '</span>';
            echo '</div>';
        }
    }
    echo '</div>';
}

// AJAX handler for icon preview
add_action('wp_ajax_treceafw_preview_icons', 'treceafw_ajax_preview_icons');
function treceafw_ajax_preview_icons() {
    check_ajax_referer('treceafw_preview_nonce', 'nonce');

    $theme = sanitize_text_field($_POST['theme']);

    ob_start();
    treceafw_render_icons_preview($theme);
    $html = ob_get_clean();

    wp_send_json_success($html);
}

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
            echo '<div class="colu-6">'. PHP_EOL;
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
    global $product, $allergens_checkbox;
    $allergens_icons = treceafw_get_allergen_icons();

    if ( !$product->is_type( 'variable' ) ) {

        echo '<div class="allergen_title">'.esc_html__('Allergens', 'allergens-for-woocommerce').'</div>'. PHP_EOL;
        echo '<div class="allergens_container" role="region" aria-labelledby="allergens-heading">'. PHP_EOL;
        echo '<h2 id="allergens-heading" class="screen-reader-text">'.esc_html__('Product allergen information', 'allergens-for-woocommerce').'</h2>'. PHP_EOL;
        echo '<div class="allergens_row">'. PHP_EOL;
        foreach( $allergens_checkbox as $field => $field_name ) {
            $field_value = get_post_meta( $product->get_id(), $field, true );

            if ( $field_value ) {
                echo '<div class="colu-3">'. PHP_EOL;
                echo '<img src="'.esc_url($allergens_icons[$field]).'" alt="" aria-hidden="true" width="50" height="50" /><br />'. PHP_EOL;
                echo '<span class="allergen_text">'.esc_html__($field_name).'</span>'. PHP_EOL;
                echo '</div>'. PHP_EOL;
            }
        }
        echo '</div>';
        echo '</div>';
    }
}
add_action('woocommerce_before_add_to_cart_form', 'treceafw_show_allergens');

// Function to show allergens for custom themes/plugins
// Returns HTML instead of echoing it
function treceafw_show_allergens_out($product = null) {
    global $allergens_checkbox;
    $allergens_icons = treceafw_get_allergen_icons();
    
    // If no product provided, try to get global product
    if (!$product) {
        global $product;
    }
    
    // Return empty if no product
    if (!$product) {
        return '';
    }
    
    // Don't show for variable products (use variations instead)
    if ($product->is_type('variable')) {
        return '';
    }
    
    $output = '';
    $has_allergens = false;
    
    // Check if product has any allergens
    foreach ($allergens_checkbox as $field => $field_name) {
        $field_value = get_post_meta($product->get_id(), $field, true);
        if ($field_value) {
            $has_allergens = true;
            break;
        }
    }
    
    // Only build output if there are allergens
    if ($has_allergens) {
        $output .= '<div class="allergen_title">'.esc_html__('Allergens', 'allergens-for-woocommerce').'</div>'. PHP_EOL;
        $output .= '<div class="allergens_container" role="region" aria-labelledby="allergens-heading">'. PHP_EOL;
        $output .= '<h2 id="allergens-heading" class="screen-reader-text">'.esc_html__('Product allergen information', 'allergens-for-woocommerce').'</h2>'. PHP_EOL;
        $output .= '<div class="allergens_row">'. PHP_EOL;
        
        foreach ($allergens_checkbox as $field => $field_name) {
            $field_value = get_post_meta($product->get_id(), $field, true);
            
            if ($field_value) {
                $output .= '<div class="colu-3">'. PHP_EOL;
                $output .= '<img src="'.esc_url($allergens_icons[$field]).'" alt="" aria-hidden="true" width="50" height="50" /><br />'. PHP_EOL;
                $output .= '<span class="allergen_text">'.esc_html($field_name).'</span>'. PHP_EOL;
                $output .= '</div>'. PHP_EOL;
            }
        }
        
        $output .= '</div>';
        $output .= '</div>';
    }
    
    return $output;
}

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

        foreach( $allergens_checkbox as $field => $field_name ) {
            $variation['_afwv_'.$field] = get_post_meta($variation['variation_id'], '_afwv_'.$field, true);
            if ( $variation['_afwv_'.$field] == true) {
                $variation['_afwv_'.$field] = '<div class="colu-3"><img src="'.esc_url($allergens_icons[$field]).'" alt="" aria-hidden="true" width="48" height="48" /><br /><span class="allergen_text">'.esc_html__($field_name).'</span></div>';
            }
        }
        return $variation;
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

// WPML Compatibility
add_action('init', 'treceafw_wpml_compatibility', 20);
function treceafw_wpml_compatibility() {
    if (function_exists('icl_register_string')) {
        // Auto-configure WPML custom fields settings
        add_action('admin_init', 'treceafw_configure_wpml_custom_fields');
        
        // Hook into product save to copy allergens to all translations
        add_action('woocommerce_update_product', 'treceafw_sync_allergens_to_translations', 20, 1);
        
        // Copy allergens when duplicating for translation
        add_action('icl_make_duplicate', 'treceafw_copy_allergens_on_duplicate', 10, 4);
        
        // Copy variation allergens when variation is saved
        add_action('woocommerce_save_product_variation', 'treceafw_sync_variation_allergens_to_translations', 20, 2);
    }
}

// Auto-configure WPML custom fields settings
function treceafw_configure_wpml_custom_fields() {
    if (!function_exists('icl_register_string')) {
        return;
    }
    
    global $allergens_checkbox;
    
    // Get WPML custom fields settings
    $settings = get_option('_wpml_custom_fields_translation', array());
    
    $needs_update = false;
    
    // Configure main product allergen fields to copy
    foreach ($allergens_checkbox as $field => $field_name) {
        if (!isset($settings[$field]) || $settings[$field] != 1) {
            $settings[$field] = 1; // 1 = Copy
            $needs_update = true;
        }
        
        // Configure variation allergen fields to copy
        $variation_key = '_afwv_' . $field;
        if (!isset($settings[$variation_key]) || $settings[$variation_key] != 1) {
            $settings[$variation_key] = 1; // 1 = Copy
            $needs_update = true;
        }
    }
    
    // Update settings if needed
    if ($needs_update) {
        update_option('_wpml_custom_fields_translation', $settings);
    }
}

// Sync allergens to all translations when product is saved
function treceafw_sync_allergens_to_translations($product_id) {
    if (!function_exists('icl_object_id')) {
        return;
    }
    
    global $sitepress, $allergens_checkbox;
    
    if (!$sitepress) {
        return;
    }
    
    // Get all translations of this product
    $trid = $sitepress->get_element_trid($product_id, 'post_product');
    if (!$trid) {
        return;
    }
    
    $translations = $sitepress->get_element_translations($trid, 'post_product');
    
    if (empty($translations)) {
        return;
    }
    
    // Get current language and check if this is the original
    $current_lang = $sitepress->get_current_language();
    $default_lang = $sitepress->get_default_language();
    
    // Determine the source product (use current if it's being saved)
    $source_product_id = $product_id;
    
    // Copy allergens to each translation
    foreach ($translations as $lang_code => $translation) {
        $translated_id = $translation->element_id;
        
        // Skip if it's the same product
        if ($translated_id == $source_product_id) {
            continue;
        }
        
        // Copy all allergen fields
        foreach ($allergens_checkbox as $field => $field_name) {
            $value = get_post_meta($source_product_id, $field, true);
            
            if ($value) {
                update_post_meta($translated_id, $field, $value);
            } else {
                delete_post_meta($translated_id, $field);
            }
        }
    }
    
    // If it's a variable product, sync variations too
    $product = wc_get_product($product_id);
    if ($product && $product->is_type('variable')) {
        treceafw_sync_all_variation_allergens($product_id, $translations);
    }
}

// Sync variation allergens to all translations
function treceafw_sync_variation_allergens_to_translations($variation_id, $loop) {
    if (!function_exists('icl_object_id')) {
        return;
    }
    
    global $sitepress;
    
    if (!$sitepress) {
        return;
    }
    
    // Get the parent product ID
    $variation = wc_get_product($variation_id);
    if (!$variation) {
        return;
    }
    
    $parent_id = $variation->get_parent_id();
    if (!$parent_id) {
        return;
    }
    
    // Get all translations of the parent product
    $trid = $sitepress->get_element_trid($parent_id, 'post_product');
    if (!$trid) {
        return;
    }
    
    $translations = $sitepress->get_element_translations($trid, 'post_product');
    
    if (empty($translations)) {
        return;
    }
    
    // Sync this specific variation to all translated products
    treceafw_sync_single_variation_allergens($parent_id, $variation_id, $translations);
}

// Helper function to sync all variations
function treceafw_sync_all_variation_allergens($parent_id, $translations) {
    $parent_product = wc_get_product($parent_id);
    
    if (!$parent_product || !$parent_product->is_type('variable')) {
        return;
    }
    
    $variations = $parent_product->get_children();
    
    foreach ($variations as $variation_id) {
        treceafw_sync_single_variation_allergens($parent_id, $variation_id, $translations);
    }
}

// Helper function to sync a single variation to all translations
function treceafw_sync_single_variation_allergens($parent_id, $variation_id, $translations) {
    global $allergens_checkbox, $sitepress;
    
    if (!$sitepress) {
        return;
    }
    
    // Get variation attributes to match with translated variations
    $variation = wc_get_product($variation_id);
    if (!$variation) {
        return;
    }
    
    $variation_attributes = $variation->get_variation_attributes();
    
    // For each translation
    foreach ($translations as $lang_code => $translation) {
        $translated_parent_id = $translation->element_id;
        
        // Skip if it's the same product
        if ($translated_parent_id == $parent_id) {
            continue;
        }
        
        // Get the translated product
        $translated_product = wc_get_product($translated_parent_id);
        
        if (!$translated_product || !$translated_product->is_type('variable')) {
            continue;
        }
        
        // Find the matching variation in the translated product
        $translated_variations = $translated_product->get_children();
        
        foreach ($translated_variations as $translated_variation_id) {
            $translated_variation = wc_get_product($translated_variation_id);
            
            if (!$translated_variation) {
                continue;
            }
            
            $translated_attributes = $translated_variation->get_variation_attributes();
            
            // Check if attributes match (same position/structure)
            if (count($variation_attributes) === count($translated_attributes)) {
                // Copy allergen data
                foreach ($allergens_checkbox as $field => $field_name) {
                    $meta_key = '_afwv_' . $field;
                    $value = get_post_meta($variation_id, $meta_key, true);
                    
                    if ($value) {
                        update_post_meta($translated_variation_id, $meta_key, $value);
                    } else {
                        delete_post_meta($translated_variation_id, $meta_key);
                    }
                }
                break; // Found the matching variation, move to next translation
            }
        }
    }
}

// Copy allergens data when duplicating products
function treceafw_copy_allergens_on_duplicate($master_post_id, $lang, $post_array, $id) {
    global $allergens_checkbox;
    
    // Copy main product allergens
    foreach ($allergens_checkbox as $field => $field_name) {
        $value = get_post_meta($master_post_id, $field, true);
        if ($value) {
            update_post_meta($id, $field, $value);
        }
    }
    
    // Copy variation allergens if it's a variable product
    $product = wc_get_product($master_post_id);
    if ($product && $product->is_type('variable')) {
        $variations = $product->get_children();
        $new_product = wc_get_product($id);
        
        if ($new_product && $new_product->is_type('variable')) {
            $new_variations = $new_product->get_children();
            
            // Match and copy variations
            if (count($variations) === count($new_variations)) {
                for ($i = 0; $i < count($variations); $i++) {
                    foreach ($allergens_checkbox as $field => $field_name) {
                        $meta_key = '_afwv_' . $field;
                        $value = get_post_meta($variations[$i], $meta_key, true);
                        
                        if ($value) {
                            update_post_meta($new_variations[$i], $meta_key, $value);
                        }
                    }
                }
            }
        }
    }
}
/**
 * Allergens for WooCommerce - Variations Handler
 * Handles dynamic allergen display when variations change
 * Compatible with page builders (Oxygen, Elementor, Bricks, etc.)
 */

(function($) {
    'use strict';

    // Main function to update allergens display
    function updateAllergensDisplay(variation) {
        if (!variation || !treceafwData) {
            return;
        }

        var allergensHtml = '';
        var hasAllergens = false;
        var allergensItems = '';

        // Build allergens HTML from variation data
        $.each(treceafwData.allergens, function(key, allergen) {
            var fieldKey = '_afwv_' + key;
            
            if (variation[fieldKey] === true) {
                hasAllergens = true;
                allergensItems += '<div class="colu-3">';
                allergensItems += '<img src="' + allergen.icon + '" alt="" aria-hidden="true" width="48" height="48" /><br />';
                allergensItems += '<span class="allergen_text">' + allergen.label + '</span>';
                allergensItems += '</div>';
            }
        });

        if (hasAllergens) {
            allergensHtml = '<div class="woocommerce-variation-afwv allergens_wrapper">';
            allergensHtml += '<div class="allergens_container" role="region" aria-label="' + treceafwData.ariaLabel + '">';
            allergensHtml += '<div class="allergen_title">' + treceafwData.title + '</div>';
            allergensHtml += '<div class="allergens_row">';
            allergensHtml += allergensItems;
            allergensHtml += '</div></div></div>';
        }

        updateAllergensContainer(allergensHtml);
    }

    // Update allergens container in the DOM
    function updateAllergensContainer(html) {
        var $container = $('.woocommerce-variation-afwv');
        
        if ($container.length) {
            // Update or remove existing container
            html ? $container.replaceWith(html) : $container.remove();
        } else if (html) {
            // Find best insertion point
            var $insertAfter = $('.woocommerce-variation-availability').length ? 
                              $('.woocommerce-variation-availability') :
                              $('.woocommerce-variation-price').length ?
                              $('.woocommerce-variation-price') :
                              $('.woocommerce-variation-description');
            
            if ($insertAfter.length) {
                $insertAfter.after(html);
            } else {
                // Fallback: before add to cart button
                $('.single_variation_wrap .woocommerce-variation-add-to-cart').before(html);
            }
        }
    }

    // Initialize on document ready
    $(document).ready(function() {
        var $form = $('.variations_form');
        
        // When a variation is selected
        $form.on('found_variation', function(event, variation) {
            updateAllergensDisplay(variation);
        });

        // When variation selection is cleared
        $form.on('reset_data', function() {
            $('.woocommerce-variation-afwv').remove();
        });
    });

})(jQuery);

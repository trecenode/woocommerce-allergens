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

        // Build allergens HTML from variation data
        if (treceafwData.allergens) {
            var allergensItems = '';
            
            $.each(treceafwData.allergens, function(key, allergen) {
                var fieldKey = '_afwv_' + key;
                
                if (variation[fieldKey]) {
                    hasAllergens = true;
                    // If it's already HTML (from template), use it
                    if (typeof variation[fieldKey] === 'string' && variation[fieldKey].indexOf('<div') === 0) {
                        allergensItems += variation[fieldKey];
                    } else if (variation[fieldKey] === true || variation[fieldKey] === 'yes') {
                        // Build HTML from scratch
                        allergensItems += '<div class="colu-3">';
                        allergensItems += '<img src="' + allergen.icon + '" alt="" aria-hidden="true" width="48" height="48" /><br />';
                        allergensItems += '<span class="allergen_text">' + allergen.label + '</span>';
                        allergensItems += '</div>';
                    }
                }
            });

            if (hasAllergens) {
                allergensHtml = '<div class="woocommerce-variation-afwv allergens_wrapper">';
                allergensHtml += '<div class="allergens_container" role="region" aria-label="' + treceafwData.ariaLabel + '">';
                allergensHtml += '<div class="allergen_title">' + treceafwData.title + '</div>';
                allergensHtml += '<ul class="allergens_row" role="list">';
                allergensHtml += allergensItems;
                allergensHtml += '</ul>';
                allergensHtml += '</div>';
                allergensHtml += '</div>';
            }
        }

        // Update or create allergens container
        updateAllergensContainer(allergensHtml);
    }

    // Update allergens container in the DOM
    function updateAllergensContainer(html) {
        var $container = $('.woocommerce-variation-afwv');
        
        if ($container.length) {
            // Container exists, update it
            if (html) {
                $container.replaceWith(html);
            } else {
                $container.remove();
            }
        } else if (html) {
            // Container doesn't exist, create it in the best available position
            // Priority order matches the standard template position
            var insertionPoint = null;
            
            // 1. After variation availability (matches template position)
            var $varAvail = $('.woocommerce-variation-availability');
            if ($varAvail.length) {
                insertionPoint = $varAvail;
            }
            // 2. After variation price (if availability not found)
            else {
                var $varPrice = $('.woocommerce-variation-price');
                if ($varPrice.length) {
                    insertionPoint = $varPrice;
                }
            }
            // 3. After variation description (if price not found)
            if (!insertionPoint) {
                var $varDesc = $('.woocommerce-variation-description');
                if ($varDesc.length) {
                    insertionPoint = $varDesc;
                }
            }
            // 4. Before add to cart button (fallback)
            if (!insertionPoint) {
                var $addToCart = $('.single_variation_wrap .woocommerce-variation-add-to-cart');
                if ($addToCart.length) {
                    $addToCart.before(html);
                    return;
                }
            }
            
            // Insert after the best insertion point found
            if (insertionPoint) {
                insertionPoint.after(html);
            }
        }
    }

    // Clear allergens display
    function clearAllergensDisplay() {
        $('.woocommerce-variation-afwv').remove();
    }

    // Initialize on document ready
    $(document).ready(function() {
        // WooCommerce standard event: when a variation is found/selected
        $('.variations_form').on('found_variation', function(event, variation) {
            updateAllergensDisplay(variation);
        });

        // WooCommerce event: when variation is reset/cleared
        $('.variations_form').on('reset_data', function() {
            clearAllergensDisplay();
        });

        // Additional compatibility: listen to show_variation event
        $('.variations_form').on('show_variation', function(event, variation) {
            updateAllergensDisplay(variation);
        });

        // Additional compatibility: listen to hide_variation event
        $('.variations_form').on('hide_variation', function() {
            clearAllergensDisplay();
        });

        // Page builder compatibility: trigger on attribute change
        $('.variations_form').on('woocommerce_variation_select_change', function() {
            // Will be handled by found_variation event
        });

        // Oxygen Builder specific: sometimes needs a delay
        if (typeof CTFrontendBuilder !== 'undefined') {
            setTimeout(function() {
                $('.variations_form').trigger('check_variations');
            }, 100);
        }
    });

})(jQuery);

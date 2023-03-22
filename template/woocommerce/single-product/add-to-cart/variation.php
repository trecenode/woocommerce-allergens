<?php
/**
 * Single variation display
 *
 * This is a javascript-based template for single variations (see https://codex.wordpress.org/Javascript_Reference/wp.template).
 * The values will be dynamically replaced after selecting attributes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.5.0
 */

defined( 'ABSPATH' ) || exit;

?>
<script type="text/template" id="tmpl-variation-template">
	<div class="woocommerce-variation-description">{{{ data.variation.variation_description }}}</div>
	<div class="woocommerce-variation-price">{{{ data.variation.price_html }}}</div>
	<div class="woocommerce-variation-availability">{{{ data.variation.availability_html }}}</div>
    <div class="woocommerce-variation-afwv allergens_wrapper">{{{ data.variation._afwv_gluten }}} {{{ data.variation._afwv_eggs }}} {{{ data.variation._afwv_milk }}} {{{ data.variation._afwv_fish }}} {{{ data.variation._afwv_shellfish }}} {{{ data.variation._afwv_crustaceans }}} {{{ data.variation._afwv_peanut }}} {{{ data.variation._afwv_soy }}} {{{ data.variation._afwv_nuts }}} {{{ data.variation._afwv_sesame }}} {{{ data.variation._afwv_celery }}} {{{ data.variation._afwv_mustard }}} {{{ data.variation._afwv_lupins }}} {{{ data.variation._afwv_sulfites }}}</div>
</script>
<script type="text/template" id="tmpl-unavailable-variation-template">
	<p><?php esc_html_e( 'Sorry, this product is unavailable. Please choose a different combination.', 'woocommerce' ); ?></p>
</script>

<?php
/**
 * WooCommerce Loop Product Override - Castejon Store
 */

defined('ABSPATH') || exit;

global $product;

if (empty($product) || !$product->is_visible()) {
    return;
}

get_template_part('template-parts/components/product-card', null, array(
    'product_id' => $product->get_id(),
));

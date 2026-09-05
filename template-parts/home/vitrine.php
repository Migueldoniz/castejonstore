<?php
/**
 * Vitrine de Produtos - Estilo The Greg's Exclusive
 */

if (!defined('ABSPATH') || !class_exists('WooCommerce')) {
    return;
}

$title    = !empty($args['title']) ? $args['title'] : 'Destaques';
$category = !empty($args['category']) ? $args['category'] : '';
$limit    = !empty($args['limit']) ? intval($args['limit']) : 8;
$link     = !empty($args['link']) ? $args['link'] : home_url('/loja/');
$is_alt   = !empty($args['is_alt']) ? 'is-alt' : '';
$orderby  = !empty($args['orderby']) ? $args['orderby'] : 'date';

$query_args = array(
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => $limit,
    'orderby'        => $orderby,
    'order'          => 'DESC',
    'fields'         => 'ids',
    'no_found_rows'  => true,
);

if (!empty($category)) {
    $query_args['tax_query'] = array(
        array(
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => $category,
        ),
    );
}

// Evita duplicidade de produtos na home page
global $cj_displayed_product_ids;
if (!isset($cj_displayed_product_ids)) {
    $cj_displayed_product_ids = array();
}

if (!empty($cj_displayed_product_ids)) {
    $query_args['post__not_in'] = $cj_displayed_product_ids;
}

// Chave única de transient para cache
$transient_key = 'cj_vitrine_' . substr(md5(serialize($query_args)), 0, 16);
$product_ids   = get_transient($transient_key);

if ($product_ids === false) {
    $products_query = new WP_Query($query_args);
    $product_ids    = $products_query->posts;
    set_transient($transient_key, $product_ids, HOUR_IN_SECONDS);
}

// Registra os produtos exibidos para não repetir nas próximas seções
if (!empty($product_ids)) {
    $cj_displayed_product_ids = array_unique(array_merge($cj_displayed_product_ids, $product_ids));
}

if (empty($product_ids)) {
    return;
}
?>
<section class="cj-showcase-section <?php echo esc_attr($is_alt); ?>">
    <div class="cj-container">
        <div class="cj-showcase-header">
            <h2 class="cj-showcase-title"><?php echo esc_html($title); ?></h2>
            <a href="<?php echo esc_url($link); ?>" class="cj-showcase-link">
                <span>Ver todos</span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </a>
        </div>

        <div class="cj-products-grid">
            <?php
            foreach ($product_ids as $p_id) {
                get_template_part('template-parts/components/product-card', null, array(
                    'product_id' => $p_id,
                ));
            }
            ?>
        </div>
    </div>
</section>

<?php
/**
 * Customizações e Hooks do WooCommerce para o Castejon Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

// Declara suporte completo ao WooCommerce
function castejon_add_woocommerce_support() {
    add_theme_support('woocommerce', array(
        'thumbnail_image_width' => 450,
        'single_image_width'    => 800,
        'product_grid'          => array(
            'default_rows'    => 4,
            'min_rows'        => 2,
            'max_rows'        => 8,
            'default_columns' => 4,
            'min_columns'     => 2,
            'max_columns'     => 4,
        ),
    ));
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'castejon_add_woocommerce_support');

// Remove estilos padrões do WooCommerce para garantir nossa identidade visual limpa e rápida
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

// Atualização dinâmica do contador do carrinho e do Side-Cart Drawer via AJAX
function castejon_woocommerce_header_add_to_cart_fragment($fragments) {
    ob_start();
    ?>
    <span class="cj-cart-badge cj-cart-count"><?php echo esc_html(WC()->cart->get_cart_contents_count()); ?></span>
    <?php
    $fragments['span.cj-cart-count'] = ob_get_clean();

    ob_start();
    get_template_part('template-parts/components/cart-drawer-inner');
    $fragments['div.cj-cart-drawer-inner'] = ob_get_clean();

    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'castejon_woocommerce_header_add_to_cart_fragment');

// AJAX: Atualizar quantidade no Drawer
add_action('wp_ajax_castejon_update_cart_drawer_qty', 'castejon_update_cart_drawer_qty');
add_action('wp_ajax_nopriv_castejon_update_cart_drawer_qty', 'castejon_update_cart_drawer_qty');
function castejon_update_cart_drawer_qty() {
    check_ajax_referer('castejon_ajax_nonce', 'nonce');
    $cart_item_key = isset($_POST['cart_item_key']) ? sanitize_text_field($_POST['cart_item_key']) : '';
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

    if ($cart_item_key && WC()->cart->get_cart_item($cart_item_key)) {
        if ($quantity > 0) {
            WC()->cart->set_quantity($cart_item_key, $quantity, true);
        } else {
            WC()->cart->remove_cart_item($cart_item_key);
        }
        WC_AJAX::get_refreshed_fragments();
    }
    wp_die();
}

// AJAX: Remover item no Drawer
add_action('wp_ajax_castejon_remove_cart_drawer_item', 'castejon_remove_cart_drawer_item');
add_action('wp_ajax_nopriv_castejon_remove_cart_drawer_item', 'castejon_remove_cart_drawer_item');
function castejon_remove_cart_drawer_item() {
    check_ajax_referer('castejon_ajax_nonce', 'nonce');
    $cart_item_key = isset($_POST['cart_item_key']) ? sanitize_text_field($_POST['cart_item_key']) : '';

    if ($cart_item_key && WC()->cart->get_cart_item($cart_item_key)) {
        WC()->cart->remove_cart_item($cart_item_key);
        WC_AJAX::get_refreshed_fragments();
    }
    wp_die();
}


// AJAX: Sugestões de busca (autocomplete de produtos)
add_action('wp_ajax_castejon_search_suggest', 'castejon_search_suggest');
add_action('wp_ajax_nopriv_castejon_search_suggest', 'castejon_search_suggest');
function castejon_search_suggest() {
    check_ajax_referer('castejon_ajax_nonce', 'nonce');
    $term = isset($_POST['term']) ? sanitize_text_field($_POST['term']) : '';
    if (strlen($term) < 2) {
        wp_send_json(array());
    }

    $query = new WP_Query(array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        's'              => $term,
        'posts_per_page' => 8,
        'no_found_rows'  => true,
    ));

    $items = array();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $product = wc_get_product(get_the_ID());
            if (!$product) {
                continue;
            }
            $img_id = $product->get_image_id();
            $items[] = array(
                'title' => $product->get_name(),
                'url'   => $product->get_permalink(),
                'img'   => $img_id ? wp_get_attachment_image_url($img_id, 'woocommerce_thumbnail') : wc_placeholder_img_src(),
                'price' => wp_strip_all_tags($product->get_price_html()),
            );
        }
        wp_reset_postdata();
    }

    wp_send_json($items);
}

// AJAX: Quickshop (formulário de compra em modal)
add_action('wp_ajax_castejon_quickshop', 'castejon_quickshop_form');
add_action('wp_ajax_nopriv_castejon_quickshop', 'castejon_quickshop_form');
function castejon_quickshop_form() {
    check_ajax_referer('castejon_ajax_nonce', 'nonce');
    $id      = isset($_POST['product_id']) ? absint($_POST['product_id']) : 0;
    $product = $id ? wc_get_product($id) : false;

    if (!$product || !$product->is_visible()) {
        wp_send_json_error(array('message' => 'Produto não encontrado.'));
    }

    ob_start();
    echo '<div class="cj-quickshop-grid">';
    echo '<div class="cj-quickshop-media">' . $product->get_image('woocommerce_single') . '</div>';
    echo '<div class="cj-quickshop-info">';
    echo '<h3 class="cj-quickshop-title">' . esc_html($product->get_name()) . '</h3>';
    echo '<div class="cj-quickshop-price">' . wp_kses_post($product->get_price_html()) . '</div>';

    if ($product->is_in_stock()) {
        $GLOBALS['product'] = $product;
        if ($product->is_type('variable')) {
            woocommerce_variable_add_to_cart();
        } elseif ($product->is_type('simple')) {
            woocommerce_simple_add_to_cart();
        } else {
            echo '<a class="cj-btn-gold" href="' . esc_url($product->get_permalink()) . '">Ver produto</a>';
        }
    } else {
        echo '<span class="cj-buy-btn cj-btn-soldout">ESGOTADO</span>';
    }
    echo '</div></div>';

    wp_send_json_success(array('html' => ob_get_clean()));
}

// Desabilitar breadcrumbs padrões na página de arquivo para usarmos nossos próprios elementos
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

// Helper para obter parcelamento formatado
function castejon_get_installment_text($price, $max_installments = 12) {
    if (empty($price) || !is_numeric($price) || $price <= 0) {
        return '';
    }
    
    $installment_value = $price / $max_installments;
    if ($installment_value < 15) {
        $max_installments = max(1, floor($price / 15));
        if ($max_installments <= 1) {
            return '';
        }
        $installment_value = $price / $max_installments;
    }

    return sprintf('ou %dx de %s sem juros', $max_installments, wc_price($installment_value));
}

// Garante que as variações (tamanhos de decants/frascos) fiquem em ordem crescente de preço
add_filter('woocommerce_product_get_children', 'castejon_sort_variations_by_price_asc', 10, 2);
function castejon_sort_variations_by_price_asc($children, $product) {
    if (!$product || !$product->is_type('variable') || empty($children)) {
        return $children;
    }

    usort($children, function($a, $b) {
        $price_a = floatval(get_post_meta($a, '_price', true));
        $price_b = floatval(get_post_meta($b, '_price', true));
        if ($price_a == $price_b) {
            return 0;
        }
        return ($price_a < $price_b) ? -1 : 1;
    });

    return $children;
}

// Ordena os termos de atributos de tamanho por valor numérico natural (5ml -> 10ml -> 15ml...)
add_filter('woocommerce_get_product_terms', 'castejon_sort_terms_natural_volume', 20, 4);
function castejon_sort_terms_natural_volume($terms, $product_id, $taxonomy, $args) {
    if ($taxonomy === 'pa_tamanho' || stripos($taxonomy, 'tamanho') !== false || stripos($taxonomy, 'volume') !== false) {
        if (is_array($terms) && count($terms) > 1) {
            usort($terms, function($a, $b) {
                preg_match('/(\d+)/', $a->name, $match_a);
                preg_match('/(\d+)/', $b->name, $match_b);
                $num_a = isset($match_a[1]) ? intval($match_a[1]) : 9999;
                $num_b = isset($match_b[1]) ? intval($match_b[1]) : 9999;
                if ($num_a == $num_b) {
                    return strnatcasecmp($a->name, $b->name);
                }
                return ($num_a < $num_b) ? -1 : 1;
            });
        }
    }
    return $terms;
}

add_filter('get_terms', 'castejon_sort_get_terms_natural_volume', 20, 4);
function castejon_sort_get_terms_natural_volume($terms, $taxonomies, $args, $term_query) {
    if (in_array('pa_tamanho', (array) $taxonomies)) {
        if (is_array($terms) && count($terms) > 1) {
            usort($terms, function($a, $b) {
                if (!is_object($a) || !is_object($b)) return 0;
                preg_match('/(\d+)/', $a->name, $match_a);
                preg_match('/(\d+)/', $b->name, $match_b);
                $num_a = isset($match_a[1]) ? intval($match_a[1]) : 9999;
                $num_b = isset($match_b[1]) ? intval($match_b[1]) : 9999;
                if ($num_a == $num_b) {
                    return strnatcasecmp($a->name, $b->name);
                }
                return ($num_a < $num_b) ? -1 : 1;
            });
        }
    }
    return $terms;
}

// Estoque primeiro em loja/categorias (exceto busca direcionada):
// _stock_status alfabético ASC = instock > onbackorder > outofstock.
// O critério escolhido pelo usuário (preço, popularidade, data...) vira chave secundária.
add_action('woocommerce_product_query', 'castejon_stock_first_archives', 20);
function castejon_stock_first_archives($q) {
    if (is_admin() || is_search()) {
        return;
    }

    $orderby = $q->get('orderby');
    $order   = $q->get('order') ?: 'ASC';

    $meta_query = $q->get('meta_query');
    if (!is_array($meta_query)) {
        $meta_query = array();
    }
    $meta_query['stock_status_clause'] = array(
        'key'     => '_stock_status',
        'compare' => 'IN',
        'value'   => array('instock', 'onbackorder', 'outofstock'),
    );
    $q->set('meta_query', $meta_query);

    $new_orderby = array('stock_status_clause' => 'ASC');
    if (!empty($orderby)) {
        $new_orderby[$orderby] = $order;
    } else {
        $new_orderby['menu_order'] = $order;
    }
    $q->set('orderby', $new_orderby);
}



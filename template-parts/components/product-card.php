<?php
/**
 * Card de Produto - Estilo The Greg's Exclusive com Otimizações Comportamentais
 */
if (!defined('ABSPATH')) {
    exit;
}

$product_id = !empty($args['product_id']) ? $args['product_id'] : get_the_ID();
$product = wc_get_product($product_id);

if (!$product || !$product->is_visible()) {
    return;
}

$permalink  = $product->get_permalink();
$title      = $product->get_name();
$is_on_sale = $product->is_on_sale();
$price_html = $product->get_price_html();
$is_decant  = has_term('decants-2', 'product_cat', $product_id) || has_term('decants', 'product_cat', $product_id);

// Imagens para hover (imagem principal + primeira imagem da galeria)
$main_img_id = $product->get_image_id();
$gallery_ids = $product->get_gallery_image_ids();
$secondary_img_id = !empty($gallery_ids) ? $gallery_ids[0] : false;

// Preço e Desconto PIX (5% off)
$price = $product->get_price();
$pix_price = $price ? ($price * 0.95) : false;

// Avaliações
$rating_count = $product->get_rating_count();
$average      = $product->get_average_rating();

// Dados para tracking gtm4wp (view_item_list / select_item)
$cj_cat_terms = wp_get_post_terms($product_id, 'product_cat', array('fields' => 'names'));
$cj_gtm4wp_data = array(
    'internal_id'              => $product_id,
    'item_id'                  => $product->get_sku() ? $product->get_sku() : $product_id,
    'item_name'                => $title,
    'sku'                      => $product->get_sku() ? $product->get_sku() : $product_id,
    'price'                    => round((float) wc_get_price_to_display($product), 2),
    'stocklevel'               => $product->get_stock_quantity(),
    'stockstatus'              => $product->get_stock_status(),
    'google_business_vertical' => 'retail',
    'item_category'            => !empty($cj_cat_terms) ? $cj_cat_terms[0] : '',
    'product_type'             => $product->get_type(),
    'productlink'              => $permalink,
);
?>
<div class="cj-product-card product <?php echo $secondary_img_id ? 'has-secondary-img' : ''; ?>">
    <span class="gtm4wp_productdata" style="display:none; visibility:hidden;" data-gtm4wp_product_data="<?php echo esc_attr(wp_json_encode($cj_gtm4wp_data)); ?>"></span>
    <div class="cj-card-thumb">
        <div class="cj-card-badges-wrapper">
            <?php if ($is_decant) : ?>
                <span class="cj-card-badge cj-badge-decant">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
                    Decant Original
                </span>
            <?php else : ?>
                <span class="cj-card-badge cj-badge-original">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    100% Autêntico
                </span>
            <?php endif; ?>

            <?php if ($is_on_sale) : ?>
                <span class="cj-card-badge cj-badge-sale">Oferta</span>
            <?php endif; ?>
        </div>

        <a href="<?php echo esc_url($permalink); ?>" class="cj-card-img-link" tabindex="-1">
            <?php
            if ($main_img_id) {
                echo wp_get_attachment_image($main_img_id, 'woocommerce_thumbnail', false, array('class' => 'cj-card-img cj-card-img-primary', 'alt' => esc_attr($title)));
            } else {
                echo wc_placeholder_img('woocommerce_thumbnail', array('class' => 'cj-card-img cj-card-img-primary'));
            }

            // Segunda imagem para hover
            if ($secondary_img_id) {
                echo wp_get_attachment_image($secondary_img_id, 'woocommerce_thumbnail', false, array('class' => 'cj-card-img cj-card-img-hover', 'alt' => esc_attr($title), 'loading' => 'lazy'));
            }
            ?>
        </a>
    </div>

    <div class="cj-card-info">
        <div class="cj-card-top-meta">
            <?php
            $terms = get_the_terms($product_id, 'product_cat');
            if (!empty($terms) && !is_wp_error($terms)) {
                echo '<span class="cj-card-cat">' . esc_html($terms[0]->name) . '</span>';
            }
            ?>

            <div class="cj-card-rating">
                <?php if ($rating_count > 0) : ?>
                    <?php echo wc_get_rating_html($average, $rating_count); ?>
                <?php else :
                    $cj_card_reviews = get_option('trustindex-google-page-details');
                    $cj_card_reviews_url = (is_array($cj_card_reviews) && !empty($cj_card_reviews['review_url'])) ? $cj_card_reviews['review_url'] : '';
                    if ($cj_card_reviews_url) : ?>
                        <a href="<?php echo esc_url($cj_card_reviews_url); ?>" class="cj-rating-google" target="_blank" rel="noopener" title="Avaliações verificadas no Google">
                            <span class="cj-rating-google-stars" aria-hidden="true">★★★★★</span> no Google
                        </a>
                    <?php else : ?>
                        <span class="cj-rating-none">Autenticidade garantida</span>
                    <?php endif;
                endif; ?>
            </div>
        </div>

        <h3 class="cj-card-name">
            <a href="<?php echo esc_url($permalink); ?>">
                <?php echo esc_html($title); ?>
            </a>
        </h3>

        <div class="cj-card-pricing">
            <div class="cj-card-price">
                <?php echo $price_html; ?>
            </div>

            <?php if ($pix_price) : ?>
                <div class="cj-card-pix-container">
                    <span class="cj-pix-tag">PIX</span>
                    <strong class="cj-pix-val"><?php echo wc_price($pix_price); ?></strong>
                    <span class="cj-pix-discount">(5% OFF)</span>
                </div>
            <?php endif; ?>

            <?php
            if ($price && function_exists('castejon_get_installment_text')) {
                $installment = castejon_get_installment_text($price);
                if (!empty($installment)) {
                    echo '<div class="cj-card-installments">' . wp_kses_post($installment) . '</div>';
                }
            }
            ?>
        </div>

            <?php
            if ($product->is_in_stock()) :
                $is_variable = $product->is_type('variable');
                $btn_text = $is_variable ? 'ESCOLHER TAMANHO' : 'COMPRAR';
                $btn_href = $is_variable ? $permalink : esc_url('?add-to-cart=' . $product_id);
                $btn_classes = 'cj-buy-btn' . (!$is_variable ? ' ajax_add_to_cart add_to_cart_button' : '');
            ?>
            <div class="cj-card-actions">
                <a href="<?php echo $btn_href; ?>" class="<?php echo esc_attr($btn_classes); ?>" data-product_id="<?php echo esc_attr($product_id); ?>" data-product_sku="<?php echo esc_attr($product->get_sku()); ?>" aria-label="<?php echo esc_attr($btn_text . ' - ' . $title); ?>">
                    <span><?php echo esc_html($btn_text); ?></span>
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                </a>
                <button type="button" class="cj-quickshop-btn" data-product-id="<?php echo esc_attr($product_id); ?>" aria-label="Compra rápida" title="Compra rápida">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                </button>
            </div>
            <?php else : ?>
            <span class="cj-buy-btn cj-btn-soldout" aria-disabled="true">
                <span>ESGOTADO</span>
            </span>
            <?php endif; ?>
        </div>
    </div>


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
?>
<div class="cj-product-card <?php echo $secondary_img_id ? 'has-secondary-img' : ''; ?>">
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
                <?php else : ?>
                    <span class="cj-rating-stars">★★★★★</span>
                <?php endif; ?>
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
            $btn_text = $product->is_type('variable') ? 'ESCOLHER TAMANHO' : 'COMPRAR';
            ?>
            <a href="<?php echo esc_url($permalink); ?>" class="cj-buy-btn">
                <span><?php echo esc_html($btn_text); ?></span>
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
            </a>
        </div>
    </div>


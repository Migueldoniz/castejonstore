<?php
/**
 * Single Product Content Template - Estilo The Greg's Exclusive
 */

defined('ABSPATH') || exit;

global $product;

if (empty($product)) {
    return;
}

$product_id = $product->get_id();
$is_decant = has_term('decants-2', 'product_cat', $product_id) || has_term('decants', 'product_cat', $product_id);
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class('cj-single-product-container', $product); ?>>
    <div class="cj-container">
        <!-- Breadcrumbs -->
        <nav class="cj-single-breadcrumbs" aria-label="Navegação">
            <a href="<?php echo esc_url(home_url('/')); ?>">Início</a>
            <span class="cj-sep">/</span>
            <?php
            $terms = get_the_terms($product_id, 'product_cat');
            if (!empty($terms) && !is_wp_error($terms)) {
                $main_term = $terms[0];
                echo '<a href="' . esc_url(get_term_link($main_term)) . '">' . esc_html($main_term->name) . '</a>';
                echo '<span class="cj-sep">/</span>';
            }
            ?>
            <span class="cj-current"><?php the_title(); ?></span>
        </nav>

        <!-- Grid Principal do Produto (2 Colunas) -->
        <div class="cj-product-main-grid">
            <!-- 1. Coluna da Galeria (Esquerda) -->
            <div class="cj-product-gallery-side">
                <div class="cj-gallery-wrapper">
                    <?php if ($is_decant) : ?>
                        <span class="cj-card-badge" style="position: absolute; top: 15px; left: 15px; z-index: 5;">Decant</span>
                    <?php elseif ($product->is_on_sale()) : ?>
                        <span class="cj-card-badge" style="position: absolute; top: 15px; left: 15px; z-index: 5; background-color: #8f2323;">Oferta</span>
                    <?php endif; ?>

                    <?php
                    /**
                     * Hook padrão do WooCommerce para imagens e galeria
                     * Mantém compatibilidade total com zoom, lightbox e sliders
                     */
                    do_action('woocommerce_before_single_product_summary');
                    ?>
                </div>
            </div>

            <!-- 2. Coluna de Informações e Compra (Direita) -->
            <div class="cj-product-info-side">
                <?php
                $brands = get_the_terms($product_id, 'product_brand');
                if (!empty($brands) && !is_wp_error($brands)) :
                ?>
                    <div class="cj-single-brand"><?php echo esc_html($brands[0]->name); ?></div>
                <?php elseif (!empty($terms) && !is_wp_error($terms)) : ?>
                    <div class="cj-single-category"><?php echo esc_html($terms[0]->name); ?></div>
                <?php endif; ?>

                <h1 class="cj-single-title"><?php the_title(); ?></h1>

                <!-- Bloco de Preço & Parcelamento -->
                <div class="cj-single-price-box">
                    <div class="cj-single-price">
                        <?php echo $product->get_price_html(); ?>
                    </div>
                    <?php
                    $active_price = $product->get_price();
                    if ($active_price) {
                        $pix_price = $active_price * 0.95;
                        ?>
                        <div class="cj-single-pix-box">
                            <span class="cj-pix-tag">PIX</span>
                            <span class="cj-pix-price"><?php echo wc_price($pix_price); ?></span>
                            <span class="cj-pix-off">com 5% de desconto à vista</span>
                        </div>
                        <?php
                    }
                    if ($active_price && function_exists('castejon_get_installment_text')) {
                        $installment = castejon_get_installment_text($active_price, 12);
                        if (!empty($installment)) {
                            echo '<div class="cj-single-installments">' . wp_kses_post($installment) . '</div>';
                        }
                    }
                    ?>
                </div>

                <?php
                // Nota de frete grátis no PDP (acima de R$299)
                $cj_pdp_price = $product->get_price();
                if ($cj_pdp_price) :
                    $cj_remaining = 299.00 - (float) $cj_pdp_price;
                    ?>
                    <div class="cj-pdp-freeship">
                        <?php if ($cj_remaining <= 0) : ?>
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span><strong>Frete grátis</strong> para todo o Brasil neste produto</span>
                        <?php else : ?>
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3 7 7 .6-5.2 4.7 1.5 6.9L12 17.7 5.7 21.2l1.5-6.9L2 9.6 9 9z"/></svg>
                            <span>Faltam <strong><?php echo wc_price($cj_remaining); ?></strong> para ganhar <strong>FRETE GRÁTIS</strong> para todo o Brasil</span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ($is_decant) : ?>
                    <!-- Selo e Explicação de Decant Autêntico (Estilo The Greg's) -->
                    <div class="cj-decant-info-banner">
                        <div class="cj-decant-info-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        <div class="cj-decant-info-text">
                            <strong>Decant Fracionado Original</strong>
                            <p>Fragrância retirada diretamente do frasco oficial e envasada em frasco spray hermético. Garantia total de procedência e fixação idêntica.</p>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Formulário de Compra / Seleção de Variações -->
                <?php if ($product->is_in_stock()) : ?>
                <div class="cj-single-form-wrapper">
                    <?php
                    /**
                     * Hook padrão que renderiza:
                     * - Seletores de atributos/variações (ex: 5ml, 10ml, etc.)
                     * - Seletor de quantidade e botão "Adicionar ao carrinho"
                     */
                    woocommerce_template_single_add_to_cart();
                    ?>
                </div>
                <?php else : ?>
                <div class="cj-single-form-wrapper cj-soldout-wrapper">
                    <span class="cj-buy-btn cj-btn-soldout" aria-disabled="true">ESGOTADO</span>
                    <p class="cj-soldout-note">Este produto está temporariamente esgotado. As reposições são anunciadas no Instagram e na newsletter.</p>
                </div>
                <?php endif; ?>

                <?php
                // Cross-sell decant <-> frasco (par por fragrância)
                $cj_pair_slug = '';
                $cj_pair_direction = '';
                if (strpos($product->get_slug(), 'perfume-') === 0) {
                    $cj_pair_slug = 'decant-' . substr($product->get_slug(), strlen('perfume-'));
                    $cj_pair_direction = 'to_decant';
                } elseif (strpos($product->get_slug(), 'decant-') === 0) {
                    $cj_pair_slug = 'perfume-' . substr($product->get_slug(), strlen('decant-'));
                    $cj_pair_direction = 'to_perfume';
                }
                $cj_pair_post = $cj_pair_slug ? get_page_by_path($cj_pair_slug, OBJECT, 'product') : null;
                if (!empty($cj_pair_post)) {
                    $cj_pair_product = wc_get_product($cj_pair_post->ID);
                    if ($cj_pair_product && $cj_pair_product->is_visible()) :
                ?>
                    <div class="cj-pair-box">
                        <div class="cj-pair-info">
                            <span class="cj-pair-tag"><?php echo $cj_pair_direction === 'to_decant' ? 'Teste antes de comprar' : 'Leve o frasco lacrado'; ?></span>
                            <strong class="cj-pair-name"><?php echo esc_html($cj_pair_product->get_name()); ?></strong>
                            <span class="cj-pair-price"><?php echo wp_kses_post($cj_pair_product->get_price_html()); ?></span>
                        </div>
                        <a href="<?php echo esc_url($cj_pair_product->get_permalink()); ?>" class="cj-btn-gold cj-pair-cta">
                            <?php echo $cj_pair_direction === 'to_decant' ? 'Conhecer o decant' : 'Ver frasco original'; ?>
                        </a>
                    </div>
                <?php
                    endif;
                }
                ?>

                <!-- Selos de Confiança e Garantia (Estilo The Gregs) -->
                <div class="cj-product-guarantees">
                    <div class="cj-guarantee-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        <span>100% Autêntico · Garantia total de procedência</span>
                    </div>
                    <div class="cj-guarantee-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        <span>Envio Seguro e Protegido para todo o Brasil</span>
                    </div>
                    <div class="cj-guarantee-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                        <span>Até 12x no cartão de crédito ou à vista via PIX</span>
                    </div>
                </div>

                <?php
                $cj_pdp_page_details = get_option('trustindex-google-page-details');
                $cj_pdp_review_url = (is_array($cj_pdp_page_details) && !empty($cj_pdp_page_details['review_url'])) ? $cj_pdp_page_details['review_url'] : '';
                if ($cj_pdp_review_url) :
                ?>
                <a href="<?php echo esc_url($cj_pdp_review_url); ?>" class="cj-pdp-google-badge" target="_blank" rel="noopener">
                    <span class="cj-hero-stars" aria-hidden="true">
                        <svg width="13" height="13" viewBox="0 0 16 15" fill="currentColor"><path d="M8 0l2.1 5.4 5.9.2-4.6 3.8 1.5 5.7L8 11.2l-4.9 3.9 1.5-5.7L0 5.6l5.9-.2z"/></svg>
                        <svg width="13" height="13" viewBox="0 0 16 15" fill="currentColor"><path d="M8 0l2.1 5.4 5.9.2-4.6 3.8 1.5 5.7L8 11.2l-4.9 3.9 1.5-5.7L0 5.6l5.9-.2z"/></svg>
                        <svg width="13" height="13" viewBox="0 0 16 15" fill="currentColor"><path d="M8 0l2.1 5.4 5.9.2-4.6 3.8 1.5 5.7L8 11.2l-4.9 3.9 1.5-5.7L0 5.6l5.9-.2z"/></svg>
                        <svg width="13" height="13" viewBox="0 0 16 15" fill="currentColor"><path d="M8 0l2.1 5.4 5.9.2-4.6 3.8 1.5 5.7L8 11.2l-4.9 3.9 1.5-5.7L0 5.6l5.9-.2z"/></svg>
                        <svg width="13" height="13" viewBox="0 0 16 15" fill="currentColor"><path d="M8 0l2.1 5.4 5.9.2-4.6 3.8 1.5 5.7L8 11.2l-4.9 3.9 1.5-5.7L0 5.6l5.9-.2z"/></svg>
                    </span>
                    <span><strong>Avaliações verificadas</strong> no Google — quem compra, recomenda</span>
                </a>
                <?php endif; ?>

                <!-- Metadados (SKU, etc.) -->
                <div class="cj-single-meta">
                    <?php woocommerce_template_single_meta(); ?>
                </div>
            </div>
        </div>

        <!-- Descrição, Notas Olfativas e Detalhes -->
        <div class="cj-product-details-tabs">
            <?php woocommerce_output_product_data_tabs(); ?>
        </div>

        <!-- Produtos Relacionados (Vitrines no estilo The Gregs) -->
        <div class="cj-related-products-wrap">
            <?php woocommerce_output_related_products(); ?>
        </div>
    </div>
</div>

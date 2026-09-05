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

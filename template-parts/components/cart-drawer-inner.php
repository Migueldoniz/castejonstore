<?php
/**
 * Inner Content do Side-Cart Drawer
 * Atualizado via WooCommerce AJAX fragments
 */
if (!defined('ABSPATH') || !class_exists('WooCommerce')) {
    return;
}

$cart = WC()->cart;
$cart_items = $cart ? $cart->get_cart() : array();
$cart_count = $cart ? $cart->get_cart_contents_count() : 0;
$subtotal_raw = $cart ? $cart->get_subtotal() : 0; // valor float

// Meta de Frete Grátis: R$ 299,00
$free_shipping_goal = 299.00;
$remaining_for_free_shipping = max(0, $free_shipping_goal - $subtotal_raw);
$progress_percent = min(100, ($subtotal_raw / $free_shipping_goal) * 100);
?>
<div class="cj-cart-drawer-inner">
    <!-- Barra de Frete Grátis Dinâmica (Estilo The Greg's) -->
    <div class="cj-drawer-free-shipping">
        <?php if ($remaining_for_free_shipping <= 0 && $cart_count > 0) : ?>
            <div class="cj-shipping-msg cj-shipping-success">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>Parabéns! Você ganhou <strong>FRETE GRÁTIS</strong></span>
            </div>
            <div class="cj-shipping-progress-bar">
                <div class="cj-shipping-progress-fill" style="width: 100%;"></div>
            </div>
        <?php else : ?>
            <div class="cj-shipping-msg">
                <span>Faltam <strong><?php echo wc_price($remaining_for_free_shipping); ?></strong> para ganhar <strong>FRETE GRÁTIS</strong></span>
            </div>
            <div class="cj-shipping-progress-bar">
                <div class="cj-shipping-progress-fill" style="width: <?php echo esc_attr($progress_percent); ?>%;"></div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Lista de Itens do Carrinho -->
    <div class="cj-drawer-items-list">
        <?php if (empty($cart_items)) : ?>
            <div class="cj-drawer-empty">
                <div class="cj-empty-icon">
                    <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                </div>
                <h3>Sua sacola está vazia</h3>
                <p>Navegue pelas nossas fragrâncias exclusivas e decants premium para escolher os seus favoritos.</p>
                <a href="<?php echo esc_url(home_url('/loja/')); ?>" class="cj-btn-gold cj-drawer-close-action">
                    Explorar Perfumes
                </a>
            </div>
        <?php else : ?>
            <?php
            foreach ($cart_items as $cart_item_key => $cart_item) {
                $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                    $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                    $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('thumbnail'), $cart_item, $cart_item_key);
                    $product_price = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                    ?>
                    <div class="cj-drawer-item" data-cart-key="<?php echo esc_attr($cart_item_key); ?>">
                        <div class="cj-drawer-item-thumb">
                            <?php if ($product_permalink) : ?>
                                <a href="<?php echo esc_url($product_permalink); ?>"><?php echo $thumbnail; ?></a>
                            <?php else : ?>
                                <?php echo $thumbnail; ?>
                            <?php endif; ?>
                        </div>

                        <div class="cj-drawer-item-details">
                            <h4 class="cj-drawer-item-name">
                                <?php if ($product_permalink) : ?>
                                    <a href="<?php echo esc_url($product_permalink); ?>"><?php echo esc_html($_product->get_name()); ?></a>
                                <?php else : ?>
                                    <?php echo esc_html($_product->get_name()); ?>
                                <?php endif; ?>
                            </h4>

                            <?php
                            // Exibe atributos de variação se houver (ex: 5ml, 10ml)
                            if ($_product->is_type('variation')) {
                                echo '<div class="cj-drawer-item-meta">' . wc_get_formatted_variation($_product, true) . '</div>';
                            }
                            ?>

                            <div class="cj-drawer-item-price">
                                <?php echo $product_price; ?>
                            </div>

                            <div class="cj-drawer-item-actions">
                                <div class="cj-drawer-qty-control" data-cart-key="<?php echo esc_attr($cart_item_key); ?>">
                                    <button type="button" class="cj-qty-btn cj-qty-minus" aria-label="Diminuir quantidade">-</button>
                                    <span class="cj-qty-val"><?php echo esc_html($cart_item['quantity']); ?></span>
                                    <button type="button" class="cj-qty-btn cj-qty-plus" aria-label="Aumentar quantidade">+</button>
                                </div>

                                <a href="<?php echo esc_url(wc_get_cart_remove_url($cart_item_key)); ?>" class="cj-drawer-remove-btn" data-cart-key="<?php echo esc_attr($cart_item_key); ?>" aria-label="Remover item">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                    <span>Remover</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        <?php endif; ?>
    </div>

    <?php if (!empty($cart_items)) : ?>
        <!-- Rodapé do Drawer com Totais e Checkout Direto -->
        <div class="cj-drawer-footer">
            <div class="cj-drawer-subtotal-row">
                <span>Subtotal</span>
                <strong class="cj-drawer-subtotal"><?php echo WC()->cart->get_cart_subtotal(); ?></strong>
            </div>
            <p class="cj-drawer-shipping-note">Frete e descontos calculados na finalização.</p>

            <div class="cj-drawer-cta-group">
                <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="cj-btn-gold cj-drawer-checkout-btn">
                    <span>FINALIZAR COMPRA</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </a>
                <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="cj-drawer-cart-link">
                    Ver carrinho completo
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

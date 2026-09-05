<?php
/**
 * Container do Side-Cart Drawer (Minicart Lateral) - Estilo The Greg's Exclusive
 */
if (!defined('ABSPATH') || !class_exists('WooCommerce')) {
    return;
}
?>
<!-- Backdrop escuro com blur -->
<div class="cj-cart-drawer-backdrop" id="cj-cart-drawer-backdrop"></div>

<!-- Drawer Lateral Deslizante -->
<aside class="cj-cart-drawer" id="cj-cart-drawer" aria-label="Carrinho de Compras">
    <div class="cj-cart-drawer-header">
        <div class="cj-cart-drawer-title">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
            <h3>Sua Sacola</h3>
            <span class="cj-drawer-count-badge cj-cart-count"><?php echo esc_html(WC()->cart->get_cart_contents_count()); ?></span>
        </div>
        <button type="button" class="cj-cart-drawer-close" id="cj-cart-drawer-close" aria-label="Fechar Carrinho">&times;</button>
    </div>

    <!-- O inner content é atualizado via AJAX -->
    <?php get_template_part('template-parts/components/cart-drawer-inner'); ?>
</aside>

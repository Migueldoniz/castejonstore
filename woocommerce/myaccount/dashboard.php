<?php
/**
 * My Account Dashboard - Castejon Theme
 */
if (!defined('ABSPATH')) {
    exit;
}

$allowed_html = array(
    'a' => array(
        'href' => array(),
    ),
);
?>

<div class="cj-account-dashboard">
    <div class="cj-dashboard-hero">
        <h2>Olá, <span><?php echo esc_html($current_user->display_name); ?></span></h2>
        <p>
            <?php
            printf(
                wp_kses(__('A partir do painel de controle da sua conta, você pode visualizar seus <a href="%1$s">pedidos recentes</a>, gerenciar seus <a href="%2$s">endereços de entrega e faturamento</a> e <a href="%3$s">editar sua senha e detalhes da conta</a>.', 'castejon-theme'), $allowed_html),
                esc_url(wc_get_endpoint_url('orders')),
                esc_url(wc_get_endpoint_url('edit-address')),
                esc_url(wc_get_endpoint_url('edit-account'))
            );
            ?>
        </p>
    </div>

    <!-- Cards de Atalho Rápido -->
    <div class="cj-dashboard-grid">
        <a href="<?php echo esc_url(wc_get_endpoint_url('orders')); ?>" class="cj-dashboard-card">
            <div class="cj-dashboard-card-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
            </div>
            <h3>Meus Pedidos</h3>
            <p>Acompanhe o status e código de rastreamento das suas compras.</p>
            <span class="cj-dashboard-card-link">Ver pedidos &rarr;</span>
        </a>

        <a href="<?php echo esc_url(wc_get_endpoint_url('edit-address')); ?>" class="cj-dashboard-card">
            <div class="cj-dashboard-card-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
            </div>
            <h3>Endereços</h3>
            <p>Configure e atualize seus locais de entrega para compras rápidas.</p>
            <span class="cj-dashboard-card-link">Gerenciar endereços &rarr;</span>
        </a>

        <a href="<?php echo esc_url(wc_get_endpoint_url('edit-account')); ?>" class="cj-dashboard-card">
            <div class="cj-dashboard-card-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            </div>
            <h3>Dados Pessoais</h3>
            <p>Altere suas informações de perfil, e-mail e senha de acesso.</p>
            <span class="cj-dashboard-card-link">Editar dados &rarr;</span>
        </a>
    </div>

    <?php
    /**
     * My Account dashboard.
     *
     * @since 2.6.0
     */
    do_action('woocommerce_account_dashboard');

    /**
     * Deprecated woocommerce_before_my_account action.
     *
     * @deprecated 2.6.0
     */
    do_action('woocommerce_before_my_account');

    /**
     * Deprecated woocommerce_after_my_account action.
     *
     * @deprecated 2.6.0
     */
    do_action('woocommerce_after_my_account');
    ?>
</div>

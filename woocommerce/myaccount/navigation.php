<?php
/**
 * My Account Navigation - Castejon Theme
 */
if (!defined('ABSPATH')) {
    exit;
}

do_action('woocommerce_before_account_navigation');
?>

<nav class="cj-account-nav" aria-label="<?php esc_html_e('Navegação da Conta', 'castejon-theme'); ?>">
    <div class="cj-account-user-card">
        <div class="cj-account-avatar">
            <?php
            $current_user = wp_get_current_user();
            echo get_avatar($current_user->ID, 64);
            ?>
        </div>
        <div class="cj-account-user-meta">
            <span class="cj-account-greeting">Bem-vindo(a),</span>
            <strong class="cj-account-username"><?php echo esc_html($current_user->display_name); ?></strong>
            <span class="cj-account-email"><?php echo esc_html($current_user->user_email); ?></span>
        </div>
    </div>

    <ul class="cj-account-menu-list">
        <?php foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>
            <li class="cj-account-menu-item <?php echo wc_get_account_menu_item_classes($endpoint); ?>">
                <a href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>">
                    <span class="cj-account-item-icon">
                        <?php if ($endpoint === 'dashboard') : ?>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        <?php elseif ($endpoint === 'orders') : ?>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                        <?php elseif ($endpoint === 'downloads') : ?>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        <?php elseif ($endpoint === 'edit-address') : ?>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <?php elseif ($endpoint === 'edit-account') : ?>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <?php elseif ($endpoint === 'customer-logout') : ?>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        <?php else : ?>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
                        <?php endif; ?>
                    </span>
                    <span class="cj-account-item-label"><?php echo esc_html($label); ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>

<?php do_action('woocommerce_after_account_navigation'); ?>

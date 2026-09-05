<?php
/**
 * My Account page - Castejon Theme
 */
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="cj-page-hero">
    <div class="cj-container">
        <h1 class="cj-page-title">Minha Conta</h1>
        <p class="cj-page-desc">Gerencie seus pedidos, dados cadastrais e endereços de entrega com total segurança.</p>
    </div>
</div>

<div class="cj-container cj-myaccount-container">
    <div class="cj-account-layout">
        <?php
        /**
         * My Account navigation.
         *
         * @since 2.6.0
         */
        do_action('woocommerce_account_navigation');
        ?>

        <div class="woocommerce-MyAccount-content cj-account-content">
            <?php
            /**
             * My Account content.
             *
             * @since 2.6.0
             */
            do_action('woocommerce_account_content');
            ?>
        </div>
    </div>
</div>

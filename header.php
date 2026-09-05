<?php
/**
 * Header Template - Estilo The Greg's Exclusive
 */
if (!defined('ABSPATH')) {
    exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- 1. Top Announcement Bar (Estilo The Greg's Exclusive) -->
<?php get_template_part('template-parts/components/announcement-bar'); ?>

<header class="cj-site-header">
    <div class="cj-container">
        <!-- Topo Principal (Busca | Logo | Ações) -->
        <div class="cj-header-top">
            <!-- Mobile Toggle -->
            <button class="cj-mobile-btn cj-mobile-toggle" aria-label="Abrir Menu">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
            </button>

            <!-- 1. Campo de Busca (Esquerda) -->
            <div class="cj-search-container">
                <form role="search" method="get" class="cj-search-box" action="<?php echo esc_url(home_url('/')); ?>">
                    <input type="search" placeholder="O que você está buscando?" value="<?php echo get_search_query(); ?>" name="s" required />
                    <input type="hidden" name="post_type" value="product" />
                    <button type="submit" aria-label="Buscar">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    </button>
                </form>
            </div>

            <!-- 2. Logo da Castejon (Centro) -->
            <div class="cj-header-logo">
                <?php castejon_the_custom_logo(); ?>
            </div>

            <!-- 3. Ações do Usuário (Direita) -->
            <div class="cj-header-user-actions">
                <?php if (class_exists('WooCommerce')) : ?>
                    <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="cj-user-account">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <div class="cj-user-account-text">
                            <span>Área do Cliente</span>
                            <strong>Minha Conta</strong>
                        </div>
                    </a>

                    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="cj-cart-btn cj-cart-toggle" aria-label="Carrinho" data-target="#cj-cart-drawer">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                        <span class="cj-cart-badge cj-cart-count"><?php echo esc_html(WC()->cart->get_cart_contents_count()); ?></span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Barra de Navegação Horizontal -->
    <nav class="cj-header-nav" aria-label="Menu Principal">
        <div class="cj-container">
            <ul class="cj-nav-list">
                <li class="cj-nav-item"><a href="<?php echo esc_url(home_url('/')); ?>">Início</a></li>
                <li class="cj-nav-item"><a href="<?php echo esc_url(home_url('/categoria-produto/perfumes/')); ?>">Perfumes</a></li>
                <li class="cj-nav-item cj-has-dropdown">
                    <a href="<?php echo esc_url(home_url('/categoria-produto/decants-2/')); ?>">
                        <span>Decants</span>
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-left: 3px;"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </a>
                    <ul class="cj-dropdown-menu">
                        <li><a href="<?php echo esc_url(home_url('/categoria-produto/decants-2/')); ?>">Todos os Decants</a></li>
                        <li><a href="<?php echo esc_url(home_url('/#guia-decants')); ?>">Guia de Tamanhos (2ml, 5ml, 10ml)</a></li>
                        <li><a href="<?php echo esc_url(home_url('/categoria-produto/kits/')); ?>">Kits Degustação</a></li>
                    </ul>
                </li>
                <li class="cj-nav-item"><a href="<?php echo esc_url(home_url('/categoria-produto/kits/')); ?>">Kits</a></li>
                <li class="cj-nav-item"><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">Loja Completa</a></li>
                <li class="cj-nav-item"><a href="<?php echo esc_url(home_url('/#contato')); ?>">Contato</a></li>
            </ul>
        </div>
    </nav>
</header>

<!-- Mobile Navigation Drawer -->
<div class="cj-mobile-backdrop"></div>
<aside class="cj-mobile-nav" aria-label="Menu Mobile">
    <div class="cj-mobile-header">
        <?php if (function_exists('castejon_the_mobile_logo')) { castejon_the_mobile_logo(); } else { ?><span class="cj-logo-text">CASTEJON</span><?php } ?>
        <button class="cj-mobile-close" aria-label="Fechar Menu">&times;</button>
    </div>
    <div style="padding: 15px;">
        <form role="search" method="get" class="cj-search-box" action="<?php echo esc_url(home_url('/')); ?>">
            <input type="search" placeholder="O que você está buscando?" value="<?php echo get_search_query(); ?>" name="s" required />
            <input type="hidden" name="post_type" value="product" />
            <button type="submit">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </button>
        </form>
    </div>
    <ul class="cj-mobile-list">
        <li><a href="<?php echo esc_url(home_url('/')); ?>" class="cj-mobile-link">Início</a></li>
        <li><a href="<?php echo esc_url(home_url('/categoria-produto/perfumes/')); ?>" class="cj-mobile-link">Perfumes</a></li>
        <li><a href="<?php echo esc_url(home_url('/categoria-produto/decants-2/')); ?>" class="cj-mobile-link">Decants</a></li>
        <li><a href="<?php echo esc_url(home_url('/categoria-produto/kits/')); ?>" class="cj-mobile-link">Kits</a></li>
        <li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="cj-mobile-link">Loja Completa</a></li>
        <li><a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="cj-mobile-link">Minha Conta</a></li>
        <li><a href="<?php echo esc_url(home_url('/#contato')); ?>" class="cj-mobile-link">Contato</a></li>
    </ul>
</aside>

<!-- Side-Cart Drawer (Minicart Lateral AJAX) -->
<?php get_template_part('template-parts/components/cart-drawer'); ?>

<main id="primary" class="site-main">


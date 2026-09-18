<?php
/**
 * Funções principais do Castejon Store Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

define('CASTEJON_THEME_VERSION', '1.0.0');
define('CASTEJON_THEME_DIR', get_template_directory());
define('CASTEJON_THEME_URI', get_template_directory_uri());

// Setup inicial do tema
function castejon_theme_setup() {
    // Suporte nativo para tags de título e miniaturas
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('woocommerce');

    // Suporte a logotipo personalizado
    add_theme_support('custom-logo', array(
        'height'      => 80,
        'width'       => 280,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Suporte a HTML5 semântico
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Registra menus de navegação
    register_nav_menus(array(
        'primary' => __('Menu Principal', 'castejon-theme'),
        'footer'  => __('Menu do Rodapé', 'castejon-theme'),
    ));
}
add_action('after_setup_theme', 'castejon_theme_setup');

// Carrega arquivos de CSS e JavaScript
function castejon_enqueue_scripts() {
    // Google Fonts: Inter e Playfair Display para visual de luxo
    wp_enqueue_style(
        'castejon-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400&display=swap',
        array(),
        null
    );

    // Versões dinâmicas para invalidar cache de desenvolvimento automaticamente
    $css_path = CASTEJON_THEME_DIR . '/assets/css/main.css';
    $js_path  = CASTEJON_THEME_DIR . '/assets/js/main.js';
    $css_version = file_exists($css_path) ? filemtime($css_path) : CASTEJON_THEME_VERSION;
    $js_version  = file_exists($js_path) ? filemtime($js_path) : CASTEJON_THEME_VERSION;

    // CSS base do widget Trustindex (apenas na home) — carregado ANTES do main.css
    // para que os estilos do tema (main.css) tenham prioridade na cascata.
    if (is_front_page()) {
        wp_register_style('cj-trustindex-base', false);
        wp_enqueue_style('cj-trustindex-base');
        $cj_ti_base_css = get_option('trustindex-google-css-content');
        if ($cj_ti_base_css) {
            wp_add_inline_style('cj-trustindex-base', $cj_ti_base_css);
        }
    }

    // CSS Principal do Tema
    wp_enqueue_style(
        'castejon-main',
        CASTEJON_THEME_URI . '/assets/css/main.css',
        array(),
        $css_version
    );

    // JS Principal
    wp_enqueue_script(
        'castejon-main',
        CASTEJON_THEME_URI . '/assets/js/main.js',
        array(),
        $js_version,
        true
    );

    // Dados para scripts frontend
    wp_localize_script('castejon-main', 'castejonData', array(
        'ajaxUrl'  => admin_url('admin-ajax.php'),
        'siteUrl'  => home_url('/'),
        'nonce'    => wp_create_nonce('castejon_ajax_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'castejon_enqueue_scripts');

// ==========================================
// BACKEND SEGURO: NEWSLETTER VIP CASTEJON
// ==========================================
add_action('wp_ajax_castejon_subscribe_newsletter', 'castejon_subscribe_newsletter_handler');
add_action('wp_ajax_nopriv_castejon_subscribe_newsletter', 'castejon_subscribe_newsletter_handler');

function castejon_subscribe_newsletter_handler() {
    check_ajax_referer('castejon_ajax_nonce', 'nonce');

    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';

    if (empty($email) || !is_email($email)) {
        wp_send_json_error(array(
            'message' => 'Por favor, informe um endereço de e-mail válido.',
        ));
    }

    $subscribers = get_option('castejon_newsletter_subscribers', array());
    if (!is_array($subscribers)) {
        $subscribers = array();
    }

    // Verifica se já está cadastrado
    foreach ($subscribers as $sub) {
        if (is_array($sub) && isset($sub['email']) && strtolower($sub['email']) === strtolower($email)) {
            wp_send_json_success(array(
                'message' => 'Você já está cadastrado no nosso Clube VIP! Fique de olho na sua caixa de entrada.',
            ));
        }
    }

    // Adiciona novo inscrito
    $subscribers[] = array(
        'email'      => $email,
        'created_at' => current_time('mysql'),
        'ip'         => sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? ''),
    );

    update_option('castejon_newsletter_subscribers', $subscribers, false);

    // Opcional: Envia notificação por e-mail para o administrador se configurado
    $admin_email = get_option('admin_email');
    if ($admin_email) {
        @wp_mail(
            $admin_email,
            'Novo Inscrito na Newsletter - Castejon Store',
            "Um novo cliente se inscreveu na Newsletter VIP da loja:\n\nE-mail: {$email}\nData: " . current_time('d/m/Y H:i')
        );
    }

    wp_send_json_success(array(
        'message' => '✨ Inscrição confirmada com sucesso! Você receberá ofertas e lançamentos exclusivos.',
    ));
}

// Carrega extensões modulares
if (class_exists('WooCommerce')) {
    require_once CASTEJON_THEME_DIR . '/inc/woocommerce.php';
}
require_once CASTEJON_THEME_DIR . '/inc/customizer.php';

// Retorna o logotipo da Castejon (suporta upload pelo Admin > Personalizar > Identidade do Site)
function castejon_the_custom_logo() {
    $custom_logo_id = get_theme_mod('custom_logo');
    if ($custom_logo_id) {
        $logo_url = wp_get_attachment_image_url($custom_logo_id, 'full');
    } else {
        $logo_url = content_url('/uploads/2024/12/cropped-castejon-logo-1.jpeg');
    }
    echo '<a href="' . esc_url(home_url('/')) . '" class="cj-logo-link" rel="home">';
    echo '<img src="' . esc_url($logo_url) . '" alt="' . esc_attr(get_bloginfo('name')) . '" class="cj-logo-img custom-logo" />';
    echo '</a>';
}

// Oculta categorias antigas/não pertinentes (eletrônicos, roupas, etc) das consultas do catálogo
function castejon_exclude_obsolete_categories_from_shop($query) {
    if (!is_admin() && $query->is_main_query() && (is_shop() || is_product_category() || is_product_tag())) {
        $tax_query = (array) $query->get('tax_query');

        // Slugs das categorias que devem ser ocultadas da navegação de perfumaria
        $excluded_slugs = array('eletronicos', 'roupas', 'som', 'smartwatch', 'smartwatches', 'acessorios-tech');

        $tax_query[] = array(
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => $excluded_slugs,
            'operator' => 'NOT IN',
        );

        $query->set('tax_query', $tax_query);
    }
}
add_action('pre_get_posts', 'castejon_exclude_obsolete_categories_from_shop');

// Limpa transients de vitrines da home quando produtos ou estoque são alterados
function castejon_clear_vitrine_transients() {
    global $wpdb;
    $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_cj_vitrine_%' OR option_name LIKE '_transient_timeout_cj_vitrine_%'");
}
add_action('save_post_product', 'castejon_clear_vitrine_transients');
add_action('woocommerce_reduce_order_stock', 'castejon_clear_vitrine_transients');

// Retorna a logo para o rodapé (suporta upload pelo Admin > Personalizar > Banners e Imagens da Home)
function castejon_the_footer_logo() {
    $footer_logo_url = get_theme_mod('castejon_footer_logo');
    if (!$footer_logo_url) {
        $footer_logo_url = content_url('/uploads/2024/11/logo-png-1.png');
    }
    echo '<a href="' . esc_url(home_url('/')) . '" class="cj-footer-logo-link" rel="home">';
    echo '<img src="' . esc_url($footer_logo_url) . '" alt="' . esc_attr(get_bloginfo('name')) . '" class="cj-footer-logo-img" width="160" height="52" loading="lazy" />';
    echo '</a>';
}

// Retorna a logo para o drawer mobile
function castejon_the_mobile_logo() {
    $custom_logo_id = get_theme_mod('custom_logo');
    if ($custom_logo_id) {
        $logo_url = wp_get_attachment_image_url($custom_logo_id, 'medium');
    } else {
        $logo_url = content_url('/uploads/2024/12/cropped-castejon-logo-1.jpeg');
    }
    echo '<a href="' . esc_url(home_url('/')) . '" class="cj-mobile-logo-link" rel="home">';
    echo '<img src="' . esc_url($logo_url) . '" alt="' . esc_attr(get_bloginfo('name')) . '" class="cj-mobile-logo-img" width="130" height="42" loading="lazy" />';
    echo '</a>';
}

// Redirecionamento amigável de slugs antigos para URLs oficiais
function castejon_redirect_checkout_slug() {
    if (isset($_SERVER['REQUEST_URI']) && preg_match('#^/checkout(/.*)?$#i', $_SERVER['REQUEST_URI'])) {
        wp_safe_redirect(wc_get_checkout_url(), 301);
        exit;
    }
    if (isset($_SERVER['REQUEST_URI']) && preg_match('#^/(pagina-de-minha-conta|my-account)(/.*)?$#i', $_SERVER['REQUEST_URI'], $matches)) {
        $sub = isset($matches[2]) ? $matches[2] : '';
        wp_safe_redirect(home_url('/minha-conta/' . ltrim($sub, '/')), 301);
        exit;
    }
    if (isset($_SERVER['REQUEST_URI']) && preg_match('#^/todos(/.*)?$#i', $_SERVER['REQUEST_URI'], $matches)) {
        $sub = isset($matches[1]) ? $matches[1] : '';
        wp_safe_redirect(home_url('/loja/' . ltrim($sub, '/')), 301);
        exit;
    }
}
add_action('template_redirect', 'castejon_redirect_checkout_slug');

// Força a rota /loja/ a carregar a query oficial de produtos do catálogo
function castejon_shop_query_handler($query) {
    if (!is_admin() && $query->is_main_query()) {
        $shop_id = function_exists('wc_get_page_id') ? wc_get_page_id('shop') : 7;
        if (is_shop() || $query->get('page_id') == $shop_id || $query->get('pagename') === 'loja') {
            $query->set('post_type', 'product');
            $query->set('post_status', 'publish');
            $query->set('page_id', '');
            $query->set('p', '');
            $query->set('name', '');
            $query->set('pagename', '');
            $query->is_page = false;
            $query->is_singular = false;
            $query->is_post_type_archive = true;
            $query->is_archive = true;

            // Ordenação padrão inteligente por data se não houver filtro na URL
            if (!$query->get('orderby')) {
                $query->set('orderby', 'date');
                $query->set('order', 'DESC');
            }
        }
    }
}
add_action('pre_get_posts', 'castejon_shop_query_handler', 5);

// Força o carregamento do template archive-product.php na página da loja
function castejon_shop_template_include($template) {
    if (function_exists('is_shop') && is_shop()) {
        $archive_tpl = locate_template('woocommerce/archive-product.php');
        if ($archive_tpl) {
            return $archive_tpl;
        }
    }
    return $template;
}
add_filter('template_include', 'castejon_shop_template_include', 99);



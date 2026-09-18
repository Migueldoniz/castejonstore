<?php
/**
 * Gerenciador do Personalizador do WordPress (Customizer)
 * Permite trocar logos e imagens da Home diretamente pelo painel administrativo
 */

if (!defined('ABSPATH')) {
    exit;
}

function castejon_customize_register($wp_customize) {
    // 1. Seção: Imagens e Banners da Home
    $wp_customize->add_section('castejon_home_banners', array(
        'title'       => __('Banners e Imagens da Home', 'castejon-theme'),
        'priority'    => 30,
        'description' => __('Altere as imagens de destaque exibidas na página inicial da loja.', 'castejon-theme'),
    ));

    // Campo: Imagem de Fundo do Hero (Banner Principal)
    $wp_customize->add_setting('castejon_hero_bg', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'castejon_hero_bg', array(
        'label'       => __('Imagem de Fundo do Banner Principal (Hero)', 'castejon-theme'),
        'description' => __('Recomendado: 1920x800px (JPG/WebP otimizado)', 'castejon-theme'),
        'section'     => 'castejon_home_banners',
        'settings'    => 'castejon_hero_bg',
    )));

    // Campo: Imagem do Banner de Filosofia da Marca
    $wp_customize->add_setting('castejon_brand_banner_bg', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'castejon_brand_banner_bg', array(
        'label'       => __('Imagem de Fundo do Banner Filosofia Castejon', 'castejon-theme'),
        'description' => __('Recomendado: 1600x600px', 'castejon-theme'),
        'section'     => 'castejon_home_banners',
        'settings'    => 'castejon_brand_banner_bg',
    )));

    // Campo: Logo do Rodapé (versão transparente ou adaptada)
    $wp_customize->add_setting('castejon_footer_logo', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'castejon_footer_logo', array(
        'label'       => __('Logo do Rodapé (Footer)', 'castejon-theme'),
        'description' => __('Recomendado: PNG com fundo transparente ou versão em alta definição', 'castejon-theme'),
        'section'     => 'castejon_home_banners',
        'settings'    => 'castejon_footer_logo',
    )));

    // ==========================================
    // SLIDER DE BANNERS DA HOME (3 SLIDES)
    // ==========================================
    for ($i = 1; $i <= 3; $i++) {
        // Imagem Desktop do Slide
        $wp_customize->add_setting("castejon_slide_{$i}_img_desktop", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "castejon_slide_{$i}_img_desktop", array(
            'label'       => sprintf(__('Slide %d - Imagem Desktop (1920x650)', 'castejon-theme'), $i),
            'description' => __('Recomendado: 1920x650px em WebP/JPG otimizado', 'castejon-theme'),
            'section'     => 'castejon_home_banners',
            'settings'    => "castejon_slide_{$i}_img_desktop",
        )));

        // Imagem Mobile do Slide
        $wp_customize->add_setting("castejon_slide_{$i}_img_mobile", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "castejon_slide_{$i}_img_mobile", array(
            'label'       => sprintf(__('Slide %d - Imagem Mobile (800x1000)', 'castejon-theme'), $i),
            'description' => __('Recomendado: 800x1000px em WebP/JPG otimizado', 'castejon-theme'),
            'section'     => 'castejon_home_banners',
            'settings'    => "castejon_slide_{$i}_img_mobile",
        )));

        // Kicker (selo superior)
        $wp_customize->add_setting("castejon_slide_{$i}_kicker", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("castejon_slide_{$i}_kicker", array(
            'label'       => sprintf(__('Slide %d - Kicker (Texto Pequeno Acima)', 'castejon-theme'), $i),
            'type'        => 'text',
            'section'     => 'castejon_home_banners',
            'settings'    => "castejon_slide_{$i}_kicker",
        ));

        // Título Principal
        $wp_customize->add_setting("castejon_slide_{$i}_title", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("castejon_slide_{$i}_title", array(
            'label'       => sprintf(__('Slide %d - Título Principal', 'castejon-theme'), $i),
            'type'        => 'text',
            'section'     => 'castejon_home_banners',
            'settings'    => "castejon_slide_{$i}_title",
        ));

        // Subtítulo / Descrição
        $wp_customize->add_setting("castejon_slide_{$i}_sub", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
        ));
        $wp_customize->add_control("castejon_slide_{$i}_sub", array(
            'label'       => sprintf(__('Slide %d - Subtítulo / Descrição', 'castejon-theme'), $i),
            'type'        => 'textarea',
            'section'     => 'castejon_home_banners',
            'settings'    => "castejon_slide_{$i}_sub",
        ));

        // Link do Slide
        $wp_customize->add_setting("castejon_slide_{$i}_link", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control("castejon_slide_{$i}_link", array(
            'label'       => sprintf(__('Slide %d - Link de Destino Principal', 'castejon-theme'), $i),
            'type'        => 'url',
            'section'     => 'castejon_home_banners',
            'settings'    => "castejon_slide_{$i}_link",
        ));

        // Texto CTA Primário
        $wp_customize->add_setting("castejon_slide_{$i}_cta_primary_text", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("castejon_slide_{$i}_cta_primary_text", array(
            'label'       => sprintf(__('Slide %d - Botão Primário (Texto)', 'castejon-theme'), $i),
            'type'        => 'text',
            'section'     => 'castejon_home_banners',
            'settings'    => "castejon_slide_{$i}_cta_primary_text",
        ));

        // Link CTA Primário
        $wp_customize->add_setting("castejon_slide_{$i}_cta_primary_url", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control("castejon_slide_{$i}_cta_primary_url", array(
            'label'       => sprintf(__('Slide %d - Botão Primário (Link)', 'castejon-theme'), $i),
            'type'        => 'url',
            'section'     => 'castejon_home_banners',
            'settings'    => "castejon_slide_{$i}_cta_primary_url",
        ));

        // Texto CTA Secundário
        $wp_customize->add_setting("castejon_slide_{$i}_cta_secondary_text", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("castejon_slide_{$i}_cta_secondary_text", array(
            'label'       => sprintf(__('Slide %d - Botão Secundário (Texto)', 'castejon-theme'), $i),
            'type'        => 'text',
            'section'     => 'castejon_home_banners',
            'settings'    => "castejon_slide_{$i}_cta_secondary_text",
        ));

        // Link CTA Secundário
        $wp_customize->add_setting("castejon_slide_{$i}_cta_secondary_url", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control("castejon_slide_{$i}_cta_secondary_url", array(
            'label'       => sprintf(__('Slide %d - Botão Secundário (Link)', 'castejon-theme'), $i),
            'type'        => 'url',
            'section'     => 'castejon_home_banners',
            'settings'    => "castejon_slide_{$i}_cta_secondary_url",
        ));
    }

    // ==========================================
    // DUAL BANNERS (DECANTS & LACRADOS)
    // ==========================================
    $wp_customize->add_setting('castejon_dual_banner_decants_img', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'castejon_dual_banner_decants_img', array(
        'label'       => __('Banner Duplo - Imagem Decants', 'castejon-theme'),
        'description' => __('Recomendado: 800x500px em WebP/JPG', 'castejon-theme'),
        'section'     => 'castejon_home_banners',
        'settings'    => 'castejon_dual_banner_decants_img',
    )));

    $wp_customize->add_setting('castejon_dual_banner_lacrados_img', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'castejon_dual_banner_lacrados_img', array(
        'label'       => __('Banner Duplo - Imagem Lacrados', 'castejon-theme'),
        'description' => __('Recomendado: 800x500px em WebP/JPG', 'castejon-theme'),
        'section'     => 'castejon_home_banners',
        'settings'    => 'castejon_dual_banner_lacrados_img',
    )));

    // ==========================================
    // CONTATO E REDES SOCIAIS
    // ==========================================
    $wp_customize->add_section('castejon_contact_section', array(
        'title'       => __('Contato & Redes Sociais', 'castejon-theme'),
        'priority'    => 35,
        'description' => __('Configure canais de atendimento e links sociais exibidos no rodapé.', 'castejon-theme'),
    ));

    // WhatsApp
    $wp_customize->add_setting('castejon_whatsapp_number', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('castejon_whatsapp_number', array(
        'label'       => __('Número de WhatsApp (somente números com DDD)', 'castejon-theme'),
        'description' => __('Exemplo: 5516999999999', 'castejon-theme'),
        'type'        => 'text',
        'section'     => 'castejon_contact_section',
    ));

    // Instagram
    $wp_customize->add_setting('castejon_instagram_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('castejon_instagram_url', array(
        'label'       => __('Link do Instagram', 'castejon-theme'),
        'type'        => 'url',
        'section'     => 'castejon_contact_section',
    ));

    // Facebook
    $wp_customize->add_setting('castejon_facebook_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('castejon_facebook_url', array(
        'label'       => __('Link do Facebook', 'castejon-theme'),
        'type'        => 'url',
        'section'     => 'castejon_contact_section',
    ));

    // Email
    $wp_customize->add_setting('castejon_contact_email', array(
        'default'           => 'contato@castejonstore.com',
        'sanitize_callback' => 'sanitize_email',
    ));
    $wp_customize->add_control('castejon_contact_email', array(
        'label'       => __('E-mail de Contato', 'castejon-theme'),
        'type'        => 'email',
        'section'     => 'castejon_contact_section',
    ));
}
add_action('customize_register', 'castejon_customize_register');

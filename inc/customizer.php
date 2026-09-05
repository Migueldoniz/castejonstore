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
        // Imagem do Slide
        $wp_customize->add_setting("castejon_slide_{$i}_img", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "castejon_slide_{$i}_img", array(
            'label'       => sprintf(__('Slider - Imagem do Slide %d', 'castejon-theme'), $i),
            'description' => __('Recomendado: proporção 16:9 widescreen (ex: 1920x1080px)', 'castejon-theme'),
            'section'     => 'castejon_home_banners',
            'settings'    => "castejon_slide_{$i}_img",
        )));

        // Link do Slide
        $wp_customize->add_setting("castejon_slide_{$i}_link", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control("castejon_slide_{$i}_link", array(
            'label'       => sprintf(__('Slider - Link de Destino do Slide %d', 'castejon-theme'), $i),
            'type'        => 'url',
            'section'     => 'castejon_home_banners',
            'settings'    => "castejon_slide_{$i}_link",
        ));
    }

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

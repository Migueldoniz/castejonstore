<?php
/**
 * Hero Slider - Slider de Banners da Home
 * Imagens responsivas duplas (Desktop 1920x650 e Mobile 800x1000) no padrão The Greg's Exclusive
 */
if (!defined('ABSPATH')) {
    exit;
}

$upload_url = get_template_directory_uri() . '/assets/images';

$cj_page_details = get_option('trustindex-google-page-details');
$cj_review_url = (is_array($cj_page_details) && !empty($cj_page_details['review_url'])) ? $cj_page_details['review_url'] : '';

$raw_slides_defaults = array(
    1 => array(
        'title'          => 'Fragrâncias Icônicas - Bleu de Chanel & La Vie Est Belle',
        'image_desktop'  => $upload_url . '/banners/slide-1-desktop.webp',
        'image_mobile'   => $upload_url . '/banners/slide-1-mobile.webp',
        'link'           => home_url('/categoria-produto/perfumes/'),
        'alt'            => 'Fragrâncias Icônicas - Bleu de Chanel e La Vie Est Belle - Castejon Store',
        'kicker'         => 'Perfumaria original e lacrada',
        'h1'             => 'Descubra o perfume ideal sem investir no frasco no escuro',
        'sub'            => 'Decants originais de 5ml, 10ml e 15ml para testar na pele com envio rastreado e procedência garantida.',
        'sub_mobile'     => 'Decants de 5ml a 15ml para testar na pele.',
        'cta_primary'    => array('Quero experimentar um decant', home_url('/categoria-produto/decants-2/')),
        'cta_secondary'  => array('Ver frascos originais', home_url('/categoria-produto/perfumes/')),
    ),
    2 => array(
        'title'          => 'Perfumes Árabes & Decants - Lattafa Yara e Asad',
        'image_desktop'  => $upload_url . '/banners/slide-2-desktop.webp',
        'image_mobile'   => $upload_url . '/banners/slide-2-mobile.webp',
        'link'           => home_url('/categoria-produto/decants-2/'),
        'alt'            => 'Perfumes Árabes e Decants - Lattafa Yara e Asad - Castejon Store',
        'kicker'         => 'Decants de nicho',
        'h1'             => 'Fragrâncias raras para testar na pele antes do frasco cheio',
        'sub'            => 'Decants originais de 5ml, 10ml e 15ml com envio rastreado e procedência garantida.',
        'sub_mobile'     => 'Decants de 5ml a 15ml para testar na pele.',
        'cta_primary'    => array('Quero experimentar um decant', home_url('/categoria-produto/decants-2/')),
        'cta_secondary'  => array('Ver catálogo completo', home_url('/loja/')),
    ),
    3 => array(
        'title'          => 'Perfume que Marca, Presença que Encanta',
        'image_desktop'  => $upload_url . '/banners/slide-3-desktop.webp',
        'image_mobile'   => $upload_url . '/banners/slide-3-mobile.webp',
        'link'           => home_url('/loja/'),
        'alt'            => 'Perfume que Marca, Presença que Encanta - Castejon Store',
        'kicker'         => 'Curadoria por experiência',
        'h1'             => 'Conheça na pele antes de investir',
        'sub'            => 'Decants originais, kits de degustação e frascos lacrados com envio rastreado para todo o Brasil.',
        'sub_mobile'     => 'Teste na pele antes de comprar o frasco.',
        'cta_primary'    => array('Quero experimentar um decant', home_url('/categoria-produto/decants-2/')),
        'cta_secondary'  => array('Ver frascos originais', home_url('/categoria-produto/perfumes/')),
    ),
);

$slides = array();
for ($i = 1; $i <= 3; $i++) {
    $def = $raw_slides_defaults[$i];
    
    // Imagens (com fallback para os arquivos locais)
    $img_desktop = get_theme_mod("castejon_slide_{$i}_img_desktop", '');
    if (empty($img_desktop)) {
        // Suporte retrocompatível ao campo antigo 'castejon_slide_X_img'
        $img_desktop = get_theme_mod("castejon_slide_{$i}_img", $def['image_desktop']);
    }
    
    $img_mobile = get_theme_mod("castejon_slide_{$i}_img_mobile", $def['image_mobile']);
    
    // Textos
    $kicker = get_theme_mod("castejon_slide_{$i}_kicker", $def['kicker']);
    $title  = get_theme_mod("castejon_slide_{$i}_title", $def['h1']);
    $sub    = get_theme_mod("castejon_slide_{$i}_sub", $def['sub']);
    $link   = get_theme_mod("castejon_slide_{$i}_link", $def['link']);
    
    // CTAs
    $cta_primary_text = get_theme_mod("castejon_slide_{$i}_cta_primary_text", $def['cta_primary'][0]);
    $cta_primary_url  = get_theme_mod("castejon_slide_{$i}_cta_primary_url", $def['cta_primary'][1]);
    
    $cta_secondary_text = get_theme_mod("castejon_slide_{$i}_cta_secondary_text", $def['cta_secondary'][0]);
    $cta_secondary_url  = get_theme_mod("castejon_slide_{$i}_cta_secondary_url", $def['cta_secondary'][1]);

    // Cache busting inteligente para atualizar instantaneamente no navegador
    $raw_img_desktop = $img_desktop ?: $def['image_desktop'];
    $raw_img_mobile  = $img_mobile ?: $def['image_mobile'];
    
    $desktop_file = get_template_directory() . '/assets/images/banners/' . basename(parse_url($raw_img_desktop, PHP_URL_PATH));
    $mobile_file  = get_template_directory() . '/assets/images/banners/' . basename(parse_url($raw_img_mobile, PHP_URL_PATH));
    
    $v_desktop = file_exists($desktop_file) ? filemtime($desktop_file) : time();
    $v_mobile  = file_exists($mobile_file) ? filemtime($mobile_file) : time();

    $slides[] = array(
        'title'          => $def['title'],
        'image_desktop'  => add_query_arg('v', $v_desktop, $raw_img_desktop),
        'image_mobile'   => add_query_arg('v', $v_mobile, $raw_img_mobile),
        'link'           => $link ?: $def['link'],
        'alt'            => $title ?: $def['alt'],
        'kicker'         => $kicker,
        'h1'             => $title ?: $def['h1'],
        'sub'            => $sub,
        'sub_mobile'     => !empty($def['sub_mobile']) ? $def['sub_mobile'] : $sub,
        'cta_primary'    => array($cta_primary_text, $cta_primary_url),
        'cta_secondary'  => array($cta_secondary_text, $cta_secondary_url),
    );
}
?>

<section class="cj-hero-slider-section" aria-label="Destaques da Loja">
    <div class="cj-slider-wrapper" id="cjHomeSlider">
        <div class="cj-slider-track">
            <?php foreach ($slides as $index => $slide) : ?>
                <div class="cj-slide <?php echo $index === 0 ? 'is-active' : ''; ?>" data-slide-index="<?php echo esc_attr($index); ?>">
                    <a href="<?php echo esc_url($slide['link']); ?>" class="cj-slide-link" title="<?php echo esc_attr($slide['title']); ?>">
                        <picture class="cj-slide-picture">
                            <!-- Imagem Mobile (até 767px) -->
                            <source media="(max-width: 767px)" srcset="<?php echo esc_url($slide['image_mobile']); ?>">
                            <!-- Imagem Desktop (padrão) -->
                            <img 
                                src="<?php echo esc_url($slide['image_desktop']); ?>" 
                                alt="<?php echo esc_attr($slide['alt']); ?>" 
                                class="cj-slide-img" 
                                <?php if ($index === 0) : ?>
                                    loading="eager" 
                                    fetchpriority="high"
                                <?php else : ?>
                                    loading="lazy" 
                                <?php endif; ?>
                                width="1920"
                                height="650"
                            />
                        </picture>
                    </a>

                    <?php $hero_heading_tag = $index === 0 ? 'h1' : 'h2'; ?>
                    <div class="cj-hero-copy">
                        <div class="cj-hero-copy-inner">
                            <?php if (!empty($slide['kicker'])) : ?>
                                <span class="cj-hero-kicker"><?php echo esc_html($slide['kicker']); ?></span>
                            <?php endif; ?>
                            <?php if (!empty($slide['h1'])) : ?>
                                <<?php echo $hero_heading_tag; ?> class="cj-hero-h1"><?php echo esc_html($slide['h1']); ?></<?php echo $hero_heading_tag; ?>>
                            <?php endif; ?>
                            <?php if (!empty($slide['sub'])) : ?>
                                <p class="cj-hero-sub cj-hero-sub-full"><?php echo esc_html($slide['sub']); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($slide['sub_mobile'])) : ?>
                                <p class="cj-hero-sub cj-hero-sub-short"><?php echo esc_html($slide['sub_mobile']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Setas de Navegação -->
        <button type="button" class="cj-slider-btn cj-slider-prev" aria-label="Slide anterior">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </button>
        <button type="button" class="cj-slider-btn cj-slider-next" aria-label="Próximo slide">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </button>

        <!-- Indicadores (Dots) -->
        <div class="cj-slider-dots">
            <?php foreach ($slides as $index => $slide) : ?>
                <button type="button" class="cj-slider-dot <?php echo $index === 0 ? 'is-active' : ''; ?>" data-slide-target="<?php echo esc_attr($index); ?>" aria-label="Ir para slide <?php echo esc_attr($index + 1); ?>"></button>
            <?php endforeach; ?>
        </div>
    </div>
</section>

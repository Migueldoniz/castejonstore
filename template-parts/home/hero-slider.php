<?php
/**
 * Hero Slider - Slider de Banners da Home
 * Imagens responsivas duplas (Desktop 1920x650 e Mobile 800x1000) no padrão The Greg's Exclusive
 */
if (!defined('ABSPATH')) {
    exit;
}

$upload_url = get_template_directory_uri() . '/assets/images';

$slides = array(
    array(
        'title'          => 'Fragrâncias Icônicas - Bleu de Chanel & La Vie Est Belle',
        'image_desktop'  => $upload_url . '/banners/slide-1-desktop.png',
        'image_mobile'   => $upload_url . '/banners/slide-1-mobile.png',
        'link'           => home_url('/categoria-produto/perfumes/'),
        'alt'            => 'Fragrâncias Icônicas - Bleu de Chanel e La Vie Est Belle - Castejon Store',
    ),
    array(
        'title'          => 'Perfumes Árabes & Decants - Lattafa Yara e Asad',
        'image_desktop'  => $upload_url . '/banners/slide-2-desktop.png',
        'image_mobile'   => $upload_url . '/banners/slide-2-mobile.png',
        'link'           => home_url('/categoria-produto/decants-2/'),
        'alt'            => 'Perfumes Árabes e Decants - Lattafa Yara e Asad - Castejon Store',
    ),
    array(
        'title'          => 'Perfume que Marca, Presença que Encanta',
        'image_desktop'  => $upload_url . '/banners/slide-3-desktop.png',
        'image_mobile'   => $upload_url . '/banners/slide-3-mobile.png',
        'link'           => home_url('/loja/'),
        'alt'            => 'Perfume que Marca, Presença que Encanta - Castejon Store',
    ),
);
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

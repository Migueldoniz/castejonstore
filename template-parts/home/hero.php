<?php
/**
 * Seção Hero Banner - Castejon Store
 */

if (!defined('ABSPATH')) {
    exit;
}

$hero_bg_url = get_theme_mod('castejon_hero_bg');
$hero_inline_style = $hero_bg_url ? 'style="background-image: linear-gradient(135deg, rgba(0,0,36,0.92) 0%, rgba(0,0,36,0.75) 100%), url(' . esc_url($hero_bg_url) . '); background-size: cover; background-position: center;"' : '';
?>
<section class="cj-hero" <?php echo $hero_inline_style; ?>>
    <div class="cj-container">
        <div class="cj-hero-content">
            <div class="cj-hero-badge">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                <span>Curadoria Exclusiva de Perfumaria</span>
            </div>
            <h1 class="cj-hero-title">
                Descubra Fragrâncias Icônicas. <span>Comece por Decants.</span>
            </h1>
            <p class="cj-hero-description">
                Explore perfumes importados raros e de nicho com autenticidade garantida. Teste na sua própria pele antes de investir no frasco lacrado.
            </p>
            <div class="cj-hero-buttons">
                <a href="<?php echo esc_url(home_url('/categoria-produto/decants-2/')); ?>" class="cj-btn cj-btn-primary">
                    Explorar Decants
                </a>
                <a href="<?php echo esc_url(home_url('/categoria-produto/perfumes/')); ?>" class="cj-btn cj-btn-outline">
                    Perfumes Lacrados
                </a>
            </div>
        </div>
    </div>
</section>

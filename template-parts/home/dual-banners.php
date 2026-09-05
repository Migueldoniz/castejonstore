<?php
/**
 * Banners Duplos (Decants & Lacrados) - Estilo The Greg's Exclusive
 */

if (!defined('ABSPATH')) {
    exit;
}

$cat_decants = get_term_by('slug', 'decants-2', 'product_cat');
$cat_perfumes = get_term_by('slug', 'perfumes', 'product_cat');

$cj_get_thumb = function($term, $fallback) {
    if ($term && !is_wp_error($term)) {
        $thumb_id = get_term_meta($term->term_id, 'thumbnail_id', true);
        if ($thumb_id) {
            $url = wp_get_attachment_image_url($thumb_id, 'full');
            if ($url) {
                return $url;
            }
        }
    }
    return $fallback;
};

$img_decants = $cj_get_thumb($cat_decants, 'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?q=80&w=1200&auto=format&fit=crop');
$img_lacrados = $cj_get_thumb($cat_perfumes, 'https://images.unsplash.com/photo-1523293182086-7651a899d37f?q=80&w=1200&auto=format&fit=crop');
?>
<section class="cj-dual-banners-section">
    <div class="cj-container">
        <div class="cj-dual-banners-grid">
            <!-- Banner 1: DECANTS -->
            <a href="<?php echo esc_url(home_url('/categoria-produto/decants-2/')); ?>" class="cj-dual-banner-card">
                <div class="cj-dual-banner-bg" style="background-image: url('<?php echo esc_url($img_decants); ?>');"></div>
                <div class="cj-dual-banner-overlay"></div>
                <div class="cj-dual-banner-content">
                    <span class="cj-dual-banner-badge">Experimente Fragrâncias de Nicho</span>
                    <h3 class="cj-dual-banner-title">DECANTS</h3>
                    <p class="cj-dual-banner-desc">Fracionados de 2ml, 5ml e 10ml com selo de autenticidade</p>
                    <span class="cj-dual-banner-cta">
                        <span>Explorar Decants</span>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </span>
                </div>
            </a>

            <!-- Banner 2: LACRADOS -->
            <a href="<?php echo esc_url(home_url('/categoria-produto/perfumes/')); ?>" class="cj-dual-banner-card">
                <div class="cj-dual-banner-bg" style="background-image: url('<?php echo esc_url($img_lacrados); ?>');"></div>
                <div class="cj-dual-banner-overlay"></div>
                <div class="cj-dual-banner-content">
                    <span class="cj-dual-banner-badge">Frascos Masters Originais</span>
                    <h3 class="cj-dual-banner-title">LACRADOS</h3>
                    <p class="cj-dual-banner-desc">Coleções completas com procedência direta e garantia</p>
                    <span class="cj-dual-banner-cta">
                        <span>Ver Perfumes</span>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </span>
                </div>
            </a>
        </div>
    </div>
</section>

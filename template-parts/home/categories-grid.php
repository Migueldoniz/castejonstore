<?php
/**
 * Grid de Categorias em Destaque - Estilo The Greg's Exclusive
 */

if (!defined('ABSPATH')) {
    exit;
}

$cat_decants = get_term_by('slug', 'decants-2', 'product_cat');
$cat_perfumes = get_term_by('slug', 'perfumes', 'product_cat');
$cat_kits = get_term_by('slug', 'kits', 'product_cat');
$cat_cosmeticos = get_term_by('slug', 'cosmeticos', 'product_cat');

$cj_get_cat_thumb = function($term, $fallback) {
    if ($term && !is_wp_error($term)) {
        $thumb_id = get_term_meta($term->term_id, 'thumbnail_id', true);
        if ($thumb_id) {
            $url = wp_get_attachment_image_url($thumb_id, 'large');
            if ($url) {
                return $url;
            }
        }
    }
    return $fallback;
};

$categories_data = array(
    array(
        'title'    => 'Decants Premium',
        'badge'    => 'Mais Procurado',
        'desc'     => 'Fracionados de 2ml, 5ml e 10ml para conhecer fragrâncias raras e de nicho.',
        'count'    => $cat_decants ? $cat_decants->count . ' opções' : 'Decants originais',
        'link'     => home_url('/categoria-produto/decants-2/'),
        'image'    => $cj_get_cat_thumb($cat_decants, 'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?q=80&w=800&auto=format&fit=crop'),
        'is_hero'  => true,
    ),
    array(
        'title'    => 'Perfumes Lacrados',
        'badge'    => '100% Originais',
        'desc'     => 'Frascos masters completos lacrados com garantia total de autenticidade.',
        'count'    => $cat_perfumes ? $cat_perfumes->count . ' fragrâncias' : 'Frascos lacrados',
        'link'     => home_url('/categoria-produto/perfumes/'),
        'image'    => $cj_get_cat_thumb($cat_perfumes, 'https://images.unsplash.com/photo-1523293182086-7651a899d37f?q=80&w=800&auto=format&fit=crop'),
        'is_hero'  => false,
    ),
    array(
        'title'    => 'Kits Degustação',
        'badge'    => 'Exclusivo',
        'desc'     => 'Seleções temáticas com vários decants para presentear ou colecionar.',
        'count'    => $cat_kits ? $cat_kits->count . ' kits' : 'Kits temáticos',
        'link'     => home_url('/categoria-produto/kits/'),
        'image'    => $cj_get_cat_thumb($cat_kits, 'https://images.unsplash.com/photo-1594035910387-fea47794261f?q=80&w=800&auto=format&fit=crop'),
        'is_hero'  => false,
    ),
    array(
        'title'    => 'Catálogo Completo',
        'badge'    => 'Todos os Produtos',
        'desc'     => 'Explore todas as fragrâncias importadas disponíveis em nossa loja.',
        'count'    => 'Ver todos',
        'link'     => home_url('/loja/'),
        'image'    => 'https://images.unsplash.com/photo-1547887537-6158d64c35b3?q=80&w=800&auto=format&fit=crop',
        'is_hero'  => false,
    ),
);
?>
<section class="cj-categories-section">
    <div class="cj-container">
        <div class="cj-section-header">
            <div class="cj-section-title-wrap">
                <span class="cj-section-pretitle">Curadoria por Experiência</span>
                <h2 class="cj-section-title">Grandes Categorias</h2>
                <p class="cj-section-subtitle">Escolha o formato ideal para a sua jornada olfativa</p>
            </div>
            <a href="<?php echo esc_url(home_url('/loja/')); ?>" class="cj-section-link">
                <span>Ver Todo o Catálogo</span>
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </a>
        </div>

        <div class="cj-categories-grid">
            <?php foreach ($categories_data as $cat) : ?>
                <a href="<?php echo esc_url($cat['link']); ?>" class="cj-category-card <?php echo !empty($cat['is_hero']) ? 'is-hero-card' : ''; ?>">
                    <div class="cj-category-img-wrap">
                        <img src="<?php echo esc_url($cat['image']); ?>" alt="<?php echo esc_attr($cat['title']); ?>" class="cj-category-img" loading="lazy" />
                        <div class="cj-category-overlay"></div>
                    </div>
                    <div class="cj-category-content">
                        <div class="cj-category-top">
                            <span class="cj-category-badge"><?php echo esc_html($cat['badge']); ?></span>
                            <span class="cj-category-count"><?php echo esc_html($cat['count']); ?></span>
                        </div>
                        <div class="cj-category-bottom">
                            <h3 class="cj-category-title"><?php echo esc_html($cat['title']); ?></h3>
                            <p class="cj-category-desc"><?php echo esc_html($cat['desc']); ?></p>
                            <span class="cj-category-cta">
                                <span>Explorar</span>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

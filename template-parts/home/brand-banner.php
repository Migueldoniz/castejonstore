<?php
/**
 * Banner de Storytelling e Autoridade da Marca - Castejon Store
 */

if (!defined('ABSPATH')) {
    exit;
}

$brand_bg_url = get_theme_mod('castejon_brand_banner_bg');
$brand_inline_style = $brand_bg_url ? 'style="background-image: linear-gradient(135deg, rgba(0,0,36,0.94) 0%, rgba(1,2,28,0.86) 100%), url(' . esc_url($brand_bg_url) . '); background-size: cover; background-position: center;"' : '';
?>
<section class="cj-brand-banner" <?php echo $brand_inline_style; ?>>
    <div class="cj-container">
        <div class="cj-brand-inner">
            <span class="cj-brand-badge">A Filosofia Castejon</span>
            <h2 class="cj-brand-title">A Liberdade de Escolher o Seu Próximo Perfume de Assinatura</h2>
            <p class="cj-brand-text">
                Acreditamos que um perfume é uma extensão invisível da sua presença. Por isso, selecionamos as mais refinadas criações da perfumaria mundial e disponibilizamos em frascos lacrados e decants originais fracionados com precisão. Conheça as notas, sinta a evolução na pele e compre com absoluta certeza.
            </p>
            <a href="<?php echo esc_url(home_url('/categoria-produto/decants-2/')); ?>" class="cj-btn cj-btn-primary">
                Conheça Nossos Decants
            </a>
        </div>
    </div>
</section>

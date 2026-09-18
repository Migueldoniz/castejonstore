<?php
/**
 * Avaliações do Google (Trustindex) - Prova Social
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!shortcode_exists('trustindex')) {
    return;
}

$cj_page_details = get_option('trustindex-google-page-details');
$cj_review_url = (is_array($cj_page_details) && !empty($cj_page_details['review_url'])) ? $cj_page_details['review_url'] : '';
?>
<section class="cj-reviews-section">
    <div class="cj-container">
        <div class="cj-section-header cj-reviews-header">
            <div class="cj-section-title-wrap">
                <span class="cj-section-pretitle">Prova Social</span>
                <h2 class="cj-section-title">Quem já comprou, recomenda</h2>
                <p class="cj-section-subtitle">Avaliações reais de clientes no Google sobre autenticidade, atendimento e entrega.</p>
                <div class="cj-reviews-score">
                    <span class="cj-hero-stars" aria-hidden="true">
                        <svg width="14" height="14" viewBox="0 0 16 15" fill="currentColor"><path d="M8 0l2.1 5.4 5.9.2-4.6 3.8 1.5 5.7L8 11.2l-4.9 3.9 1.5-5.7L0 5.6l5.9-.2z"/></svg>
                        <svg width="14" height="14" viewBox="0 0 16 15" fill="currentColor"><path d="M8 0l2.1 5.4 5.9.2-4.6 3.8 1.5 5.7L8 11.2l-4.9 3.9 1.5-5.7L0 5.6l5.9-.2z"/></svg>
                        <svg width="14" height="14" viewBox="0 0 16 15" fill="currentColor"><path d="M8 0l2.1 5.4 5.9.2-4.6 3.8 1.5 5.7L8 11.2l-4.9 3.9 1.5-5.7L0 5.6l5.9-.2z"/></svg>
                        <svg width="14" height="14" viewBox="0 0 16 15" fill="currentColor"><path d="M8 0l2.1 5.4 5.9.2-4.6 3.8 1.5 5.7L8 11.2l-4.9 3.9 1.5-5.7L0 5.6l5.9-.2z"/></svg>
                        <svg width="14" height="14" viewBox="0 0 16 15" fill="currentColor"><path d="M8 0l2.1 5.4 5.9.2-4.6 3.8 1.5 5.7L8 11.2l-4.9 3.9 1.5-5.7L0 5.6l5.9-.2z"/></svg>
                    </span>
                    Avaliações verificadas no Google
                </div>
            </div>
            <?php if ($cj_review_url) : ?>
                <a href="<?php echo esc_url($cj_review_url); ?>" class="cj-section-link" target="_blank" rel="noopener">
                    <span>Ver todas no Google</span>
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </a>
            <?php endif; ?>
        </div>

        <div class="cj-reviews-widget">
            <?php
            // O CSS base do widget é carregado no <head> via functions.php (antes do main.css).
            // Renderiza as avaliações sem depender do loader.js (que não hidrata em alguns navegadores).
            // Extrai o markup do <template> gerado pelo plugin e converte <trustindex-image> -> <img> real.
            $cj_ti_raw = do_shortcode('[trustindex no-registration=google]');
            if (preg_match('/<template[^>]*>(.*?)<\/template>/s', $cj_ti_raw, $cj_ti_match)) {
                $cj_ti_html = preg_replace('/<trustindex-image ([^>]*?)data-imgurl="([^"]+)"([^>]*?)\/?>/', '<img $1src="$2"$3>', $cj_ti_match[1]);
                // Remove o modo "readmore" (truncamento com "Consulte Mais informação" morto sem loader.js)
                $cj_ti_html = str_replace(array('data-review-text-mode="readmore"', 'ti-review-text-mode-readmore'), '', $cj_ti_html);
                echo $cj_ti_html; // phpcs:ignore WordPress.Security.EscapeOutput -- HTML do plugin Trustindex
            } else {
                echo $cj_ti_raw; // phpcs:ignore WordPress.Security.EscapeOutput
            }
            ?>
        </div>
    </div>
</section>

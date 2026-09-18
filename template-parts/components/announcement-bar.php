<?php
/**
 * Top Announcement Bar - Estilo The Greg's Exclusive
 */
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="cj-announcement-bar" id="cj-announcement-bar">
    <div class="cj-container">
        <div class="cj-announcement-content">
            <button type="button" class="cj-announcement-arrow cj-prev" aria-label="Mensagem anterior">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </button>
            <div class="cj-announcement-slider">
                <div class="cj-announcement-item is-active">
                    <a href="<?php echo esc_url(home_url('/categoria-produto/kits/')); ?>" class="cj-announcement-link">
                        <span class="cj-announcement-icon">🎁</span>
                        <span class="cj-ann-text-full">KITS DE DEGUSTAÇÃO A PARTIR DE <strong>R$110</strong> — SELEÇÕES TEMÁTICAS</span>
                        <span class="cj-ann-text-mobile">KITS A PARTIR DE <strong>R$110</strong></span>
                    </a>
                </div>
                <div class="cj-announcement-item">
                    <span class="cj-announcement-icon">💳</span>
                    <span class="cj-ann-text-full">PARCELE SUAS COMPRAS EM ATÉ <strong>12X NO CARTÃO</strong></span>
                    <span class="cj-ann-text-mobile">ATÉ <strong>12X NO CARTÃO</strong></span>
                </div>
                <div class="cj-announcement-item">
                    <span class="cj-announcement-icon">💎</span>
                    <span class="cj-ann-text-full">PERFUMES <strong>100% ORIGINAIS</strong> E DECANTS EXCLUSIVOS</span>
                    <span class="cj-ann-text-mobile">PERFUMES <strong>100% ORIGINAIS</strong></span>
                </div>
                <div class="cj-announcement-item">
                    <span class="cj-announcement-icon">⚡</span>
                    <span class="cj-ann-text-full">DESPACHO ÁGIL COM <strong>CÓDIGO DE RASTREIO</strong> GARANTIDO</span>
                    <span class="cj-ann-text-mobile">DESPACHO ÁGIL COM RASTREIO</span>
                </div>
            </div>
            <button type="button" class="cj-announcement-arrow cj-next" aria-label="Próxima mensagem">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>
        </div>
    </div>
</div>

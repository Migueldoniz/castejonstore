<?php
/**
 * Guia Educativo de Decants - Estilo The Greg's Exclusive
 * Explica as vantagens e a volumetria de cada fração (2ml, 5ml, 10ml)
 */
if (!defined('ABSPATH')) {
    exit;
}
?>
<section class="cj-decant-guide-section" id="guia-decants">
    <div class="cj-container">
        <div class="cj-decant-guide-header">
            <span class="cj-decant-pretitle">Experiência Olfativa Inteligente</span>
            <h2 class="cj-decant-title">Entenda os Tamanhos de Decants</h2>
            <p class="cj-decant-subtitle">
                O decant é a fração original do perfume transferida para um frasco spray portátil. Experimente as fragrâncias mais desejadas do mundo sem precisar comprar o frasco grande lacrado.
            </p>
        </div>

        <div class="cj-decant-cards-grid">
            <!-- Card 2ml -->
            <div class="cj-decant-card">
                <div class="cj-decant-badge">Degustação</div>
                <div class="cj-decant-visual">
                    <div class="cj-decant-bottle-graphic cj-size-2ml">
                        <span class="cj-bottle-cap"></span>
                        <span class="cj-bottle-body">
                            <span class="cj-bottle-liquid"></span>
                            <span class="cj-bottle-label">2ml</span>
                        </span>
                    </div>
                </div>
                <div class="cj-decant-volume">2 ML</div>
                <div class="cj-decant-sprays">~30 a 35 borrifadas</div>
                <div class="cj-decant-divider"></div>
                <p class="cj-decant-purpose">
                    Ideal para testar na pele, sentir a pirâmide olfativa e a fixação ao longo do dia antes de decidir.
                </p>
                <div class="cj-decant-highlight">
                    <span>Duração:</span> <strong>5 a 7 dias de uso</strong>
                </div>
            </div>

            <!-- Card 5ml (Destaque Mais Escolhido) -->
            <div class="cj-decant-card is-popular">
                <div class="cj-decant-badge cj-badge-gold">Mais Vendido</div>
                <div class="cj-decant-visual">
                    <div class="cj-decant-bottle-graphic cj-size-5ml">
                        <span class="cj-bottle-cap"></span>
                        <span class="cj-bottle-body">
                            <span class="cj-bottle-liquid"></span>
                            <span class="cj-bottle-label">5ml</span>
                        </span>
                    </div>
                </div>
                <div class="cj-decant-volume">5 ML</div>
                <div class="cj-decant-sprays">~75 a 80 borrifadas</div>
                <div class="cj-decant-divider"></div>
                <p class="cj-decant-purpose">
                    O tamanho perfeito para levar no bolso, no carro ou na mala de viagem. Permite usar em várias ocasiões.
                </p>
                <div class="cj-decant-highlight">
                    <span>Duração:</span> <strong>2 a 3 semanas</strong>
                </div>
            </div>

            <!-- Card 10ml -->
            <div class="cj-decant-card">
                <div class="cj-decant-badge">Melhor Custo-Benefício</div>
                <div class="cj-decant-visual">
                    <div class="cj-decant-bottle-graphic cj-size-10ml">
                        <span class="cj-bottle-cap"></span>
                        <span class="cj-bottle-body">
                            <span class="cj-bottle-liquid"></span>
                            <span class="cj-bottle-label">10ml</span>
                        </span>
                    </div>
                </div>
                <div class="cj-decant-volume">10 ML</div>
                <div class="cj-decant-sprays">~150 a 160 borrifadas</div>
                <div class="cj-decant-divider"></div>
                <p class="cj-decant-purpose">
                    Para quem já conhece a fragrância ou deseja uma volumetria abundante para uso regular sem pagar pelo frasco cheio.
                </p>
                <div class="cj-decant-highlight">
                    <span>Duração:</span> <strong>Mais de 1 mês</strong>
                </div>
            </div>
        </div>

        <div class="cj-decant-guide-footer">
            <a href="<?php echo esc_url(home_url('/categoria-produto/decants-2/')); ?>" class="cj-btn-gold">
                <span>VER TODOS OS DECANTS DISPONÍVEIS</span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </a>
        </div>
    </div>
</section>

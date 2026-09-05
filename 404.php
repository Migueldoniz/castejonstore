<?php
/**
 * 404 Template - Castejon Store
 */

get_header();
?>

<div class="cj-container" style="padding: 7rem 1.5rem; text-align: center;">
    <span style="font-family: var(--font-serif); font-size: 5rem; font-weight: 700; color: var(--cj-navy-800); display: block; line-height: 1;">404</span>
    <h1 style="font-family: var(--font-serif); font-size: 2rem; margin: 1rem 0; color: var(--cj-navy-900);">Página Não Encontrada</h1>
    <p style="color: var(--cj-text-secondary); max-width: 480px; margin: 0 auto 2.5rem;">
        A fragrância ou página que você buscou não foi localizada ou foi descontinuada.
    </p>
    <div style="display: flex; justify-content: center; gap: 1rem;">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="cj-btn cj-btn-primary">Voltar para o Início</a>
        <a href="<?php echo esc_url(home_url('/categoria-produto/decants-2/')); ?>" class="cj-btn cj-btn-dark">Explorar Decants</a>
    </div>
</div>

<?php
get_footer();

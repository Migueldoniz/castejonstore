<?php
/**
 * Front Page Template - Castejon Store
 * Layout fiel ao The Greg's Exclusive, mantendo os conteúdos e textos originais da loja
 */

get_header();
?>

<!-- 1. Slider de Banners em Destaque (Estilo Oficial Castejon Store) -->
<?php get_template_part('template-parts/home/hero-slider'); ?>


<!-- 2. Faixa de Benefícios (Estilo The Gregs) -->
<?php get_template_part('template-parts/home/benefits-bar'); ?>

<!-- 3. Grid de Categorias em Destaque -->
<?php get_template_part('template-parts/home/categories-grid'); ?>

<!-- 4. Vitrine 1: Mais Vendidos & Curadoria -->
<?php
get_template_part('template-parts/home/vitrine', null, array(
    'title'    => 'Mais Vendidos da Curadoria',
    'category' => '', // Geral
    'limit'    => 8,
    'orderby'  => 'popularity',
    'link'     => home_url('/loja/?orderby=popularity'),
));
?>

<!-- 5. Banners Duplos de Categoria (Estilo The Greg's) -->
<?php get_template_part('template-parts/home/dual-banners'); ?>

<!-- 6. Vitrine 2: Decants Exclusivos -->
<?php
get_template_part('template-parts/home/vitrine', null, array(
    'title'    => 'Decants Exclusivos (2ml, 5ml e 10ml)',
    'category' => 'decants-2',
    'limit'    => 8,
    'orderby'  => 'date',
    'link'     => home_url('/categoria-produto/decants-2/'),
    'is_alt'   => true,
));
?>

<!-- 6. Guia Educativo de Decants (2ml / 5ml / 10ml) - Elemento chave de conversão The Gregs -->
<?php get_template_part('template-parts/home/decant-guide'); ?>

<!-- 7. Vitrine 3: Perfumes Lacrados & Frascos Completos -->
<?php
get_template_part('template-parts/home/vitrine', null, array(
    'title'    => 'Perfumes Lacrados & Frascos Completos',
    'category' => 'perfumes',
    'limit'    => 8,
    'orderby'  => 'date',
    'link'     => home_url('/categoria-produto/perfumes/'),
    'is_alt'   => false,
));
?>

<!-- 8. Newsletter VIP (Estilo The Gregs) -->
<section class="cj-newsletter-section">
    <div class="cj-container">
        <div class="cj-newsletter-wrap">
            <div class="cj-newsletter-left">
                <span class="cj-newsletter-tag" style="color: var(--gregs-gold); font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; display: block; margin-bottom: 4px;">Comunidade Castejon</span>
                <h3>Acesso a Lançamentos & Decants Raros</h3>
                <p>Receba em primeira mão notificações sobre novos fracionamentos de nicho e reposições limitadas.</p>
            </div>
            <form class="cj-newsletter-form">
                <input type="email" placeholder="Digite seu melhor e-mail" required />
                <button type="submit">RECEBER NOVIDADES VIP</button>
            </form>
        </div>
    </div>
</section>

<?php
get_footer();


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

<!-- 4. Guia Educativo de Decants (5ml / 10ml / 15ml) - Elemento chave de conversão The Gregs -->
<?php get_template_part('template-parts/home/decant-guide'); ?>

<!-- 5. Vitrine 1: Mais Vendidos & Curadoria -->
<?php
get_template_part('template-parts/home/vitrine', null, array(
    'title'    => 'Mais Vendidos da Curadoria',
    'category' => '', // Geral
    'limit'    => 8,
    'orderby'  => 'popularity',
    'link'     => home_url('/loja/?orderby=popularity'),
));
?>

<!-- 6. Avaliações do Google (Prova Social) -->
<?php get_template_part('template-parts/home/google-reviews'); ?>

<!-- 7. Banners Duplos de Categoria (Estilo The Greg's) -->
<?php get_template_part('template-parts/home/dual-banners'); ?>

<!-- 8. Vitrine 2: Decants Exclusivos -->
<?php
get_template_part('template-parts/home/vitrine', null, array(
    'title'    => 'Decants Exclusivos (5ml, 10ml e 15ml)',
    'category' => 'decants-2',
    'limit'    => 8,
    'orderby'  => 'date',
    'link'     => home_url('/categoria-produto/decants-2/'),
    'is_alt'   => true,
));
?>

<!-- 9. Vitrine 3: Perfumes Lacrados & Frascos Completos -->
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

<!-- 10. FAQ de Objeções (Redução de Risco) -->
<?php get_template_part('template-parts/home/faq-objetions'); ?>

<!-- 11. Newsletter VIP (Estilo The Gregs) -->
<section class="cj-newsletter-section">
    <div class="cj-container">
        <div class="cj-newsletter-wrap">
            <div class="cj-newsletter-left">
                <span class="cj-newsletter-tag" style="color: var(--gregs-gold); font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; display: block; margin-bottom: 4px;">Comunidade Castejon</span>
                <h3>Ganhe 10% na primeira compra</h3>
                <p>Ao se cadastrar, você recebe seu cupom de 10% off + novidades, decants recém-chegados e kits temáticos no seu e-mail.</p>
            </div>
            <form class="cj-newsletter-form">
                <input type="email" placeholder="Seu melhor e-mail" required />
                <button type="submit">QUERO MEU 10% OFF</button>
            </form>
        </div>
    </div>
</section>

<?php
get_footer();


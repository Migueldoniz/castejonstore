<?php
/**
 * Search Results Template - Castejon Store
 */

get_header();
?>

<div class="cj-page-hero">
    <div class="cj-container">
        <h1 class="cj-page-title">
            Resultados para: "<?php echo get_search_query(); ?>"
        </h1>
        <p class="cj-page-desc">Confira os itens encontrados em nossa curadoria</p>
    </div>
</div>

<div class="cj-container" style="padding-top: 3.5rem; padding-bottom: 5rem;">
    <?php if (have_posts()) : ?>
        <div class="cj-products-grid">
            <?php
            while (have_posts()) : the_post();
                if (get_post_type() === 'product') {
                    get_template_part('template-parts/components/product-card', null, array(
                        'product_id' => get_the_ID(),
                    ));
                } else {
                    ?>
                    <div style="background: #fff; padding: 1.5rem; border: 1px solid var(--cj-border-light);">
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p><?php the_excerpt(); ?></p>
                    </div>
                    <?php
                }
            endwhile;
            ?>
        </div>
        <div style="margin-top: 3rem;">
            <?php the_posts_pagination(); ?>
        </div>
    <?php else : ?>
        <div style="text-align: center; padding: 4rem 1rem;">
            <h2 style="font-family: var(--font-serif); margin-bottom: 1rem;">Nenhum produto encontrado</h2>
            <p style="color: var(--cj-text-secondary); margin-bottom: 2rem;">Tente buscar por termos mais genéricos ou confira nossas categorias em destaque.</p>
            <a href="<?php echo esc_url(home_url('/loja/')); ?>" class="cj-btn cj-btn-primary">Ver Todos os Produtos</a>
        </div>
    <?php endif; ?>
</div>

<?php
get_footer();

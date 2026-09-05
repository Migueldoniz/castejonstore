<?php
/**
 * Index Template - Fallback padrão do tema
 */

get_header();
?>

<div class="cj-page-hero">
    <div class="cj-container">
        <h1 class="cj-page-title"><?php single_post_title(); ?></h1>
    </div>
</div>

<div class="cj-container" style="padding-top: 3.5rem; padding-bottom: 5rem;">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="margin-bottom: 2.5rem;">
                <h2 style="font-family: var(--font-serif); margin-bottom: 0.5rem;">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h2>
                <div><?php the_excerpt(); ?></div>
            </article>
            <?php
        endwhile;
        the_posts_pagination();
    else :
        echo '<p>Nenhum conteúdo encontrado.</p>';
    endif;
    ?>
</div>

<?php
get_footer();

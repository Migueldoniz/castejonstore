<?php
/**
 * Page Template - Castejon Store
 */

get_header();
?>

<?php if (!(function_exists('is_account_page') && is_account_page())) : ?>
<div class="cj-page-hero">
    <div class="cj-container">
        <h1 class="cj-page-title"><?php the_title(); ?></h1>
    </div>
</div>
<?php endif; ?>

<div class="cj-page-container <?php echo (function_exists('is_account_page') && is_account_page()) ? 'cj-account-page-wrap' : 'cj-default-page-wrap'; ?>">
    <?php
    while (have_posts()) :
        the_post();
        if (function_exists('is_account_page') && is_account_page()) {
            echo do_shortcode('[woocommerce_my_account]');
        } else {
            the_content();
        }
    endwhile;
    ?>
</div>

<?php
get_footer();

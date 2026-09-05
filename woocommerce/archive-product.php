<?php
/**
 * Archive Product (Catálogo / Categorias) - Castejon Store
 */

defined('ABSPATH') || exit;

get_header('shop');
?>

<div class="cj-page-hero">
    <div class="cj-container">
        <h1 class="cj-page-title">
            <?php woocommerce_page_title(); ?>
        </h1>
        <?php
        if (is_product_category()) {
            $cat_desc = category_description();
            if (!empty($cat_desc)) {
                echo '<div class="cj-page-desc">' . wp_kses_post($cat_desc) . '</div>';
            }
        }
        ?>
    </div>
</div>

<div class="cj-container">
    <div class="cj-catalog-layout">
        <!-- Sidebar de Categorias e Filtros -->
        <aside class="cj-catalog-sidebar" aria-label="Filtro do Catálogo">
            <div class="cj-sidebar-filter-block">
                <h3>Categorias</h3>
                <div class="cj-filter-list">
                    <a href="<?php echo esc_url(home_url('/categoria-produto/decants-2/')); ?>" class="<?php echo is_product_category('decants-2') ? 'is-active' : ''; ?>">Decants Premium</a>
                    <a href="<?php echo esc_url(home_url('/categoria-produto/perfumes/')); ?>" class="<?php echo is_product_category('perfumes') ? 'is-active' : ''; ?>">Perfumes Lacrados</a>
                    <a href="<?php echo esc_url(home_url('/categoria-produto/kits/')); ?>" class="<?php echo is_product_category('kits') ? 'is-active' : ''; ?>">Kits Degustação</a>
                    <a href="<?php echo esc_url(home_url('/categoria-produto/cosmeticos/')); ?>" class="<?php echo is_product_category('cosmeticos') ? 'is-active' : ''; ?>">Cosméticos</a>
                    <a href="<?php echo esc_url(home_url('/loja/')); ?>" class="<?php echo is_shop() && !is_product_category() ? 'is-active' : ''; ?>">Ver Todo o Catálogo</a>
                </div>
            </div>

            <?php
            $brands = get_terms(array(
                'taxonomy'   => 'product_brand',
                'hide_empty' => true,
                'number'     => 15,
            ));
            if (!empty($brands) && !is_wp_error($brands)) :
            ?>
                <div class="cj-sidebar-filter-block" style="margin-top: 25px;">
                    <h3>Marcas</h3>
                    <div class="cj-filter-list cj-brand-filter-list">
                        <?php foreach ($brands as $brand) : ?>
                            <a href="<?php echo esc_url(get_term_link($brand)); ?>" class="<?php echo is_tax('product_brand', $brand->term_id) ? 'is-active' : ''; ?>">
                                <span><?php echo esc_html($brand->name); ?></span>
                                <small style="opacity: 0.6; font-size: 0.75rem;">(<?php echo esc_html($brand->count); ?>)</small>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </aside>

        <!-- Grade de Produtos -->
        <main class="cj-catalog-products">
            <?php if (woocommerce_product_loop()) : ?>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <div style="font-size: 0.85rem; color: var(--cj-text-secondary);">
                        <?php woocommerce_result_count(); ?>
                    </div>
                    <div>
                        <?php woocommerce_catalog_ordering(); ?>
                    </div>
                </div>

                <div class="cj-products-grid">
                    <?php
                    while (have_posts()) {
                        the_post();
                        wc_get_template_part('content', 'product');
                    }
                    ?>
                </div>

                <div style="margin-top: 3.5rem;">
                    <?php woocommerce_pagination(); ?>
                </div>

            <?php else : ?>
                <div style="text-align: center; padding: 5rem 1rem;">
                    <p style="color: var(--cj-text-secondary); margin-bottom: 1.5rem;">Nenhum produto encontrado nesta categoria no momento.</p>
                    <a href="<?php echo esc_url(home_url('/loja/')); ?>" class="cj-btn cj-btn-primary">Ver Todos os Produtos</a>
                </div>
            <?php endif; ?>
        </main>
    </div>
</div>

<?php
get_footer('shop');

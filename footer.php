<?php
/**
 * Footer Template - Estilo The Greg's Exclusive
 */
if (!defined('ABSPATH')) {
    exit;
}
?>
</main><!-- #primary -->

<footer id="contato" class="cj-site-footer">
    <div class="cj-container">
        <div class="cj-footer-columns">
            <!-- 1. Sobre a Loja -->
            <div>
                <div style="margin-bottom: 16px;">
                    <?php if (function_exists('castejon_the_footer_logo')) { castejon_the_footer_logo(); } else { ?><span class="cj-logo-text" style="font-size: 1.35rem;">CASTEJON</span><?php } ?>
                </div>
                <p style="color: #888888; font-size: 0.85rem; line-height: 1.6; margin-bottom: 15px;">
                    Perfumes, Decants e Kits Exclusivos com envio para todo o Brasil.
                </p>
                <div style="color: #777777; font-size: 0.8rem;">
                    São Joaquim da Barra / SP · Brasil
                </div>
            </div>

            <!-- 2. Categorias -->
            <div>
                <h4 class="cj-footer-title">Categorias</h4>
                <div class="cj-footer-links-list">
                    <a href="<?php echo esc_url(home_url('/categoria-produto/perfumes/')); ?>">Perfumes</a>
                    <a href="<?php echo esc_url(home_url('/categoria-produto/decants-2/')); ?>">Decants</a>
                    <a href="<?php echo esc_url(home_url('/categoria-produto/kits/')); ?>">Kits</a>
                    <a href="<?php echo esc_url(home_url('/categoria-produto/cosmeticos/')); ?>">Cosméticos</a>
                    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">Loja Completa</a>
                </div>
            </div>

            <!-- 3. Atendimento -->
            <div>
                <h4 class="cj-footer-title">Atendimento</h4>
                <div class="cj-footer-links-list">
                    <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>">Minha Conta</a>
                    <a href="<?php echo esc_url(wc_get_cart_url()); ?>">Carrinho</a>
                    <?php 
                    $wa_num = get_theme_mod('castejon_whatsapp_number', '');
                    if ($wa_num) : ?>
                        <a href="<?php echo esc_url('https://wa.me/' . preg_replace('/[^0-9]/', '', $wa_num)); ?>" target="_blank" rel="noopener noreferrer">WhatsApp de Suporte</a>
                    <?php else : ?>
                        <a href="https://wa.me/5516999999999" target="_blank" rel="noopener noreferrer">WhatsApp de Suporte</a>
                    <?php endif; ?>
                    <a href="<?php echo esc_url(home_url('/politica-de-privacidade/')); ?>">Política de Privacidade</a>
                    <a href="<?php echo esc_url(home_url('/termos/')); ?>">Termos de Uso</a>
                </div>
            </div>

            <!-- 4. Redes Sociais & Segurança -->
            <div>
                <h4 class="cj-footer-title">Redes & Contato</h4>
                <div class="cj-footer-social">
                    <?php 
                    $insta_url = get_theme_mod('castejon_instagram_url', 'https://instagram.com/castejonstore');
                    $fb_url = get_theme_mod('castejon_facebook_url', 'https://facebook.com/castejonstore');
                    $email_contact = get_theme_mod('castejon_contact_email', 'contato@castejonstore.com');
                    ?>
                    <a href="<?php echo esc_url($insta_url); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                    </a>
                    <a href="<?php echo esc_url($fb_url); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                    </a>
                    <a href="<?php echo esc_url('mailto:' . sanitize_email($email_contact)); ?>" aria-label="E-mail">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    </a>
                </div>

                <div style="margin-top: 20px;">
                    <div style="font-size: 0.75rem; text-transform: uppercase; color: #777777; margin-bottom: 8px; letter-spacing: 0.06em;">Formas de Pagamento</div>
                    <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                        <span style="background: #2a2a2a; color: var(--gregs-gold); padding: 3px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 700;">PIX</span>
                        <span style="background: #2a2a2a; color: #ffffff; padding: 3px 8px; border-radius: 4px; font-size: 0.72rem;">Cartão de Crédito</span>
                        <span style="background: #2a2a2a; color: #ffffff; padding: 3px 8px; border-radius: 4px; font-size: 0.72rem;">Boleto</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="cj-footer-bottom-bar">
            <div class="cj-footer-bottom-inner">
                <div>
                    &copy; <?php echo date('Y'); ?> Castejon Store. São Joaquim da Barra / SP. Todos os direitos reservados.
                </div>
                <div>
                    Perfumaria de Nicho & Decants Exclusivos
                </div>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

<?php
/**
 * Login & Register Form - Castejon Theme
 */
if (!defined('ABSPATH')) {
    exit;
}

do_action('woocommerce_before_customer_login_form'); ?>

<div class="cj-login-register-container <?php echo ('yes' === get_option('woocommerce_enable_myaccount_registration')) ? 'has-register' : 'only-login'; ?>">
    <div class="cj-login-column">
        <div class="cj-auth-card">
            <div class="cj-auth-header">
                <h2>Acessar Conta</h2>
                <p>Entre com seu e-mail e senha cadastrados.</p>
            </div>

            <form class="woocommerce-form woocommerce-form-login login cj-auth-form" method="post">
                <?php do_action('woocommerce_login_form_start'); ?>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="username"><?php esc_html_e('E-mail ou nome de usuário', 'castejon-theme'); ?>&nbsp;<span class="required">*</span></label>
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" required />
                </p>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="password"><?php esc_html_e('Senha', 'castejon-theme'); ?>&nbsp;<span class="required">*</span></label>
                    <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" required />
                </p>

                <?php do_action('woocommerce_login_form'); ?>

                <div class="cj-auth-actions-row">
                    <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
                        <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e('Lembrar de mim', 'castejon-theme'); ?></span>
                    </label>
                    <a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="cj-lost-pwd-link"><?php esc_html_e('Esqueceu a senha?', 'castejon-theme'); ?></a>
                </div>

                <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                <button type="submit" class="woocommerce-button button woocommerce-form-login__submit cj-btn-gold" name="login" value="<?php esc_attr_e('Entrar', 'castejon-theme'); ?>">
                    <?php esc_html_e('Entrar na Conta', 'castejon-theme'); ?>
                </button>

                <?php do_action('woocommerce_login_form_end'); ?>
            </form>
        </div>
    </div>

    <?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>
        <div class="cj-register-column">
            <div class="cj-auth-card">
                <div class="cj-auth-header">
                    <h2>Criar Nova Conta</h2>
                    <p>Cadastre-se para acompanhar pedidos e ter acesso antecipado a novos decants.</p>
                </div>

                <form method="post" class="woocommerce-form woocommerce-form-register register cj-auth-form" <?php do_action('woocommerce_register_form_tag'); ?> >
                    <?php do_action('woocommerce_register_form_start'); ?>

                    <?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>
                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="reg_username"><?php esc_html_e('Nome de usuário', 'castejon-theme'); ?>&nbsp;<span class="required">*</span></label>
                            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" required />
                        </p>
                    <?php endif; ?>

                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="reg_email"><?php esc_html_e('Endereço de e-mail', 'castejon-theme'); ?>&nbsp;<span class="required">*</span></label>
                        <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo (!empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>" required />
                    </p>

                    <?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>
                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="reg_password"><?php esc_html_e('Senha', 'castejon-theme'); ?>&nbsp;<span class="required">*</span></label>
                            <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" required />
                        </p>
                    <?php else : ?>
                        <p class="cj-auth-notice"><?php esc_html_e('Um link para definir uma nova senha será enviado para o seu endereço de e-mail.', 'castejon-theme'); ?></p>
                    <?php endif; ?>

                    <?php do_action('woocommerce_register_form'); ?>

                    <p class="woocommerce-form-row form-row">
                        <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
                        <button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit cj-btn-gold" name="register" value="<?php esc_attr_e('Cadastrar', 'castejon-theme'); ?>">
                            <?php esc_html_e('Criar Conta Gratuita', 'castejon-theme'); ?>
                        </button>
                    </p>

                    <?php do_action('woocommerce_register_form_end'); ?>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php do_action('woocommerce_after_customer_login_form'); ?>

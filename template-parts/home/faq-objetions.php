<?php
/**
 * FAQ de Objeções - Redução de Risco (baseado nas avaliações reais do Google)
 * Responde às dúvidas que mais aparecem: autenticidade, decants, troca e envio.
 */
if (!defined('ABSPATH')) {
    exit;
}
$faq_items = array(
    array(
        'q' => 'Os produtos são originais?',
        'a' => 'Sim. Todo perfume é importado de fornecedores autorizados, lacrado e com código de autenticidade. Decants são fracionados de frascos 100% originais. Por isso, avaliamos 4,9 estrelas no Google com centenas de clientes comprovando: "produto original, chegou rapidinho".',
    ),
    array(
        'q' => 'O que é um decant e por que comprar?',
        'a' => 'É a fração do perfume original (5ml, 10ml ou 15ml) em frasco spray portátil. Perfeito para experimentar antes de investir no frasco grande, levar na bolsa ou testar até 3 fragrâncias pelo preço de uma.',
    ),
    array(
        'q' => 'E se eu não gostar do perfume?',
        'a' => 'Escolha o tamanho certo com o guia de decants: 5ml para teste, 10ml para rotação e 15ml para uso frequente. Avaliações reais confirmam: "comprei 3 decants, gostei dos 3" — mas se tiver dúvida, chame no WhatsApp antes de comprar e a gente te ajuda a escolher.',
    ),
    array(
        'q' => 'Quanto tempo demora a entrega?',
        'a' => 'Enviamos em até 24h úteis após a confirmação do pagamento, com rastreio enviado no seu e-mail. Frascos e decants vão em embalagem protegida para chegar intactos.',
    ),
);
?>
<section class="cj-faq-section" id="duvidas">
    <div class="cj-container">
        <div class="cj-faq-header">
            <span class="cj-faq-pretitle">Compra Sem Risco</span>
            <h2 class="cj-faq-title">Perguntas Frequentes</h2>
            <p class="cj-faq-subtitle">As dúvidas que mais recebemos — respondidas com transparência.</p>
        </div>

        <div class="cj-faq-list">
            <?php foreach ($faq_items as $index => $item) : ?>
                <details class="cj-faq-item" <?php echo 0 === $index ? 'open' : ''; ?>>
                    <summary class="cj-faq-question"><?php echo esc_html($item['q']); ?></summary>
                    <div class="cj-faq-answer"><?php echo wp_kses_post($item['a']); ?></div>
                </details>
            <?php endforeach; ?>
        </div>
    </div>
</section>
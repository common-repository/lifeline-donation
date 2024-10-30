<?php
    $html = wp_kses_allowed_html('post');
    $settings = wpcm_get_settings();
?>
<div class="lifeline-donation-modal donation-modal wpcm-wrapper footer-donation-modal">
    <lifeline-donation-modal-new v-if="showModalBox" :post_id="post_id" @closemodal="closePopup"></lifeline-donation-modal-new>
</div>

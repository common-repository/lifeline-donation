<?php $settings = wpcm_get_settings(); ?>

<div class="lifeline-donation-modal donation-modal3 wpcm-wrapper footer-donation-modal">
	<lifeline-donation-modal-new v-if="showModalBox" :post_id="post_id" @closemodal="closePopup"></lifeline-donation-modal-new>
</div>

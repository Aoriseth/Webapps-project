<script src="<?= base_url();?>assets/js/QR-code/qcode-decoder.min.js" type="text/javascript"></script>
<script src="<?= base_url();?>assets/js/QR-code/QRcodeRecog.js" type="text/javascript"></script>
<script> setBaseURL("<?= base_url();?>");</script>
<p class="txScale">
	<?= lang( 'login_camera_explanation' ) ?>
</p>

<p class="visible-sm visible-xs txScale">
	<?= lang( 'login_camera_scrolldown' ) ?>
</p>

<video id="camfr" width="90%" height="auto" autoplay="true">

</video>
<!--<script src="<?php echo base_url(); ?>assets/js/faceRecognition/capture.js" type="text/javascript"></script>-->
<canvas id = "canvasVideo" hidden="true" width="90%" height="auto" ></canvas>
<img id="photoFR" width="90%" height="auto" > 


<button class="btn-lg btn btn-default btn-raised" id="facialLoginButton"><?= lang( 'common_login' ) ?></button>
            
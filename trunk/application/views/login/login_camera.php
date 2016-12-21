<script src="<?= base_url();?>assets/js/QR-code/qcode-decoder.min.js" type="text/javascript"></script>
<script src="<?= base_url();?>assets/js/QR-code/QRcodeRecog.js" type="text/javascript"></script>
<script>setBaseURL("<?= base_url();?>");</script>

<p class="txScale">
	<?= lang( 'login_camera_explanation' ) ?>
</p>

<p span style="color:red" id="error_message_camera">
    &nbsp<!-- will be used to display error messages -->
</p>

<p class="visible-sm visible-xs txScale">
	<?= lang( 'login_camera_scrolldown' ) ?>
</p>

<video class="webcam" id="camfr" width="90%" height="auto" autoplay="true"></video>
    <canvas id = "canvasVideo" hidden="true" width="90%" height="auto"></canvas>
<img id="photoFR" width="90%" height="auto">

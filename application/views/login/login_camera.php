<script src="<?= base_url(); ?>assets/js/QR-code/qcode-decoder.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/js/QR-code/QRcodeRecog.js" type="text/javascript"></script>
<script>setBaseURL("<?= base_url(); ?>");</script>

<br>
<p class="txScale">
    <?= lang( 'login_camera_explanation' ) ?>
</p>

<p style="color:red" id="error_message_camera">
    <br><!-- will be used to display error messages -->
</p>

<p class="visible-sm visible-xs txScale">
    <?= lang( 'login_camera_scrolldown' ) ?>
</p>
<div>
    <video style="margin-bottom:-5px;" class="webcam" id="camfr" autoplay></video>  
</div>


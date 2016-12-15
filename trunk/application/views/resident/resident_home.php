<div style="padding-bottom: 30px" class="panel">
    <br>
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <form>
                <button data-toggle="popover" title="" data-container="body" style="background-color: #673AB7;width:100%;font-size:2.5vmax;"
                        class="btn-blue popup btn-lg withripple btn btn-raised btn-info"
                        data-content="<?= lang('r_button_test_help') ?>" 
                        formaction="<?= base_url() . 'index.php/resident/categories' ?>">
                            <?= lang('r_button_test') ?>
                </button>
            </form>
        </div>
    </div>
    <div>
    <script> loadPuzzle("<?= base_url() ?>");</script>
     <canvas class="center-block img-responsive" id="puzzle" style="height: 32vw;width:content-box"></canvas>
            <script> loadPuzzle( "<?php echo base_url()?>",
             <?php echo json_encode($path); ?> , <?php echo json_encode($puzzle); ?> , <?php echo json_encode($categories); ?>); </script>
    </div>
</div>

<?php if ($display_login_notification == true) { ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $.snackbar({content: '<?= lang('common_welcome_snackbar') ?>'});
        });
    </script>
<?php } ?>

<div class="panel">
        <div>
            <form>
                <button data-toggle="popover" title="" data-container="body" style="margin:0px;color: white;width:100%;height:2.5em;font-size:2.5vmax;"
                        class=" popup btn-lg btn accent"
                        data-content="<?= lang('r_button_test_help') ?>" 
                        formaction="<?= base_url() . 'index.php/resident/categories' ?>">
                            <?= lang('r_button_test') ?>
                </button>
            </form>
                
        </div>
    <div>
     <canvas class="center-block img-responsive" id="puzzle"></canvas>
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

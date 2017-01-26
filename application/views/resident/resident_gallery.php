<!-- Load  Unique scripts -->
        <script src="<?php echo base_url(); ?>assets/js/puzzle.js"></script>
        <script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/responsiveslides.js"></script>
<div data-placement="bottom" data-toggle="popover" title="" data-container="body" data-content="<?= lang('r_gallery_help') ?>" class="popup panel container-fluid">

    <script>
        $(function () {
            $("#slider").responsiveSlides({
                auto: false, // Boolean: Animate automatically, true or false
                speed: 0, // Integer: Speed of the transition, in milliseconds
                nav: true, // Boolean: Show navigation, true or false
                namespace: "large-btns" // String: Change the default namespace used
            });
        });
    </script>




    <ul class="rslides_container img-responsive" id="slider" style="list-style: none;">
        <li>
            <h2 id="no_pictures_message" style="font-size:3vmax;visibility: visible">
                <?= lang('r_gallery_empty') ?>
            </h2>
        </li>
    </ul>



    <script> loadGallery("<?php echo base_url() ?>", <?php echo json_encode($imgdata); ?>);</script>

</div>

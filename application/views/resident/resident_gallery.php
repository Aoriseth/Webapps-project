<!-- Load  Unique scripts -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/responsiveslides.js"></script>
<div data-placement="bottom" data-toggle="popover" title="" data-container="body" data-content="<?= lang('r_gallery_help') ?>" class="popup panel container-fluid">

    <script>
        $(function () {
            $("#slider").responsiveSlides({
                auto: false, // Boolean: Animate automatically, true or false
                speed: 500, // Integer: Speed of the transition, in milliseconds
                pager: false, // Boolean: Show pager, true or false
                nav: true, // Boolean: Show navigation, true or false
                namespace: "large-btns" // String: Change the default namespace used
            });
        });
    </script>




    <ul class="rslides_container img-responsive" id="slider">

        <h2 id="no_pictures_message" style="font-size:3vmax;visibility: visible">
            <?= lang('r_gallery_empty') ?>
        </h2>

    </ul>



    <script> loadGallery("<?php echo base_url() ?>", <?php echo json_encode($imgdata); ?>);</script>

</div>

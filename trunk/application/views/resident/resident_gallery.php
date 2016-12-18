<div data-placement="bottom" data-toggle="popover" title="" data-container="body" data-content="<?= lang( 'r_gallery_help' ) ?>" class="popup panel container-fluid">
    <br>
    <p class="txScale">
        <?= lang('r_gallery_explanation') ?>
    </p>
    
    <div>
     <canvas class="center-block img-responsive" id="gallery"></canvas>
            
            <script> loadGallery("<?php echo base_url()?>",
             <?php echo json_encode($path); ?> , <?php echo json_encode($puzzle); ?> ); </script>
    </div>
    
    <br>
</div>
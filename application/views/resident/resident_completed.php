<script src="<?php echo base_url(); ?>assets/js/puzzle.js"></script>

<div class="fire container-fluid panel ">
    <div class=" ">
        <div class="container-fluid row">
            <br>
            <p class="txScale">
                <?= lang('r_completed_explanation') ?>
            </p><hr>
        </div>
        <div class="tip">
            <p class="tlScale">
				<?= lang( 'r_completed_here_is_tip' ) ?>
            </p>
            <blockquote>
                <p class="txScale">
                        <i>{tip}</i>
                </p>
            </blockquote>
            
            <p class="tlScale">
                <?= lang( 'r_completed_here_is_puzzle_piece' ) ?>
            </p>
           <canvas class="center-block img-responsive" id="puzzle"></canvas>
            <script> loadPuzzlePiece( "<?php echo base_url()?>",
             <?php echo json_encode($path); ?> , <?php echo json_encode($puzzle); ?> , <?php echo json_encode($setID); ?>); </script>


        </div> <br>
    </div>

    <div class="row">
        <div class="pull-left">
            <form action=<?php echo base_url() . 'index.php/resident/categories' ?> method="POST">
                <input class="btn btn-lg btn-default" type="submit" name="Categories" value="<?= lang('r_completed_start_new') ?>" style="size: 100%;color:#673AB7">
            </form>
        </div>

        <div class="pull-right">
            <form action=<?php echo base_url() . 'index.php/resident/home' ?> method="POST">
                <input class="btn btn-lg btn-default" type="submit" name="Categories" value="<?= lang( 'r_completed_go_puzzle' ) ?>" style="size: 100%;color:#673AB7">
            </form>
        </div>
    </div>
</div>

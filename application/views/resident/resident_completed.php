<div class="container-fluid panel ">
    <div class="container-fluid row">
        <br>
        <p class="txScale">
            <?= lang('r_completed_explanation') ?>
        </p><br>
    </div>
    <div class="row">
        <div class="col-xs-3">
			{hint}
            <form action=<?php echo base_url() . 'index.php/resident/categories' ?> method="POST">
                <input class="btn btn-raised btn-default" type="submit" name="Categories" value="<?= lang('r_completed_start_new') ?>" style="size: 100%">
            </form>
            <br>
        </div>
    </div>
</div>

<div class="container-fluid panel ">
    <div class="container-fluid row">
        <br>
        <p class="tlScale">
            <?= lang('r_completed_explanation') ?>
        </p><hr>
    </div>
	<div class="tlScale tip">
            <blockquote>
                <i>
                    {tip}
                </i>
            </blockquote>
		
               
	</div> <br>
    <div class="row">
        <div class="col-xs-3">
            <form action=<?php echo base_url() . 'index.php/resident/categories' ?> method="POST">
                <input class="btn btn-lg btn-default" type="submit" name="Categories" value="<?= lang('r_completed_start_new') ?>" style="size: 100%;color:#673AB7">
            </form>
            <br>
        </div>
    </div>
</div>

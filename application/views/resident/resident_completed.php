<div class="well container-fluid">
	<div class=" container row">
		<p>
			<?= lang( 'resident_completed_explanation' ) ?>
		</p>
	</div>
	<div class="row">
		<div class="col-xs-3">
			<form action=<?php echo base_url().'index.php/resident/categories' ?> method="POST">
				<input class="btn btn-raised btn-default" type="submit" name="Categories" value="<?= lang( 'resident_completed_start_new' ) ?>" style="size: 100%">
			</form>
		</div>
	</div>
</div>

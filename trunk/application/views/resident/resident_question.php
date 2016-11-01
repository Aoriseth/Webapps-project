<p>
	{question}
</p>

<?php foreach( $options as $option) { ?>

	<form action="<?php echo base_url().'index.php/resident/question?category='.$category.'&index='.($index+1) ?>" method="POST">
		<input type="submit" name="option" value="<?php echo htmlspecialchars( $option->option ) ?>">
	</form>

<?php } ?>

<p>
	Question <?php echo $index+1 ?> of {category_size} from {category}.
</p>

<?php if ( $index > 0 ) { ?>

	<form action="<?php echo base_url().'index.php/resident/question?category='.$category.'&index='.($index-1) ?>" method="POST">
		<input type="submit" name="back" value="Go back">
	</form>

<?php } ?>
<p>
	<i>Currently showing english categories, dutch categories are also easily accesible from the database.</i><br>
	<i>No check if category is completed yet.</i>
</p>

<p>
	Select a category:
</p>

<?php foreach( $categories as $category ) { ?>

	<form action="<?php echo base_url().'index.php/resident/question' ?>" method="GET">
		<input type="submit" name="category" value="<?php echo $category->category ?>">
	</form>

<?php } ?>

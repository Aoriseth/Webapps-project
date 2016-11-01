<p>
	Hello {name}.
</p>

<p>
	<i>The gallery contains the completed puzzles.</i>
</p>

<form action=<?php echo base_url().'index.php/resident/gallery' ?> method="POST">
	<input type="submit" name="Gallery" value="View gallery">
</form>

<p>
	<i>There will be a large image of the incomplete puzzle here.</i>
</p>

<form action=<?php echo base_url().'index.php/resident/categories' ?> method="POST">
	<input type="submit" name="Categories" value="Start a new test!">
</form>

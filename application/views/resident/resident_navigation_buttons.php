<!-- I am currently on page '{page}' -->

<form action=<?php echo base_url() ?> method="POST">
    <input class="btn btn-raised btn-default" type="submit" name="home" value="Home" style="width: 100%">
	<?php if ( $page == 'home' ) { ?>
		<!-- This comment appears when you are on the home page -->
	<?php } ?>
</form>

<form action=<?php echo base_url().'index.php/logout' ?> method="POST">
    <input class="btn btn-raised btn-default" type="submit" name="logout" value="Logout" style="width: 100%">
</form>


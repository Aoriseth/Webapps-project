<!--
	These buttons are exactly the same as resident_navigation_buttons.php.
	Refactor it so both sides use the same file, store it in views/common?

	Let me know if this is useful and I'll update all the controllers.
	 - Koenraad
-->

<form action=<?php echo base_url() ?> method="POST">
    <input class="btn btn-primary" type="submit" name="home" value="Home">
</form>

<form action=<?php echo base_url().'index.php/logout' ?> method="POST">
    <input class="btn btn-primary" type="submit" name="logout" value="Logout">
</form>

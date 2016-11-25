<!--
	These buttons are exactly the same as resident_navigation_buttons.php.
	Refactor it so both sides use the same file, store it in views/common?

	Let me know if this is useful and I'll update all the controllers.
	 - Koenraad

	If this isn't useful. Just delete this comment.


        Re-using existing code is always useful, but we might want to use 
        different styling for the buttons of the resident. (bigger, etc)
        Maybe refactor to one view and load a different css in resident_main
        and caregiver_main?
         - Lennart
-->

<!-- I am currently on page '{page}' -->
<div class="">
    <form action=<?php echo base_url() ?> method="POST">
        <input <?php if ( $page == 'home' ) { ?>disabled<?php } ?> style="width: 100%" class="btn btn-raised btn-default" type="submit" name="home" value="Home">
    </form>

    <form action=<?php echo base_url().'index.php/logout' ?> method="POST">
        <input style="width: 100%" class="btn btn-raised btn-warning" type="submit" name="logout" value="Logout">
    </form>
</div>

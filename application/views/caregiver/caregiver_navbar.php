

<!-- I am currently on page '{page}' -->

<form action="overview" method="POST">
    <input <?php if ( $page == 'overview' ) { ?>disabled<?php } ?> class="btn btn-primary" type="submit" name="resident" value="Resident overview">
	<?php if ( $page == 'overview' ) { echo ' &lt-- current page'; } ?>
</form>

<form action="groups" method="POST">
    <input <?php if ( $page == 'groups' ) { ?>disabled<?php } ?> class="btn btn-primary" type="submit" name="groups" value="Group selection">
	<?php if ( $page == 'groups' ) { echo ' &lt-- current page'; } ?>
</form>

<form action="statistics" method="POST">
    <input <?php if ( $page == 'statistics' ) { ?>disabled<?php } ?> class="btn btn-primary" type="submit" name="statistics" value="Statistics">
	<?php if ( $page == 'statistics' ) { echo ' &lt-- current page'; } ?>
</form>

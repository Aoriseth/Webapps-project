

<!-- I am currently on page '{page}' -->

<nav class="navbar navbar-fixed-top navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand">
                Grace Age</a>
        </div>
    </div>
</nav>




<div class="well">
    <form  action="overview" method="POST">
    <input <?php if ( $page == 'overview' ) { ?>disabled<?php } ?> class="btn btn-raised btn-default" type="submit" name="resident" value="Resident overview">
	<?php if ( $page == 'overview' ) { echo ' &lt-- current page'; } ?>
</form>

    <form action="groups" method="POST">
    <input <?php if ( $page == 'groups' ) { ?>disabled<?php } ?> class=" btn btn-raised btn-default" type="submit" name="groups" value="Group selection">
	<?php if ( $page == 'groups' ) { echo ' &lt-- current page'; } ?>
</form>

    <form  action="statistics" method="POST">
    <input <?php if ( $page == 'statistics' ) { ?>disabled<?php } ?> class=" btn btn-raised btn-default" type="submit" name="statistics" value="Statistics">
	<?php if ( $page == 'statistics' ) { echo ' &lt-- current page'; } ?>
</form>
</div>

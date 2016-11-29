<!-- I am currently on page '{page}' -->
<form>
    <button style="width: 100%" <?php if ( $page == 'home' ) { ?>disabled<?php } ?> class=" btn-lg withripple btn btn-raised btn-default" formaction="<?php echo base_url() . 'index.php/resident/home' ?>">Home</button>
</form>

<form>
    <button style="width: 100%" class=" btn-lg withripple btn btn-raised btn-warning" formaction="<?php echo base_url() . 'index.php/logout' ?>">Logout</button>
</form>

<div class="jumbotron">
    
    <form>
    <button <?php if ( $page == 'facial_recognition' ) { ?>disabled<?php } ?> class="withripple btn btn-raised btn-default" formaction="<?php echo base_url() . 'index.php/login/facial_recognition' ?>">Log in using facial recognition</button>
    </form>
    
    <form>
    <button <?php if ( $page == 'manual' ) { ?>disabled<?php } ?> class="withripple btn btn-raised btn-default" formaction="<?php echo base_url() . 'index.php/login/manual' ?>">Log in manually</button>
    </form>

<div>

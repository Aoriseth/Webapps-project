

<!-- I am currently on page '{page}' -->

<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Grace Age</a>
        </div>
        <div class="navbar-collapse collapse navbar-responsive-collapse">
            <ul class="nav navbar-nav">
                <li <?php if ( $page == 'home' ) { ?>class="active"<?php } ?> ><a href="<?php echo base_url() . 'index.php/caregiver/home' ?>">Home</a></li>
                <li <?php if ( $page == 'overview' ) { ?>class="active"<?php } ?>><a href="<?php echo base_url() . 'index.php/caregiver/overview' ?>">Resident Overview</a></li>
                <li <?php if ( $page == 'groups' ) { ?>class="active"<?php } ?>><a href="<?php echo base_url() . 'index.php/caregiver/groups' ?>">Group Selection</a></li>
                <li <?php if ( $page == 'statistics' ) { ?>class="active"<?php } ?>><a href="<?php echo base_url() . 'index.php/caregiver/statistics' ?>">Statistics</a></li>
            </ul>
            
            <ul class="nav navbar-nav navbar-right">
                    <li><a href="<?php echo base_url() . 'index.php/logout' ?>">LOGOUT</a></li>
            </ul>
        </div>
            
                

        </div>
    </div>






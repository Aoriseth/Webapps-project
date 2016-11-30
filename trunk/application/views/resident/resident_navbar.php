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
                <li <?php if ( $page == 'home' ) { ?>class="active"<?php } ?> ><a href="<?php echo base_url() . 'index.php/resident/home' ?>">Home</a></li>
                <li <?php if ( $page == 'gallery' ) { ?>class="active"<?php } ?>><a href="<?php echo base_url() . 'index.php/resident/gallery' ?>">Gallery</a></li>
            </ul>
            
            <ul class="nav navbar-nav navbar-right">
                    <li><a href="<?php echo base_url() . 'index.php/logout' ?>">LOGOUT</a></li>
                    <li><a></a></li>
                      
                    <li><a href="#"><span class="glyphicon glyphicon-user"></span></a></li>
            </ul>
        </div>
            
                

        </div>
    </div>



<!--            <span class="glyphicon glyphicon-user" aria-hidden="true" style="position: absolute" style="right: 1px"></span>
            </ul>-->




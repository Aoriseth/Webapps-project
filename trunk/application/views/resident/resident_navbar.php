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
                <li <?php if ( $page == 'home' ) { ?>class="active"<?php } ?> ><a href="<?php echo base_url() . 'index.php/resident/home' ?>"><?= lang( 'resident_navbar_home' ) ?></a></li>
                <li data-placement="bottom" data-toggle="popover" title="" data-container="body" data-content="<?= lang( 'resident_navbar_gallery_help' ) ?>" class="popup <?php if ( $page == 'gallery' ) { ?>active<?php } ?>" ><a href="<?php echo base_url() . 'index.php/resident/gallery' ?>"><?= lang( 'resident_navbar_gallery' ) ?></a></li>
            </ul>
            
            <ul class="nav navbar-nav navbar-right">
                    <li><a href="<?php echo base_url() . 'index.php/logout' ?>"><?= lang( 'common_logout' ) ?></a></li>
                    <li><a></a></li>
                      
                    <li><a href="#"><span class="glyphicon glyphicon-user"></span></a></li>
            </ul>
        </div>
            
                

        </div>
    </div>



<!--            <span class="glyphicon glyphicon-user" aria-hidden="true" style="position: absolute" style="right: 1px"></span>
            </ul>-->




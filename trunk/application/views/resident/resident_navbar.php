<!-- I am currently on page '{page}' -->
<div class="navbar navbar-inverse navbar-fixed-top" style="background-color: #512DA8">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" ><?= lang('common_app') ?></a>
        </div>
        <div class="navbar-collapse collapse navbar-responsive-collapse">
            <ul class="nav navbar-nav">
                <li <?php if ($page == 'home') { ?>class="active"<?php } ?> ><a href="<?php echo base_url() . 'index.php/resident/home' ?>"><?= lang('r_navbar_home') ?></a></li>
                <li data-placement="bottom" data-toggle="popover" title="" data-container="body" data-content="<?= lang('r_navbar_gallery_help') ?>" class="popup <?php if ($page == 'gallery') { ?>active<?php } ?>" ><a href="<?php echo base_url() . 'index.php/resident/gallery' ?>"><?= lang('r_navbar_gallery') ?></a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a style="color:#FF5722" id="trigger" href="#"><?= lang('r_button_help') ?></a></li>
                <li><a href="<?php echo base_url() . 'index.php/logout' ?>"><?= lang('common_logout') ?></a></li>
                <li><a href="#"><span class="glyphicon glyphicon-user"></span></a></li>
            </ul>
        </div>



    </div>
</div>
<div style="top:0px;height:250px;width:100%;background-color: #673ab7;position:absolute;">
    
</div>



<!--            <span class="glyphicon glyphicon-user" aria-hidden="true" style="position: absolute" style="right: 1px"></span>
            </ul>-->




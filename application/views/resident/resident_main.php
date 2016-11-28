<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Grace Age: Resident</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Load CSS -->
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap-material-design.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/ripples.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/main.css">

        <!-- Load scripts -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/material.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/ripples.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/puzzle.js"></script>

        <!-- Activate Material Design -->
        <script>$.material.init();</script>

    </head>
    
    <body>
        {navbar}
        <div class="container" id="container_resident">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-xs-10 col-sm-10 col-xs-offset-1 col-md-offset-0" >
                    
                    <div class="well">
                        <form>
                            <button <input <?php if ( $page == 'gallery' ) { ?>disabled<?php } ?>  style="width: 100%" class="btn-lg withripple btn btn-raised btn-default" formaction="<?php echo base_url() . 'index.php/resident/gallery' ?>">View gallery</button>
                        </form>
                        <hr>
                    {navigation_buttons}
                    
                    </div>
                </div>
                <div class="col-lg-10 col-md-10 col-xs-10 col-sm-10 col-xs-offset-1 col-md-offset-0">
                    <!--div class="jumbotron"-->       
                    <div>
                    {content}	
                    </div> <!-- the main element of the page (login form etc) -->
                    <!--/div-->
                </div>
            </div>

        </div>
    </body>
</html>

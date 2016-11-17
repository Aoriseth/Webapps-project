<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Grace Age: Resident</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Load CSS -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/main.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap-material-design.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/ripples.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

        <!-- Load scripts -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/material.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/ripples.js"></script>

        <!-- Activate Material Design -->
        <script>$.material.init();</script>

    </head>
    
    <body>
        {navbar}
        <div class="container" id="container_resident">
            <div class="row">
                <div class="col-xs-2" >
                    <form action=<?php echo base_url() . 'index.php/resident/gallery' ?> method="POST" class="text-center">
                        <input class="btn btn-primary" type="submit" name="Gallery" value="View gallery" style="width: 100%">
                    </form>
                </div>
                <div class="col-xs-8">
                    <!--div class="jumbotron"-->       
                    {content}		<!-- the main element of the page (login form etc) -->
                    <!--/div-->
                </div>
                <div class="col-xs-2">
                    {navigation_buttons}
                </div>
            </div>

        </div>
    </body>
</html>

<!DOCTYPE html>

<html lang="en">
    <head> 
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Grace-Age : Caregiver Home</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/main.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="<?php echo base_url(); ?>assets/datatables/css/dataTables.bootstrap.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap-material-design.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/ripples.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/snackbar.css">

        <!-- Load scripts -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/material.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/ripples.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/statistics/chartCallbacks.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/snackbar.min.js"></script>

        <!-- Activate Material Design -->
        <script>$.material.init();</script>
        <!--	HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--	 WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--	[if lt IE 9]>
                          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
                        <![endif]-->
    </head> 
    <body>
        {navbar}

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-offset-1 col-md-10">
                    <div class="jumbotron">
                        {content}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

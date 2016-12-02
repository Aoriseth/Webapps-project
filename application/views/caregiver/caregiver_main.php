<!DOCTYPE html>
<html lang="en">
    <head> 
        <meta charset="utf-8">
        
        <title>Grace-Age : Caregiver Home</title>
        
        <!--Load unique css-->
        <link href="<?php echo base_url(); ?>assets/datatables/css/dataTables.bootstrap.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet">
        
        <!-- Load unique scripts -->
        <script src="<?php echo base_url(); ?>assets/js/statistics/chartCallbacks.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        {include}
        

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

<!--Activate material design-->
<script>$.material.init();</script>
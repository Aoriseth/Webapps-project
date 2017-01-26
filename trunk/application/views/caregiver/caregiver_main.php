<!DOCTYPE html>
<html lang="en">
    <head> 
        <title><?= lang('c_title') ?></title>

        <!--Include common scripts and css-->
        {include}

        <!--Load unique css-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/datatables/css/dataTables.bootstrap.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker3.min.css"/>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/datatables-colvis/1.1.2/css/dataTables.colVis.css"/>

        <!-- Load unique scripts -->
        <script src="<?php echo base_url(); ?>assets/js/statistics/chartCallbacks.js"></script>

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


    </head> 
    <body>

        {navbar}
        <br>
        <br>
        
        <div class="row">
            <div class="col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0">
                
                    {content}
                
            </div>
        </div>

        <!--Activate material design-->
        <script>$.material.init();</script>

    </body>
</html>


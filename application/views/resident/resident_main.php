<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Grace Age: Resident</title>
       {include}

        <!-- Load scripts -->
        
        <script src="<?php echo base_url(); ?>assets/js/puzzle.js"></script>

    </head>
    
    <body>
        {navbar}
        <div class="container" id="container_resident">
            
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <!--div class="jumbotron"-->       
                    <div>
                    {content}	
                    </div> <!-- the main element of the page (login form etc) -->
                    <!--/div-->
                </div>
            </div>
            
        </div>
        
        <!--<a class="btn btn-warning btn-raised" style="height:3em;width:7em;position:fixed;bottom:30px;right:30px;" href="#">HELP</a>-->
    </body>
</html>

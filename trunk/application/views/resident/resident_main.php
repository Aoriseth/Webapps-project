<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Grace Age: Resident</title>
        <!--Include common scripts and css-->
        {include}
        <!-- Load  Unique scripts -->
        <script src="<?php echo base_url(); ?>assets/js/puzzle.js"></script>
    </head>

    <body>
        <!--Navigation bar of this page-->
        {navbar}
        
        <!-- the main element of the page (puzzle, etc) -->
        <div class="container" id="container_resident">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div>
                        
                        {content}	
                    </div> 
                </div>
            </div>
        </div>

        <!--Help button for resident pages-->
        <button id="trigger" class="btn btn-warning btn-raised" style="height:3em;width:7em;position:fixed;bottom:30px;right:30px;">
            <?= lang('resident_button_help') ?>
        </button>
    </body>
</html>

<!-- Javascripting-->
<script>
    $(document).ready(function () {
        $('#trigger').click(function (event) {
            $('.popup').popover('toggle');
            event.stopPropagation();
        });

        $(window).click(function () {
            //Hide the menus if visible
            $('.popup').popover('hide');
        });
    });
</script>
<script>$.material.init();</script>

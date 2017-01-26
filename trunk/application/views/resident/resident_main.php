<!DOCTYPE html>

<html lang="en">
    <head>
        <title><?= lang( 'r_title' ) ?></title>

        <!--Include common scripts and css-->
        {include}

    </head>
    <body>
        <!--Navigation bar of this page-->
        {navbar}
        <br>
        <br>

        <!-- the main element of the page (puzzle, etc) -->
        <div class="container" id="container_resident">
            <div class="row">
                <div class="col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0">
                    <div>

                        {content}	

                    </div> 
                </div>
            </div>
        </div>

        <!-- Javascript -->
        <script>
            $( document ).ready( function () {
                $( '#trigger' ).click( function ( event ) {
                    $( '.popup' ).popover( 'toggle' );
                    event.stopPropagation();
                });

//              $( '#trigger' ).click( function ( event ) {
//                  $( '.important' ).effect( 'shake', 1500 );
//                  $( ".important" ).dialog( { modal: true } );
//              });

                $( window ).click( function () {
                    // Hide the menus if visible
                    $( '.popup' ).popover( 'hide' );
                });
            });
        </script>
        <script>$.material.init();</script>

    </body>

</html>


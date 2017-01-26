<!DOCTYPE html>

<html lang="en">
    <head>
        <title><?= lang( 'login_title' ) ?></title>

        {include}

    </head>
    <body>
        {navbar}
        <br><br>
        <div class="container">
            <div class="row">
                <div class=" col-md-6 text-center">
                    <div class="panel" >

                        {camera}

                    </div>
                </div>
                <div class=" col-md-6">
                    <div class="panel container-fluid">
                        <br>

                        {manual}

                        <br>
                    </div>
                </div>
            </div>
        </div>

        <script>$.material.init();</script>

    </body>

</html>

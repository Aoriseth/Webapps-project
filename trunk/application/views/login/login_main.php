<!DOCTYPE html>

<html lang="en">
    <head>
        <title><?= lang( 'login_title' ) ?></title>

        {include}
    </head>
    <body>
        {navbar}

        <div class="container">
            <div class="row">
                <div class=" col-md-6 text-center">
                    <div class=" panel container-fluid">
                        <br>
                        {camera}
                        <br>
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
    </body>
</html>

<script>$.material.init();</script>

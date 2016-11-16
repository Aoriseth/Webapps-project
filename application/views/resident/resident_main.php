<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Grace Age: Resident</title>
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
                <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	        <link href=<?php echo base_url()."assets/css/main.css" ?> rel="stylesheet" type="text/css"/>

        </head>
	<body>
		{navbar}
                <div class="container">
                    <div class="row">
                        <div class="col-xs-2" >
                            <form action=<?php echo base_url().'index.php/resident/gallery' ?> method="POST" class="text-center">
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

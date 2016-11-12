<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Grace Age: Resident</title>
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	        <link href=<?php echo base_url()."assets/css/main.css" ?> rel="stylesheet" type="text/css"/>

        </head>
	<body>
		{navbar}
                <div class="container">
                    <div class="row">
                        <div class="col-lg-2" >
                            <form action=<?php echo base_url().'index.php/resident/gallery' ?> method="POST" class="text-center">
                                <input class="btn btn-primary" type="submit" name="Gallery" value="View gallery">
                            </form>
            <p>
                <i>The gallery contains the completed puzzles.</i>
            </p>
                        </div>
                        <div class="col-lg-8">
                            <div class="jumbotron">
                                {content}		<!-- the main element of the page (login form etc) -->

                                <hr />

                                
                            </div>
                        </div>
                        <div class="col-lg-2">
                            {navigation_buttons}
                        </div>
                    </div>
                    
                </div>
	</body>
</html>

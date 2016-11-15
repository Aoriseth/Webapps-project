<!DOCTYPE html>

<html lang="en">
    
	<head>
		<meta charset="UTF-8">
                <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/main.css">
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
                <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap-material-design.css">
                <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/ripples.css">
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
                <script src="<?php echo base_url(); ?>assets/js/material.js"></script>
                <script src="<?php echo base_url(); ?>assets/js/ripples.js"></script>
                 
		<title>Grace Age: Login</title>
                
                <script>
                        $.material.init();
                </script>
	</head>
	<body>
            {navbar}
            <div class="container">
		 <div class="jumbotron">
                <p>
			{feedback}	<!-- used to dispay error notifications, is often empty -->
		</p>

		{content}		<!-- the main element of the page (login form etc) -->

		<hr />

		{navigation_buttons}
                </div>
            </div>
	</body>
</html>

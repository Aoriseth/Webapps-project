<!DOCTYPE html>

<html lang="en">
	<head> 
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Grace-Age : Caregiver Home</title>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/main.css">
		<link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>assets/datatables/css/dataTables.bootstrap.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet">
                <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap-material-design.css">
                <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/ripples.css">
                
                <!-- Load scripts -->
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
                <script src="<?php echo base_url(); ?>assets/js/material.js"></script>
                <script src="<?php echo base_url(); ?>assets/js/ripples.js"></script>
                <script src="<?php echo base_url(); ?>assets/js/FRLambdaAPI.js"></script>
                 <!-- Activate Material Design -->
                <script>$.material.init();</script>
<!--	HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--	 WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--	[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
    </head> 
	<body>
		<div>
			{navbar}
		</div>

		<hr />

		<div class="container">
			{content}
		</div>

		<hr />

		<div>
			{navigation_buttons}
		</div>

	</body>
</html>

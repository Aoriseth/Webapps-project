<script src="<?php echo base_url(); ?>assets/js/login.js" type="text/javascript"></script>
<script>
$( function() {
	$( "#login_form" ).submit( function( event ) {
		login( '<?php echo base_url() ?>' );
		return false;
	});
});
</script>

<div>
	<p>
		Log in by manually typing your username and password.
	</p>

	<p span style="color:red" id="error_message">
	</p>

	<form method="POST" id="login_form">
		<div class="container-fluid">
			<div class="form-group label-floating">
				<label class="control-label" for="focusedInput1">Username</label>
				<input class="form-control" name="username" id="focusedInput1" required autofocus type="text">
			</div>
			<div class="form-group label-floating">
				<label class="control-label" for="focusedInput2">Password</label>
				<input class="form-control" name="password" id="focusedInput2" required type="password">
			</div>
		
			<input class="btn btn-lg btn-raised btn-default" type="submit" name="login" value="Log in">
		</div>
	</form>
</div>

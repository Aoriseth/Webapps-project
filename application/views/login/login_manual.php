<script type="text/javascript">
$( function() {

	$( "#login_form" ).submit( function( event ) {
		var username = $( '#login_form input[ name = username ]').val();
		var password = $( '#login_form input[ name = password ]').val();

		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>index.php/login/ajax", 
			data: {
				username: username,
				password: password
			},
			dataType: "text",
			cache: false,

			success: function( data ) {
				var response = JSON.parse( data );
				if ( response[ 'success' ] ) {
					// redirect to home page
					window.location = '<?php base_url() ?>';
				} else {
					// display error message
					$( '#error_message' ).html( response[ 'error' ] );
				}
			}
		});
		return false;
	});
});
</script>

<div class="jumbotron">
	<p>
		Log in by manually typing your username and password.
	</p>

	<p span style="color:red" id="error_message">
	</p>

	<form method="POST" id="login_form">
		<div class="container-fluid">
			<div class="form-group label-floating">
				<label class="control-label" for="focusedInput1">Username</label>
				<input class="form-control" name="username" id="focusedInput1" required type="text">
			</div>
			<div class="form-group label-floating">
				<label class="control-label" for="focusedInput1">Password</label>
				<input class="form-control" name="password" id="focusedInput1" required type="password">
			</div>
		</div>
		<div class="container">
			<input class="btn btn-lg btn-raised btn-default" type="submit" name="login" value="Log in">
		</div>
	</form>
</div>


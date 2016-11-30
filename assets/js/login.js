function login( base_url, username, password ) {
	var url = base_url + 'index.php/login/ajax';

	$.ajax({
		type: "POST",
		url: url,
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
				window.location = base_url;
			} else {
				// display error message
				$( '#error_message' ).html( response[ 'error' ] );
				// return focus to username
				$( '#login_form input[ name = username ]').focus();
			}
		}
	});
}


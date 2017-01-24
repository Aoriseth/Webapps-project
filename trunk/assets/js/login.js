function login( base_url, username, password, error_feedback, from_camera, login_failed_callback = null ) {

    var url = base_url + 'index.php/login/ajax';
    var videoBoolean = ( from_camera ? 'true' : 'false' );

    //console.log( 'login attempt: ' + username + ' / ' + password + ( from_camera ? ' from camera' : '' ) )
    // ajax request
    $.ajax({
        type: "POST",
        url: url,
        data: {
            "username": username,
            "password": password,
            "video": videoBoolean
        },
        dataType: "text",
        cache: false,
    })
        .done( function ( data ) {
            
            try {
                var response = JSON.parse( data );
            } catch ( err ) {
                //console.log( 'AJAX response raw: ' + data );
                //console.log( 'JSON parse failed: ' + err );
                error_feedback.html( 'Couldn\'t process answer from server.' );
                return;
            }
            //console.log( 'AJAX response: ' + JSON.stringify( response ) );

            if (response[ 'success' ]) {
                //console.log( 'login success' );
                // redirect to home page
                window.location = base_url;
            } else {
                console.log( 'login failed: ' + response[ 'error' ] );
                // display what's wrong
                error_feedback.html(response[ 'error' ]);
                // return focus to username
                if ( ! from_camera ) {
                    $('#login_form input[ name = username ]').focus();
                }
                // notify caller
                if ( login_failed_callback ) {
                    login_failed_callback();
                }
            }
        })
        .fail( function ( jqXHR, textStatus, errorThrown ) {
            console.log( 'AJAX error: ' + errorThrown );
            // display error message
            error_feedback.html( 'Error connecting to server: ' + errorThrown );
        });
}

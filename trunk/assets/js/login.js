function login( base_url, username, password, error_feedback, from_camera ) {

    var url = base_url + 'index.php/login/ajax';
    var videoBoolean = ( from_camera ? 'true' : 'false' );

    console.log( 'login attempt: ' + username + ' / ' + password + ( from_camera ? ' from camera' : '' ) )

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
            var response = JSON.parse( data );
            console.log( 'AJAX response: ' + JSON.stringify( response ) );

            if (response[ 'success' ]) {
                console.log( 'login success' );
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
            }
        })
        .fail( function ( jqXHR, textStatus, errorThrown ) {
            console.log( 'AJAX error: ' + errorThrown );
            // display error message
            error_feedback.html( 'Error connecting to server: ' + errorThrown );
        });
}

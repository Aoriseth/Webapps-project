var videoBoolean = null;
function login(base_url, usernameI, passwordI) {
    console.log("usernameI" + usernameI + "passwordI" + passwordI + " videoBoolean   " + videoBoolean);
    var username = usernameI;
    var password = passwordI;

    var url = base_url + 'index.php/login/ajax';
    if (username === null || password === null) {
        console.log("inside if loop");
        username = $('#login_form input[ name = username ]').val();
        password = $('#login_form input[ name = password ]').val();
        videoBoolean = 'false';
    } else {
        videoBoolean = 'true';
    }
    console.log("videoBoolean " + videoBoolean);
    $.ajax({
        type: "POST",
        url: url,
        data: {
            "username": username,
            "password": password,
            "video":videoBoolean
        },
        dataType: "text",
        cache: false,
    })
            .done(function (data) {
                console.log("data: " + data);
                var response = JSON.parse(data);
                console.log("response:  " + JSON.stringify(response));
                if (response[ 'success' ]) {
                    // redirect to home page
                    window.location = base_url;
                } else {
                    // display message what's wrong
                    $('#error_message').html(response[ 'error' ]);
                    // return focus to username
                    $('#login_form input[ name = username ]').focus();
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                // display error message
                $('#error_message').html('Error connecting to server: ' + errorThrown);
            });
}


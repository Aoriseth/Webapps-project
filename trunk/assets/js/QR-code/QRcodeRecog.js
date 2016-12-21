var streaming = false;
var video = null;
var base_url = null;

function setBaseURL( baseurl ) {
    base_url = baseurl;
}

function displayError( error ) {
    $( '#error_message_camera' ).html( error );
}

(function () {

    function startup() {    // This function is called when the page is started up

        video = document.querySelector( "#camfr" );
        navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia || navigator.mozGetUserMedia;

        if ( ! navigator.getUserMedia ) {
            displayError( 'This browser does not support login with the camera.' );
            console.log( 'No getUserMedia() support.' );
            video.style.display = "none";
            return;
        }

        navigator.getUserMedia(
            {                       // constraints
                video: true,
                audio: false
            },
            function ( stream ) {   // success callback
                if ( navigator.mozGetUserMedia ) {
                    video.mozSrcObject = stream;
                } else {
                    video.src = ( window.URL && window.URL.createObjectURL( stream ) ) || stream;
                }
            },
            function ( err ) {      // error callback
                if( err.name === "PermissionDeniedError" ) {
                    displayError( 'Couldn\'t access the webcam: permission denied.' );
                    console.log( "getUserMedia error: the webcam is blocked." );
                } else {
                    displayError( 'Couldn\'t access the webcam.' );
                    console.log( 'getUserMedia error:' );
                }
                console.log( err );
                video.style.display = "none";
            }
        );

        // This function is called when the webcam is ready to play
        video.addEventListener( 'canplay', function ( ev ) {
            if ( ! streaming ) {
                video.play();
                streaming = true;

                try {
                    new QCodeDecoder().decodeFromCamera(video, result);
                } catch (err) {
                    console.log( 'decodeFromCamera failed:' );
                    console.log( err );
                }
            }
        }, false );
    }

    // add event listener to the window to execute the function startup when the page is loaded
    window.addEventListener('load', startup, false);

})();

function result( err, result ) {

    if ( err ) {
        console.log( 'QR decode error: ' + err );
        displayError( 'There is a problem reading the QR code.' );

    } else {
        console.log( 'QR code: ' + result  );

        result_parsed = JSON.parse( result );
        var username = result_parsed.username;
        var password = result_parsed.password;
        console.log( 'Parsed data: ' + username + ' / ' + password );

        if ( typeof username === "undefined" || typeof password === "undefined" ) {
            displayError( 'Invalid QR code.' );
        } else {
            login( base_url, username, password, $( '#error_message_camera' ), true );
        }
    }
}

(function () {
    
    var streaming = false;
    var video = null;
    var FRecButton = null;

    function startup() {
        // This function is called when the page is started up

        FRecButton = document.querySelector("#facialLoginButton");
        video = document.querySelector("#camfr");
        navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia || navigator.mozGetUserMedia;

        if (navigator.getUserMedia) {
            navigator.getUserMedia({video: true, audio: false}, (function (stream) {
                if (navigator.mozGetUserMedia) {
                    video.mozSrcObject = stream;
                } else {
                    video.src = (window.URL && window.URL.createObjectURL(stream)) || stream;
                }
                //video.play();
            }), function (e) {
                console.log(e);
                video.style.display = "none";
            });
            // {facingMode: 'user'}
        }
        // This function is called when the webcam is ready to play
        video.addEventListener('canplay', function (ev) {
            if (!streaming) {
                video.play();
                streaming = true;
            }
        }, false);
        // add event listener to the login button
        FRecButton.addEventListener('click', (function () {
            //console.log("takePicture");
            var width = $("#camfr").width();
            var height = $("#camfr").height();

            var canvas = document.querySelector("#canvasVideo");
            canvas.height = height;
            canvas.width = width;

            //console.log("video.height  " + height + "video.height = " + height);
            // if the video is busy with streaming freeze the screen and do facial recognition
            if (streaming) {
                canvas.getContext('2d').drawImage(video, 0, 0, width, height);
                var data = canvas.toDataURL('image/png');
                //console.log(data);
                $("#photoFR").attr("src", data);
                video.style.display = "none";
            }
            recognizePicture(data);
        }), false);
    }




    // add event listener to the window to execute the function startup when the page is loaded
    window.addEventListener('load', startup, false);
})();
/*
 *This function is called when you want to use facial recognition 
 *right now it log the answer of the online API to the console
 * @param {string} dataURL
 * @returns {undefined}
 */
function recognizePicture(dataURL) {
    getKeys(function (result) {
        var albumname = result.albumname;
        var albumkey = result.albumKey;
        var mashapekey = result.mashapeKey;
        recognizeFunc(dataURL, albumname, albumkey, mashapekey, function (result) {
            var resultObject = JSON.stringify(result);
            console.log(resultObject);
            var object = JSON.parse(resultObject);
        }
        );
    });


}
/**
 * This function is used to get the authentication keys in a secure manner
 * It takes in a callback function in which you will get a JSON parsed object from the function
 * @param {function} callback
 * @returns {nothing nothing
 */
function getKeys(callback) {

    $.ajax({
        url: "get_facial_recognition_tokens"
    }).always(function (result) {
        if (callback && typeof (callback) === "function") {
            var resultObject = JSON.stringify(result);
            callback(JSON.parse(resultObject));
        }
    });
}

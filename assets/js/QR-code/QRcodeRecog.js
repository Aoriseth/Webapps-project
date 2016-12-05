var streaming = false;
var video = null;
var FRecButton = null;
var qr = null;
var base_url = null;

(function () {


    function startup() {
        // This function is called when the page is started up

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
        qr = new QCodeDecoder();
        try {
            qr.decodeFromCamera(video, result);
        } catch (e) {
            console.log(e);
            qr.decodeFromCamera(video, result);
        }
    }




    // add event listener to the window to execute the function startup when the page is loaded
    window.addEventListener('load', startup, false);
})();
function result(e, r) {
    if (e) {
        console.log(e);
        setTimeout(qr.decodeFromCamera(video, result), 1000);
    } else {
        console.log(r);

        r = JSON.parse(r);
        console.log("username = " + r.username)
        console.log("password = " + r.password)

        login(base_url, r.username, r.password);
    }
    //qr.decodeFromCamera(video, result);
}
function setBaseURL(baseurl) {
    base_url = baseurl;
}



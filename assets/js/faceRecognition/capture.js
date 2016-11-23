(function () {
    streaming = false;
    var video = null;
    var FRecButton = null;

    function startup() {

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
        video.addEventListener('canplay', function (ev) {
            if (!streaming) {
                video.play();
                streaming = true;
            }
        }, false);
        FRecButton.addEventListener('click', (function () {
            //console.log("takePicture");
            var width = $("#camfr").width();
            var height = $("#camfr").height();

            var canvas = document.querySelector("#canvasVideo");
            canvas.height = height;
            canvas.width = width;

            //console.log("video.height = " + height + "video.height = " + height);
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





    window.addEventListener('load', startup, false);
})();

function recognizePicture(dataURL) {
    getKeys(function (result) {
        result = JSON.parse(result.responseText);
        var albumname = result.albumname;
        var albumkey = result.albumKey;
        var mashapekey = result.mashapeKey;
        console.log("mashapekey:" + mashapekey);

        recognizeFunc(dataURL, albumname, albumkey, mashapekey, function (result) {
            var resultObject = JSON.stringify(result);
            console.log(resultObject);
            var object = JSON.parse(resultObject);
        }
        );
    });


}
function getKeys(callback) {

    $.ajax({
        url: "get_facial_recognition_tokens",
    }).always(function (result) {
        if (callback && typeof (callback) === "function") {
            var resultObject = JSON.stringify(result);
            callback(JSON.parse(resultObject));
        }
    });
}

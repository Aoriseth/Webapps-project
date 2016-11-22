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
            console.log("takePicture");
            var width = $("#camfr").width();
            var height = $("#camfr").height();
            
            var canvas = document.querySelector("#canvasVideo");
            canvas.height = height;
            canvas.width = width;
            
            console.log("video.height = " + height + "video.height = " + height);
            if (streaming) {
                canvas.getContext('2d').drawImage(video, 0, 0, width, height);
                var data = canvas.toDataURL('image/png');
                console.log(data);
                $("#photoFR").attr("src", data);
                video.style.display = "none";
                //photo.style.display="inline-box";
            }
            ;
        }), false);
    }





    window.addEventListener('load', startup, false);
})();



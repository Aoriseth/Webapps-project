<div class="jumbotron">
    <p>
            <i>Log in using facial recognition.</i>
    </p>
    <p>
        <video id="camfr" width="100%" height="100%" autoplay="true">
            
        </video>
        <script>
            var video = document.querySelector("#camfr");
 
            navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;

            if (navigator.getUserMedia) {       
                navigator.getUserMedia({video: true}, handleVideo, videoError);
            }

            function handleVideo(stream) {
                video.src = window.URL.createObjectURL(stream);
            }

            function videoError(e) {
                // do something
            }
        </script>
    </p>
</div>
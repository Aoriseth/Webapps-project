<div class="jumbotron">
    <p>
            <i>Log in using facial recognition.</i>
    </p>
    <p>
        <video style="background-color: black;" id="cam" width="100%" height="100%" autoplay>
            
        </video>
        <script>
                var video = document.getElementById('cam');
                if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
                        video.src = window.URL.createObjectURL(stream);
                        video.play();
                    });
                }

                /* Legacy code below: getUserMedia 
                else if(navigator.getUserMedia) { // Standard
                    navigator.getUserMedia({ video: true }, function(stream) {
                        video.src = stream;
                        video.play();
                    }, errBack);
                } else if(navigator.webkitGetUserMedia) { // WebKit-prefixed
                    navigator.webkitGetUserMedia({ video: true }, function(stream){
                        video.src = window.webkitURL.createObjectURL(stream);
                        video.play();
                    }, errBack);
                } else if(navigator.mozGetUserMedia) { // Mozilla-prefixed
                    navigator.mozGetUserMedia({ video: true }, function(stream){
                        video.src = window.URL.createObjectURL(stream);
                        video.play();
                    }, errBack);
                }       
        </script>
    </p>
</div>
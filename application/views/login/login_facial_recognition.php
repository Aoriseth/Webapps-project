<div class="jumbotron">
    <p>
            <i>Log in using facial recognition.</i>
    </p>
    <p>
        <video id="cam" width="100%" height="100%" autoplay>
            
        </video>
        <script>
                var video = document.getElementById('cam');
                if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
                        video.src = window.URL.createObjectURL(stream);
                        video.play();
                    });
                }
                alert("test");
});      
        </script>
    </p>
</div>
<div class="jumbotron text-center">
    <p>
        <i>Log in using facial recognition.</i>
    </p>
    <video id="camfr" width="50%" height="50%" autoplay="true">

    </video>
    <script src="<?php echo base_url(); ?>assets/js/faceRecognition/capture.js" type="text/javascript"></script>
    <canvas id = "canvasVideo" hidden="true"width="50%" height="50%" ></canvas>
    <img id="photoFR" width="50%" height="50%" > 


    <br/>
    <button class="btn btn-default btn-raised" id="facialLoginButton">Log in</button>


</div>
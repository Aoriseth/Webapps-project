
<div class="container-fluid">
        
   
    <div class="row">
        <div class="jumbotron">
            <form class="text-center">
                <button style="width: 50%;font-size:2em;" class="btn-lg withripple btn btn-raised btn-info" formaction="<?php echo base_url() . 'index.php/resident/categories' ?>"><br>Start a new test!<br><br></button>
            </form>
                    
            <canvas class="center-block img-responsive" id="puzzle" style="height: 35vw;width:content-box"></canvas>
            <script> loadPuzzle("<?php echo base_url() ?>"); </script>
            
        </div>

    </div> 

</div>
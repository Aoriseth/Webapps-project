
<div class="container">
    <div class="row">
        
        <div class="col-lg-2">
            <p>
                Hello {name}.
            </p>
        </div>
        
        <div class="col-lg-8" >
            
            <p>
                <img src=<?php echo base_url().'assets/imgs/images.jpg'?> alt="Mountain View" style="width:304px;height:228px;" class="center-block">
            </p>

            <form action=<?php echo base_url().'index.php/resident/categories' ?> method="POST" class="text-center">
                <input class="btn btn-primary" type="submit" name="Categories" value="Start a new test!" >
            </form>


        </div>
        
        <div class="col-lg-2">

        </div>
    </div>

</div>
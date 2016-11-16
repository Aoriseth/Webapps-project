
<div class="container">
    <div class="row">
        <p>
            Hello {name}.
        </p>
    </div>
    <div class="row">     

            
            <p>
                <img src=<?php echo base_url().'assets/imgs/images.jpg'?> alt="Mountain View" style="width:100%;height:40%;" class="center-block">
            </p>

            <form action=<?php echo base_url().'index.php/resident/categories' ?> method="POST" class="text-center">
                <input class="btn btn-primary" type="submit" name="Categories" value="Start a new test!" >
            </form>

    </div>

</div>
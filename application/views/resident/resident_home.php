
<div class="container">
    <div class="row">
        <p>
            Hello {name}.
        </p>
    </div>
    <div class="row">     

            
            <p>
                <img src=<?php echo base_url().'assets/imgs/puzzle.jpg'?> alt="Puzzle View" style="width:100%;height:40vw;" class="center-block">
            </p>

            <form action=<?php echo base_url().'index.php/resident/categories' ?> method="POST" class="text-center">
                <input class="btn btn-raised btn-default" type="submit" name="Categories" value="Start a new test!" style="width: 50%">
            </form>

    </div>

</div>
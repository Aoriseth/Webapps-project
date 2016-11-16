
<div class="container">
    <div class="row">
        

        
        <div class="col-lg-12" >
            <p>
                Select a category:
            </p>
            <?php foreach( $categories as $category ) { ?>
                <div class="col-xs-4" >
                    <form action="<?php echo base_url().'index.php/resident/question' ?>" method="GET">
                        <!--input class="btn btn-default" type="submit" name="category" value="<?php echo $category->category ?>" class="text-center"-->
                        <button type="submit" name="category" value="<?php echo $category->category ?>" class="text-center">
                            <span class="glyphicon glyphicon-edit"></span>
                            
                        </button></br>
                        <?php echo $category->category ?>

                           
                    </form>
                </div>

            <?php } ?>

        </div>

    </div>

</div>
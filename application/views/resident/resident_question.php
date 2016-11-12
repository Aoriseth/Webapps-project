

<div class="container">
    <div class="row">
               
        <div class="col-lg-12" >
            <div class="col-lg-1" ></div>
            <div class="col-lg-10" >
                <p class="text-center">
                    {question}
                </p>
                <?php foreach( $options as $option) { ?>
                    <div class="col-lg-2" >
                        <form action="<?php echo base_url().'index.php/resident/question?category='.$category.'&index='.($index+1) ?>" method="POST" class="text-center">
                            <!--input class="glyphicon-user" type="submit" name="option" value="<?php echo htmlspecialchars( $option->option ) ?>"-->
                            <button type="submit" name="category" value="<?php echo htmlspecialchars( $option->option ) ?>" >
                            <span class="glyphicon glyphicon-edit"></span>
                            
                        </button></br>
                        <?php echo htmlspecialchars( $option->option ) ?>
                        </form>
                    </div>

                <?php } ?>
            </div>
            
            <div class="col-lg-1" ></div>
        

        </div>
        

    </div>
    <div class="row">
        <p class="text-center">
                Question <?php echo $index+1 ?> of {category_size} from {category}.
        </p>

        <?php if ( $index > 0 ) { ?>

                <form action="<?php echo base_url().'index.php/resident/question?category='.$category.'&index='.($index-1) ?>" method="POST">
                        <input class="btn btn-primary" type="submit" name="back" value="Go back">
                </form>

        <?php } ?>
    </div>
</div>
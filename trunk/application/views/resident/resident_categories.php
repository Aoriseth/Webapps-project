<div class="well">
    <div class="container">
        <div class="row">



            <div class="col-lg-12" >
                <p>
                    Select a category:
                </p>
                <?php foreach ($categories as $category) { ?>
                    <div class="col-xs-4" >
                        <form action="<?php echo base_url() . 'index.php/resident/question' ?>" method="GET">
                            <!--input class="btn btn-default" type="submit" name="category" value="<?php echo $category->category ?>" class="text-center"-->
                            <button type="submit" name="category" value="<?php echo $category->category ?>" class="text-center">
                                <?php if ($category->category === "Safety and security") { ?>
                                    <span class="glyphicon glyphicon-facetime-video"></span>
                                <?php } elseif ($category->category === "Food and meals") { ?>
                                    <span class="glyphicon glyphicon-cutlery"></span> 
                                <?php } elseif ($category->category === "Comfort") { ?>
                                    <span class="glyphicon glyphicon-bed"></span>
                                <?php } elseif ($category->category === "Personal relationships") { ?>
                                    <span class="glyphicon glyphicon-heart"></span> 
                                <?php } elseif ($category->category === "Activities") { ?>
                                    <span class="glyphicon glyphicon-blackboard"></span> 
                                <?php } elseif ($category->category === "Privacy") { ?>
                                    <span class="glyphicon glyphicon-home"></span> 
                                <?php } else { ?>
                                    <span class="glyphicon glyphicon-edit"></span>
                                <?php } ?>
                            </button></br>
                            <?php echo $category->category ?>


                        </form>
                    </div>

                <?php } ?>

            </div>

        </div>

    </div></div>
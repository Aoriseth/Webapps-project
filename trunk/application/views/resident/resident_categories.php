<div class="well popup" data-placement="bottom" data-toggle="popover" title="" data-container="body" data-content="Choose one of the three visible categories to continue">
    <div class="container-fluid">
        <div class="row">



            <div class="col-lg-12" >
                <h2 style="font-size:3vw">
                    Select a category:
                </h2>
                <hr/>
                <?php foreach ($categories as $category) { ?>
                    <div class="col-sm-4" >
                        <form style='text-align:center' action="<?php echo base_url() . 'index.php/resident/question' ?>" method="GET">
                            <!--input class="btn btn-default" type="submit" name="category" value="<?php echo $category->category ?>" class="text-center"-->
                            <button type="submit" name="category" value="<?php echo $category->category ?>" class="btn btn-raised btn-default text-center">
                                <?php if ($category->category === "Safety and security") { ?>
                                    <span style='font-size:10vw' class="glyphicon glyphicon-facetime-video"></span>
                                <?php } elseif ($category->category === "Food and meals") { ?>
                                    <span style='font-size:10vw' class="glyphicon glyphicon-cutlery"></span> 
                                <?php } elseif ($category->category === "Comfort") { ?>
                                    <span style='font-size:10vw' class="glyphicon glyphicon-bed"></span>
                                <?php } elseif ($category->category === "Personal relationships") { ?>
                                    <span style='font-size:10vw' class="glyphicon glyphicon-heart"></span> 
                                <?php } elseif ($category->category === "Activities") { ?>
                                    <span style='font-size:10vw' class="glyphicon glyphicon-blackboard"></span> 
                                <?php } elseif ($category->category === "Privacy") { ?>
                                    <span style='font-size:10vw' class="glyphicon glyphicon-home"></span> 
                                <?php } else { ?>
                                    <span style='font-size:10vw' class="glyphicon glyphicon-edit"></span>
                                <?php } ?>
                            </button></br>
                            <p style="font-size:2vw"><?php echo $category->category ?></p>


                        </form>
                    </div>

                <?php } ?>

            </div>

        </div>

    </div></div>
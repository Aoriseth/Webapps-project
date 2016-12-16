<div class="panel popup" data-placement="bottom" data-toggle="popover" title="" data-container="body" data-content="<?= lang('r_categories_help') ?>">
    <div class="container-fluid">
        <div class="row">



            <div class="col-lg-12" >
                <h2 style="font-size:3vmax">
                    <?= lang('r_categories_explanation') ?>
                </h2>
                <hr/>
                <?php foreach ($categories as $category) { ?>
                    <div class="col-sm-4" >
                        <form style='text-align:center' action="<?php echo base_url() . 'index.php/resident/question' ?>" method="GET">
                            <!--input class="btn btn-default" type="submit" name="category" value="<?php echo $category->category ?>" class="text-center"-->
                            <button style="width:13vw;height:13vw;" type="submit" name="category" value="<?php echo $category->category ?>" class="btn btn-fab btn-default text-center">
                                <?php if ($category->category === "Safety and security") { ?>
                                <img style="width:9vw;" src="http://image.flaticon.com/icons/png/512/295/295666.png">
                                    <!--<span style='font-size:10vw' class="glyphicon glyphicon-facetime-video"></span>-->
                                <?php } elseif ($category->category === "Food and meals") { ?>
                                <img style="width:8vw;" src="http://image.flaticon.com/icons/png/512/272/272155.png">
                                    <!--<span style='font-size:10vw' class="glyphicon glyphicon-cutlery"></span>--> 
                                <?php } elseif ($category->category === "Comfort") { ?>
                                <img style="width:10vw;" src="http://image.flaticon.com/icons/png/512/148/148102.png">
                                    <!--<span style='font-size:10vw' class="glyphicon glyphicon-bed"></span>-->
                                <?php } elseif ($category->category === "Personal relationships") { ?>
                                    <img style="width:10vw;" src="http://image.flaticon.com/icons/png/512/265/265667.png">
                                    <!--<span style='font-size:10vw' class="glyphicon glyphicon-heart"></span>--> 
                                <?php } elseif ($category->category === "Activities") { ?>
                                    <img style="width:8vw;" src="http://image.flaticon.com/icons/png/512/147/147206.png">
                                    <!--<span style='font-size:10vw' class="glyphicon glyphicon-blackboard"></span>--> 
                                <?php } elseif ($category->category === "Privacy") { ?>
                                    <img style="width:8vw;" src="http://image.flaticon.com/icons/png/512/147/147040.png">
                                    <!--<span style='font-size:10vw' class="glyphicon glyphicon-home"></span>--> 
                                <?php } else { ?>
                                    <img style="width:10vw;" src="http://image.flaticon.com/icons/png/512/190/190177.png">
                                    <!--<span style='font-size:10vw' class="glyphicon glyphicon-edit"></span>-->
                                <?php } ?>
                            </button><br><br>
                            <p style="font-size:2vmax"><?php echo $category->category ?></p>


                        </form>
                    </div>

                <?php } ?>

            </div>

        </div>
        <br>
    </div></div>
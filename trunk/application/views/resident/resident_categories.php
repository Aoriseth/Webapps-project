<div class=" panel popup" data-placement="bottom" data-toggle="popover" title="" data-container="body" data-content="<?= lang('r_categories_help') ?>">
    <div class="container-fluid">
        <div class="row">



            <div class="col-lg-12" >
                <h2 class="tlScale">
                    <?= lang('r_categories_explanation') ?>
                </h2>
                <hr/><br>
                <?php foreach ($categories as $category) { ?>
                    <div class="col-sm-4" >
                        <form style='text-align:center' action="<?php echo base_url() . 'index.php/resident/question' ?>" method="GET">
                            <!--input class="btn btn-default" type="submit" name="category" value="<?php echo $category->category ?>" class="text-center"-->
                            <button style="width:13vw;height:13vw;" type="submit" name="category" value="<?php echo $category->category ?>" class="grow btn btn-fab btn-default text-center">
                                <?php if ($category->category === "Veiligheid") { ?>
                                    <img style="width:8vw;" src="https://image.flaticon.com/icons/png/512/295/295666.png">
                                <?php } elseif ($category->category === "Maaltijden") { ?>
                                    <img style="width:8vw;" src="https://image.flaticon.com/icons/png/512/272/272155.png">
                                <?php } elseif ($category->category === "Comfort") { ?>
                                    <img style="width:10vw;" src="https://image.flaticon.com/icons/png/512/148/148102.png">
                                <?php } elseif ($category->category === "Personal relationships") { ?>
                                    <img style="width:10vw;" src="https://image.flaticon.com/icons/png/512/265/265667.png">
                                <?php } elseif ($category->category === "Activiteiten") { ?>
                                    <img style="width:8vw;" src="https://image.flaticon.com/icons/png/512/147/147206.png">
                                <?php } elseif ($category->category === "Privacy") { ?>
                                    <img style="width:8vw;" src="https://image.flaticon.com/icons/png/512/147/147040.png">
                                <?php } elseif ($category->category === "Respect van personeel") { ?>
                                    <img style="width:8vw;" src="https://image.flaticon.com/icons/png/512/189/189073.png">
                                <?php } elseif ($category->category === "Informatie vanuit het woonzorgcentrum") { ?>
                                    <img style="width:8vw;" src="https://image.flaticon.com/icons/png/512/263/263195.png">
                                <?php } elseif ($category->category === "Autonomie") { ?>
                                    <img style="width:8vw;" src="https://image.flaticon.com/icons/png/512/265/265669.png">
                                <?php } elseif ($category->category === "Reageren door medewerkers op vragen") { ?>
                                    <img style="width:9vw;" src="https://image.flaticon.com/icons/png/512/263/263205.png">
                                <?php } elseif ($category->category === "Band met personeel") { ?>
                                    <img style="width:10vw;" src="http://image.flaticon.com/icons/png/512/236/236810.png">
                                <?php } elseif ($category->category === "Persoonlijke omgang") { ?>
                                    <img style="width:10vw;" src="https://image.flaticon.com/icons/png/512/214/214351.png">
                                <?php } else { ?>
                                    <img style="width:10vw;" src="https://image.flaticon.com/icons/png/512/190/190177.png">
                                <?php } ?>
                            </button><br><br>
                            <p class="txScale"><?php echo $category->category ?></p>


                        </form>
                    </div>

                <?php } ?>

            </div>

        </div>
        <br>
    </div></div>
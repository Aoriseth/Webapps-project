<?php
$progress = 0;
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12" >
            <div class="col-lg-1" ></div>
            <div class="col-lg-10" >

                <div class="card" id="card_question">
                    <p class="text-center">
                        {question}
                    </p>
                </div>
                
                <div class="card" id="card_answer">
                    <?php $index = 0; foreach ($options as $option) { ?>
                        <div class="col-lg-2" >
                            <form action="<?php echo base_url() . 'index.php/resident/question?category=' . $category . '&index=' . ($index + 1) ?>" method="POST" class="text-center">
                                <!--input class="glyphicon-user" type="submit" name="option" value="<?php echo htmlspecialchars($option->option) ?>"-->
                                <button type="submit" name="category" value="<?php echo htmlspecialchars($option->option) ?>" > 
                                    <!--span class="glyphicon glyphicon-edit"></span-->
                                    <img src=<?php echo base_url().'assets/imgs/emotions/'.$index.".png" ?> width="100" height="100">
                                </button></br>
                                <?php echo htmlspecialchars($option->option); $index++; ?>
                            </form>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="col-lg-1" ></div>
        </div>
    </div>
    <div class="row">
        <p class="text-center">
            Question <?php echo $index + 1 ?> of {category_size} from {category}.
            </br>
        </p>
        <div class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="0"
                 aria-valuemin="0" aria-valuemax="100" 
                 style="width:<?php echo $index + 1 ?>%">
                <span class="sr-only">70% Complete</span>
            </div>
        </div>
        <?php if ($index > 0) { ?>

            <form action="<?php echo base_url() . 'index.php/resident/question?category=' . $category . '&index=' . ($index - 1) ?>" method="POST">
                <input class="btn btn-primary" type="submit" name="back" value="Go back">
            </form>
        <?php } ?>
    </div>
</div>

<script>
    function calculate_progress(category_size, question) {

        document.write(question / category_size);

    }
</script>
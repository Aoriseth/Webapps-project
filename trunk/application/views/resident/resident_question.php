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
                    <?php $emotion_index = 0;
                    foreach ($options as $option) { ?>
                        <div class="col-lg-2" >
                            <form class="button_form" action="<?php echo base_url() . 'index.php/resident/question?category=' . $category . '&index=' . ($index + 1) ?>" method="POST" class="text-center">
                                <button class="button_emotion" type="submit" name="category" value="<?php echo htmlspecialchars($option->option) ?>"> 
                                    <img src=<?php echo base_url() . 'assets/imgs/emotions/' . $emotion_index . ".png" ?>>                                   
                                </button></br>
                                <?php echo htmlspecialchars($option->option); $emotion_index++; ?>
                            </form>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="col-lg-1" ></div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-10">
            <p class="text-center">
                Question <?php echo $index + 1 ?> of {category_size} from {category}.
                </br>
            </p>
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="0"
                     aria-valuemin="0" aria-valuemax="100" 
                     style="width: <?php echo ( ((int)$index) / ((int)${category_size}) * 100 )?>%">
                    <!--span class="sr-only">70% Complete</span-->
                </div>
            </div>
            <?php if ($index > 0) { ?>
                <form action="<?php echo base_url() . 'index.php/resident/question?category=' . $category . '&index=' . ($index - 1) ?>" method="POST">
                    <input class="btn btn-primary, col-lg-1" type="submit" name="back" value="Go back">
                </form>
            <?php } ?>
        </div>
    </div>
</div>

<script>
    function calculate_progress(category_size, question) {
        document.write(question / category_size);
    }
</script>
<?php
$progress = 0;
?>
<div class="container">
    <div class="row">

            <!--div class="col-xs-1" ></div-->
            <div class="col-xs-12">

                <div class="jumbotron" id="jumbotron_question">
                    <p class="text-center">
                        {question}
                    </p>
                </div>

                <div class="jumbotron" id="jumbotron_answer">
                    <?php $emotion_index = 0;
                    foreach ($options as $option) { ?>
                    <div class="col-xs-2" id="col_btn">
                            <form class="form_btn" action="<?php echo base_url() . 'index.php/resident/question?category=' . $category . '&index=' . ($index + 1) ?>" method="POST" class="text-center">
                                <button class="btn btn-raised btn-default" id="button_emotion" 
                                        type="submit" name="option" value="<?php echo htmlspecialchars($option->option) ?>"
                                        <!--style="background-image : url(<?php echo base_url() . 'assets/imgs/emotions/' . $emotion_index . ".png" ?>);"--> 
                                    <img src=<?php echo base_url() . 'assets/imgs/emotions/' . $emotion_index . ".png" ?> >                                   
                                </button></br>
                                <?php echo htmlspecialchars($option->option); $emotion_index++; ?>
                            </form>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <!--div class="col-xs-1" ></div-->
    </div>
    
    <p style="margin-top:10px;">
        
    <div class="row">
        <div class="col-xs-10">
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="0"
                     aria-valuemin="0" aria-valuemax="100" 
                     style="width: <?php echo ( (int)($index + 1)/ (int)$category_size * 100 )?>%">
                            <!--span class="sr-only">70% Complete</span-->
                    <p class="text-center">
                        Question <?php echo $index + 1 ?> of {category_size}
                    </p>
                </div>
            </div>
        </div>

    <!--/div-->
    <!--div class="row"--> 
        <div class="col-xs-2" >
            <?php if ($index > 0) { ?>
                <form action="<?php echo base_url() . 'index.php/resident/question?category=' . $category . '&index=' . ($index - 1) ?>" method="POST">
                    <input class="btn btn-raised btn-default" type="submit" name="back" value="Go back" style="width:100%">
                </form>
            <?php } ?>
            <?php 
                <input class="btn btn-raised btn-default" type="submit" name="back" value="Go back" style="width:100%; color:LightGray;">
            ?>
        </div>
    </div>
    
</div>

<script>
    function calculate_progress(category_size, question) {
        document.write(question / category_size);
    }
</script>
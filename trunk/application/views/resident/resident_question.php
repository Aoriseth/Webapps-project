

<div class="container-fluid" id="container_resident">
    <script src="<?php echo base_url(); ?>assets/js/loadingAnswers_Questions/LoadA_Q.js" type="text/javascript"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>

    <div data-placement="bottom" data-toggle="popover" title="" data-content="<?= lang( 'r_question_help' ) ?>" data-container="body" class="popup panel row">

        
        <div class="col-12">
            <br>
            <div class="container-fluid" id="jumbotron_question">
                <div class="container-fluid">
                    <p class="tlScale" id="question_text">
                    
                </p><hr><br>
                </div>
                
            </div>
        </div>

            <div class="row"  id="jumbotron_answer">
                <div class="visible-md visible-sm visible-lg col-sm-1"></div>
                <?php
                $emotion_index = 0;
                foreach ($options as $option) {
                    ?>

                    <div class=" col-sm-offset-0 col-sm-2 col-md-offset-0 col-md-2 col-xs-5" id="col_btn">
                        <div style="width:100%;text-align: center;margin:auto;">

                            <button style="width:100%;height:100%;" class="btn btn-fab  btn-default" id="button_emotion<?php $emotion_index ?>" 
                                    onclick="(storeAnswer(<?php echo $emotion_index ?>, ' <?php echo base_url() ?>', '{category}'));"
                                    value="<?php echo htmlspecialchars($option->option) ?>">

                                <img style="width:100%;height:100%;" src=<?php echo base_url() . 'assets/imgs/emotions/' . $emotion_index . ".png" ?> >                                   
                            </button>
                            <br><br>
                            <?php
                            echo htmlspecialchars($option->option);
                            $emotion_index++;
                            ?>
                            <span class="visible-xs"></br></span>
                        </div>

                    </div>
                    <?php
                }
                ?>
            </div>
            <br>



<!--        <p style="margin-top:40px;">-->

        <div class="row container-fluid">

            <div class="col-sm-10 col-sm-offset-1 " >
                <div class="progress" id="progress" style="margin-top: 20px;">
                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="progressBar" style="background-color: #673AB7;min-width: 2em;">
                        

                    </div>
                </div>
            </div>

            <div class="col-sm-offset-10 col-sm-2" >
                <button class="btn btn-default" type="submit" name="back" value="Go back" onclick="pressGoBack()" style="width:100%; color:#673AB7;">
                    <?= lang('r_question_back') ?>
                </button>
                
            </div>
        </div>
    </div>
    <br>
    <br>
</div>
<script> loadQuestion(<?php echo json_encode($allUnansweredQuestions); ?>);</script>

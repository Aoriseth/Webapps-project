

<div class="container" id="container_resident">
    <script src="<?php echo base_url(); ?>assets/js/loadingAnswers_Questions/LoadA_Q.js" type="text/javascript"></script>

    <div class="well row">

        <div class="col-12">
            <div class="" id="jumbotron_question">
                <p class="text-center" id="question_text">
                    fdqs
                </p>
            </div>

            <div class="row"  id="jumbotron_answer">
                <div class="visible-md visible-sm visible-lg col-sm-1"></div>
                <?php
                $emotion_index = 0;
                foreach ($options as $option) {
                    ?>
               
                    <div class=" col-sm-offset-0 col-sm-2 col-md-offset-0 col-md-2 col-xs-5" id="col_btn">
                        <div style="width:100%;text-align: center;margin:auto;">

                            <button style="width:100%;height:100%;" class="btn btn-raised btn-default" id="button_emotion<?php $emotion_index ?>" 
                                    onclick="(storeAnswer(<?php echo $emotion_index ?>, ' <?php echo base_url() ?>', '{category}'));"
                                    value="<?php echo htmlspecialchars($option->option) ?>">

                                <img style="width:100%;height:100%;" src=<?php echo base_url() . 'assets/imgs/emotions/' . $emotion_index . ".png" ?> >                                   
                            </button>
                            <br/>
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
        </div>



        <p style="margin-top:10px;">

        <div class="row">

            <div class="col-sm-10" id="progress_col">
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="progressBar"
                         >
                    </div>
                </div>
            </div>

			<div class="col-sm-2" >
				<button class="btn btn-raised btn-default" type="submit" name="back" value="Go back" onclick="pressGoBack()" style="width:100%; color:Gray;">
						 <?= lang( 'resident_question_back' ) ?>
				</button>
			</div>
        </div>
    </div>
</div>

</div>
<script> loadQuestion(<?php echo json_encode($allUnansweredQuestions); ?>);</script>

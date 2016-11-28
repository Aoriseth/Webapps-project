<script>
	// User has to be logged in as resident to be able to do this!
	function storeAnswer( categoryId, questionId, chosenOption ) {
		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>index.php/resident/question_store_answer", 
			data: {
				category_id: categoryId,
				question_id: questionId,
				chosen_option: chosenOption
			},
			dataType: "text",
			cache:false,
			success: function( data ) {
				console.log(data);  // debugging message.
			}
		});
	}
</script>

<div class="container" id="container_resident">

	<div class="well row">

		<div class="col-12">
			<div  id="jumbotron_question">
				<p class="text-center">
					{question}
				</p>
			</div>

                    <div class="row"  id="jumbotron_answer">
                        <div class="col-md-1 col-sm-1 col-lg-1 visible-sm visible-md visible-lg"></div>
				<?php
					$emotion_index = 0;
					foreach ($options as $option) {
				?>
					<div class=" col-sm-offset-0 col-sm-2 col-md-offset-0 col-md-2 col-xs-5" id="col_btn">
                                            <div style="width:100%;text-align: center;margin:auto;">
                                            <form style="width:100%" class="form_btn"  class="text-center"
							  action="<?php echo base_url().'index.php/resident/question?category='.$category.'&index='.($index + 1) ?>" method="POST">

                                                    <button style="width:100%;height:100%;" class="btn btn-raised btn-default" id="button_emotion" type="submit" name="option"
									value="<?php echo htmlspecialchars($option->option) ?>">

								<img style="width:100%;height:100%;" src=<?php echo base_url().'assets/imgs/emotions/'.$emotion_index.".png" ?> >                                   
							</button>
							<br/>
							<?php echo htmlspecialchars($option->option); $emotion_index++; ?>
                                                        <span class="visible-xs"></br></span>
                                            </form>
                                        </div>
					</div>
				<?php
					}
				?>
			</div>
		</div>

	


	<div class="row">

		<div class="col-sm-10" id="progress_col">
			<div class="progress">
				<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" 
					 style="width: <?php echo ( (int)$index / (int)$category_size * 100 ) ?>%">
				</div>
			</div>
		</div>

		<div class="col-sm-2" >
			<?php if ( $index > 0 ) { ?>
				<form action="<?php echo base_url().'index.php/resident/question?category='.$category.'&index='.($index - 1) ?>" method="POST">
					<input class="btn btn-raised btn-default" type="submit" name="back" value="Go back" style="width:100%">
				</form>
			<?php } else { ?>
				<input class="btn btn-raised btn-default" type="submit" name="back" value="Go back" style="width:100%; color:LightGray;">
			<?php } ?>
		</div>
	</div>
        </div>

</div>

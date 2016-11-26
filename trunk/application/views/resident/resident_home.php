
<div class="container-fluid">
        

        <div class="well">
            <h2 class="text-center">
                Welcome {name}.<br>
            </h2>
			<?php if ( $display_login_notification == true ) { ?>
				<!-- TODO replace this obvisously... -->
				<p class="text-center">
					I see you've just logged in...
				</p>
			<?php } ?>
            <form class="text-center">
                <button style="width: 50%;font-size:2em;" class="btn-lg withripple btn btn-raised btn-info" formaction="<?php echo base_url() . 'index.php/resident/categories' ?>"><br>Start a new test!<br><br></button>
            </form>
        </div>
    
        
        <div class="well">
            
                <img src=<?php echo base_url().'assets/imgs/puzzle.jpg'?> alt="Puzzle View" style="width:100%;height:35vw;" class="center-block">
        </div>

            </div> 
        
    

</div>
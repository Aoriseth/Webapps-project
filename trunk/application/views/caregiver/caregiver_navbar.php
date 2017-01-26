<div class="navbar navbar-inverse navbar-fixed-top" style="background-color: #512DA8">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a style="pointer-events: none;" class="navbar-brand"><?= lang( 'common_app' ) ?></a>
		</div>
		<div class="navbar-collapse collapse navbar-responsive-collapse">
			<ul class="nav navbar-nav">
				<?php
					foreach ( $pages as $page ) {
				?>
					<li <?php if ( $page == $page_active ) { ?>class="active"<?php } ?> >
						<a href="<?= base_url().'index.php/caregiver/'.$page ?>"><?= lang( 'c_navbar_'.$page ) ?></a>
					</li>
				<?php } ?>
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<li><a href="<?php echo base_url() . 'index.php/logout' ?>"><?= lang( 'common_logout' ) ?></a></li>
			</ul>
		</div>
	</div>
</div>
<div style="top:0px;height:250px;width:100%;background-color: #673ab7;position:absolute;">
    
</div>

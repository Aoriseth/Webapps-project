<h2>Home page for the caregivers</h2>

<hr />

<p>
	Hello {name}.
</p>

<?php if ( $display_login_notification == true ) { ?>
	<!-- TODO replace this obvisously... -->
	<p>
		I see you've just logged in...
	</p>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	Nothing to see here. Just needed a place to test on the live site (need access to /uploads). After these tests are done, all of this can be removed.
	<form action=<?php echo base_url().'index.php/caregiver/upload' ?> method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
	</form>
<?php } ?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/main.css">
<h2 class="tlScale">Home page for the caregivers</h2>

<hr />

<p class="txScale">
    Hello {name}.
</p>

<?php if ($display_login_notification == true) { ?>
    <!-- TODO replace this obvisously... -->
    <script type="text/javascript">
        $(document).ready(function () {
            $.snackbar({content: 'Hello {name}, you succesfully logged in!'});
        });
    </script>

    <!--<br/>
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
    <br/>
    Pretend you didn't see this. Just needed a place to test on the live site. After these tests are done, all of this can be removed.
    <form action=<?php echo base_url() . 'index.php/caregiver/upload' ?> method="post" enctype="multipart/form-data">
            Select image to upload:
            <input type="file" name="fileToUpload" id="fileToUpload" required>
            <input type="submit" value="Upload Image" name="submit">
    </form> -->
<?php } ?>

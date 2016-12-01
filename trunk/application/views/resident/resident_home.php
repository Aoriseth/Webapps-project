


    
        <div class="well">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3"
                     <form>
                        <button style="width:100%;font-size:2.5vmax;" class="btn-lg withripple btn btn-raised btn-info" formaction="<?php echo base_url() . 'index.php/resident/categories' ?>">Start a new test!</button>
                    </form>
                </div>
            </div>
            <canvas class="center-block img-responsive" id="puzzle" style="height: 35vw;width:auto"></canvas>
            <script> loadPuzzle("<?php echo base_url() ?>");</script>

        </div>

<?php if ($display_login_notification == true) { ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $.snackbar({content: 'Hello {name}, you succesfully logged in!'});
        });
    </script>
<?php } ?>
<script src="<?= base_url(); ?>assets/js/login.js" type="text/javascript"></script>
<script>
    $( function () {
        $( "#login_form" ).submit( function ( event ) {
            login(
                '<?= base_url() ?>',
                $( '#login_form input[ name = username ]' ).val(),
                $( '#login_form input[ name = password ]' ).val(),
                $( '#error_message_manual' ),
                false
            );
            return false;
        });
    });
</script>

<div>
    <p class="txScale container-fluid">
        <?= lang( 'login_manual_explanation' ) ?>
    </p>

    <p class="container-fluid" style="color:red" id="error_message_manual">
        <br><!-- will be used to display error messages -->
    </p>

    <form method="POST" id="login_form">
        <div class="container-fluid">
            <div class="form-group label-floating">
                <label class="control-label" for="focusedInput1"><?= lang( 'login_field_username' ) ?></label>
                <input class="form-control" name="username" id="focusedInput1" required type="text">
            </div>
            <div class="form-group label-floating">
                <label class="control-label" for="focusedInput2"><?= lang( 'login_field_password' ) ?></label>
                <input class="form-control" name="password" id="focusedInput2" required type="password">
            </div>
            <br><br>
            <input class="btn btn-lg btn-raised btn-info txScale pull-right" style="background-color: #673AB7;" type="submit" name="login" value="<?= lang( 'common_login' ) ?>">
        </div>
    </form>
</div>

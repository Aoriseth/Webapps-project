<p class="txScale"><?= lang( 'caregiver_home_body' ) ?></p>

<?php if ($display_login_notification == true) { ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $.snackbar({content: '<?= lang( 'common_welcome_snackbar' ) ?>'});
        });
    </script>
<?php } ?>

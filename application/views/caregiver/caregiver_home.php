<div class="panel container-fluid">
    <br>
    <p class="tlScale"><?= lang('c_home_body') ?></p>

    <?php if ($display_login_notification == true) { ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $.snackbar({content: '<?= lang('common_welcome_snackbar') ?>'});
            });
        </script>
    <?php } ?>


        <p class="txScale">problematische residenten <p>

        <p class="txScale">problematische topics + bar chart alle categorieen</p>
    <br>
</div>



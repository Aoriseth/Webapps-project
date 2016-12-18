<div class="fire container-fluid panel ">
    <div class=" ">
        <div class="container-fluid row">
            <br>
            <p class="txScale">
                <?= lang('r_completed_explanation') ?>
            </p><hr>
        </div>
        <div class="tip">
            <p class="tlScale">
                Hier is een tip voor deze categorie:
            </p>
            <blockquote>
                <i><p class="txScale">
                        {tip}
                    </p>

                </i>
            </blockquote>


        </div> <br>
    </div>

    <div class="row">
        <div class="col-xs-4">
            <form action=<?php echo base_url() . 'index.php/resident/categories' ?> method="POST">
                <input class="btn btn-lg btn-default" type="submit" name="Categories" value="<?= lang('r_completed_start_new') ?>" style="size: 100%;color:#673AB7">
            </form>
        </div>

        <div class="col-xs-4">
            <form action=<?php echo base_url() . 'index.php/resident/home' ?> method="POST">
                <input class="btn btn-lg btn-default" type="submit" name="Categories" value="Ga naar de puzzle" style="size: 100%;color:#673AB7">
            </form>
        </div>
    </div>
    <br>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $('.fire').fireworks();
        $('.fire').fireworks('destroy');
    });
</script>

<div class="jumbotron">
    <form action=<?php echo base_url() . 'index.php/login/facial_recognition' ?> method="POST">
            <input class="btn btn-raised btn-default" type="submit" name="login_facial_recognition" value="Log in using facial recognition">
    </form>

    <form action=<?php echo base_url() . 'index.php/login/manual' ?> method="POST">
            <input class="btn btn-raised btn-default" type="submit" name="login_manual" value="Log in manually">
    </form>
<div>

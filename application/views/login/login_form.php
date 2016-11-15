<div class="jumbotron">
    <p>
            Log in by manually typing your username and password.
    </p>
    <form action=<?php echo base_url() . 'index.php/login/manual' ?> method="POST">

            <div class="container-fluid">
            <div class="form-group label-floating">
                <label class="control-label" for="focusedInput1">Username</label>
                <input class="form-control" name="username" id="focusedInput1" value="{username}" required type="text">
            </div>
            <div class="form-group label-floating">
                <label class="control-label" for="focusedInput1">Password</label>
                <input class="form-control" name="password" id="focusedInput1" value="{password}" required type="password">
            </div>
            </div>
            <input class="btn btn-raised btn-default" type="submit" name="login" value="Log in">

    </form>
</div>


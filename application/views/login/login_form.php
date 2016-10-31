<p>
	<i>Log in by manually typing your username and password.</i>
</p>
<form action=<?php echo base_url() . 'index.php/login/manual' ?> method="POST">
	<label> Username: </label>
	<input type="text" name="username" placeholder="Username" value="{username}" required><br>
	<label> Password: </label>
	<input type="password" name="password" placeholder="Password" value="{password}" required><br>
	<input type="submit" name="login" value="Log in">
</form>

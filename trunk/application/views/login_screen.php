<?php
	$this->load->helper( 'url' );
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Login</title>
	</head>
	<body>
		<h1>Welcome to Grace Age</h1>

        <form action="login" method="POST">
            <label> Username: </label>
			<input type="text" name="username" placeholder="Username" value="{username}" required><br>
            <label> Password: </label>
            <input type="password" name="password" placeholder="Password" value="{password}" required><br>
            <input type="submit" name="login" value="Log in">
        </form>
		<br>

        <hr />
	</body>
</html>

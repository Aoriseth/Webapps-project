<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Grace Age: Resident</title>
	</head>
	<body>
		<h1>Grace Age: Residents</h1>

		{content}

		<hr />
		<form action=<?php echo base_url() ?> method="POST">
			<input type="submit" name="Home" value="Home">
		</form>

		<form action=<?php echo base_url().'index.php/logout' ?> method="POST">
			<input type="submit" name="logout" value="Logout">
		</form>

	</body>
</html>
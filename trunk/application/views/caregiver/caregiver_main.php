<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Grace Age: Caregiver</title>
	</head>
	<body>
		<h1>Grace Age: Caregiver</h1>
		<p>
			Hello {name}!
		</p>
		<hr />
		<form action=<?php echo base_url().'index.php/logout' ?> method="POST">
			<input type="submit" name="logout" value="Logout">
		</form>
	</body>
</html>

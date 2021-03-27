<!DOCTYPE html>
<html>
<head>
	<title>Log In</title>
</head>
<body>
	<form method="post">
		<table>
			<tr>
				<td>Username:</td>
				<td><input type="text" name="username" /></td>
			</tr>
			<tr>
				<td>Password:</td>
				<td><input type="text" name="password" /></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" name="login" value="Login" /></td>
			</tr>
			<tr>
				<td colspan="2"><a href="register.php">Register</a></td>
			</tr>
		</table>
	</form>
</body>
</html>
<?php
	include 'connect.php';
	if (isset($_POST['login'])) {
		$sql = "SELECT * FROM usersA WHERE username = '".$_POST['username']."' and password = '".$_POST['password']."'";
		$result = mysql_query($sql);
		$count = mysql_num_rows($result);
		if($count > 0) {
			session_start();
			$_SESSION['flag'] = 1;
			while ($row = mysql_fetch_array($result)) {
				$_SESSION['userId'] = $row['userId'];
			}
			header("Location: newsfeed.php");
		}
		else
			echo "<script>alert(\"Wrong\");</script>";
	}
?>
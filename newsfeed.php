<?php
	include 'session.php';
	include 'connect.php';

	if (isset($_POST['add']) && isset($_POST['add']) && $_POST['add'] != "") {
		$_SESSION['insert'] = 1;
		$userId =  $_SESSION['userId'];
		$date = date("Y-m-d h:i:s");
		$insert = "INSERT INTO comments VALUES ( null, '".$userId."', '".$date."', '".$_POST['text']."');";
		if(mysql_query($insert)) {
			header("Location: newsfeed.php");
			exit();
		}
	}
	if (isset($_POST['logout'])) {
		session_unset($_SESSION['flag']);
		session_destroy();
		header("Location: login.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Twitter</title>
	<script type="text/javascript">
		function isSaved() {
			alert("Yor comment has been inserted");
			return true;
		}
	</script>
</head>
<body>
	<form method="post">
		<input type="submit" name="logout" value="logout"/>
	</form>
	<!-- Display all comments made by all users -->
	<div>
		<table border="1">
			<tr>
				<th>Members</th>
				<th>Comments</th>
			</tr>
<?php
	$sql = "SELECT * FROM comments ORDER BY date DESC;";
	$result = mysql_query($sql);
	$num = mysql_num_rows($result);
	if ($num > 0) {
		while ($row = mysql_fetch_array($result)) {
?>
			<tr>
				<td>
<?php
	$txt = $row['date']."<br/>";
	$searchForUser = "SELECT * FROM usersA WHERE userId = '".$row['userId']."';";
	$resultForUser = mysql_query($searchForUser);
	while ($rowForUser = mysql_fetch_array($resultForUser)) {
		$txt .= "<strong>".$rowForUser['firstName']." ".$rowForUser['lastName']."</strong><br/>";
		$imageSRC = $rowForUser['profile'];
	}
	echo $txt;
?>
					<img src="<?php echo($imageSRC) ?>" width="25" height="25">
				</td>
				<td><?php echo $row['text']; ?></td>
			</tr>
<?php
		}
	} else {
?>
			<tr>
				<td colspan="2">No comments to display.</td>
			</tr>
<?php
	}
?>
		</table>
	</div>
	<br/><br>
	<hr>
	<br/><br>
	<!-- For Current user to insert a comment -->
	<div>
		<form method="post">
			<table>
				<tr>
					<td><label>Add Comment</label></td>
					<td><textarea name="text" rows="10" cols="20"></textarea></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="add" value="Post" onclick="return isSaved();"></td>
				</tr>
			</table>
		</form>
	</div>
</body>
</html>
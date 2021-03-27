<?php
	session_start();
	if (isset($_SESSION['flag']) && $_SESSION['flag'] == 1) {
		//header("Location: newsfeed.php");
	} else {
		header("Location: login.php");
	}
?>
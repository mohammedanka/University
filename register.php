<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
</head>
<body>
	<form method="post" enctype="multipart/form-data">
		<table>
			<tr>
				<td>First Name:</td>
				<td><input type="text" name="name"></td>
			</tr>
			<tr>
				<td>Last Name:</td>
				<td><input type="text" name="family"></td>
			</tr>
			<tr>
				<td>Userame:</td>
				<td><input type="text" name="username"></td>
			</tr>
			<tr>
				<td>Password:</td>
				<td><input type="text" name="password"></td>
			</tr>
			<tr>
				<td>profile:</td>
				<td>
					<input type="text" name="imageName">
					<input type="file" name="image" value="Browes" accept="image/*" onchange="displayImageName()">
				</td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" name="register" value="Register"></td>
			</tr>
		</table>
	</form>
</body>
</html>
<?php
	// function to generate random name for image
	function RandomString()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 5; $i++) {
            $randstring .= $characters[rand(0, strlen($characters))];
        }
        return $randstring;
    }

	if(isset($_POST["register"])) {
		
		include 'connect.php';

		// Check if username already exists
		$search = "SELECT * FROM usersa WHERE username = '".$_POST['username']."'";
		$result_1 = mysql_query($search);
		$num_1 = mysql_num_rows($result_1);
		if($num_1 == 0 ) {
			// directory and names
			$target_dir = "images/";
			$target_file = $target_dir . basename($_FILES["image"]["name"]);
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			$a = RandomString();
			$target_file = $target_dir . $a . "." . $imageFileType;

			// Check if image file is a actual image or fake image
			$check = getimagesize($_FILES["image"]["tmp_name"]);
		  	if($check !== false) {
		    	echo "File is an image - " . $check["mime"] . ".<br/>";
		    	$uploadOk = 1;
		  	} else {
		    	echo "File is not an image.<br/>";
		    	$uploadOk = 0;
		  	}

		  	// Check if file already exists
			if (file_exists($target_file)) {
				echo "Sorry, file already exists.<br/>";
			  	$uploadOk = 0;
			}

			// Check file size
			if ($_FILES["image"]["size"] > 5000000) {
			  	echo "Sorry, your file is too large.<br/>";
			  	$uploadOk = 0;
			}

			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
			  	echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br/>";
			  	$uploadOk = 0;
			}

			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
			  	echo "Sorry, your file was not uploaded.<br/>";
			// if everything is ok, try to upload file
			} else {
			  	if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
			    	echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded<br/>";
			    	echo "New file name is: " . $target_file . "<br/>";
			  	} else {
			    	echo "Sorry, there was an error uploading your file.";
			  	}
			}

			// insert data to database
			$sql = "INSERT INTO usersa VALUES ( null, '".$_POST['name']."', '".$_POST['family']."', '".$_POST['username']."', '".$_POST['password']."', '".$target_file."');";
			$result_2 = mysql_query($sql);
			header("Location: login.php");
		} else {
			echo "<script>alert(\"Username is not available\");</script>";
		}
	}
?>
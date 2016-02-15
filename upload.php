<?php
include "db_settings.php";
$name = $_FILES["myfile"]["name"];
$type = $_FILES["myfile"]["type"];
$size = $_FILES["myfile"]["size"];
$temp = $_FILES["myfile"]["tmp_name"];
$error = $_FILES["myfile"]["error"];
$target_path = __DIR__ . '/pics/';

if ($error > 0) {
	die("Error uploading. $error");
} else {
	if ($type == "image/png" || $type == "image/gif" || $type == "image/jpeg" || $type == "image/tif") {
		if ($size < 2000000) {
			move_uploaded_file($temp, $target_path.$name);
			$conn = new mysqli($server, $user, $pass, $dbname);
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			}
			$upload_name = $target_path . $name;
			$sql = "INSERT INTO `files` (name, type, path, size)
			VALUES ('$name', '$type', '$upload_name', $size)";
			
			if ($conn->query($sql) === TRUE) {
				echo "New record created successfully";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
				
			$conn->close();
			header( 'Location: pics/' . $name ) ;
			} else {
				die("File is too large");
	}}
	else {
		die("Invalid image format");
}}

?> 

 

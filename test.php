<?php 
require_once "php/database.php";
session_start();


	$name = "qwe";
	$res = $pdo -> query("SELECT * FROM users WHERE name = '$name'");
	echo $res->rowCount() < 1;

	if($res->rowCount() == 3){
		echo "string";
	}




?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form enctype="multipart/form-data" method="POST" action="">
		<input type="file" name="image">
		<input type="submit" name="submit">
	</form>
</body>
</html>
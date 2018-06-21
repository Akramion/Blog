<?php
require_once "php/database.php";

function save($name, $password)
{
	$name = trim($name);
	$password = trim($password);

	$name = htmlspecialchars($name);
	$password = htmlspecialchars($password);

	return array($name, $password);
}

if(isset($_POST['submit'])){
	$profile = save($_POST['name'], $_POST['password']);

	if(!empty($profile[0]) && !empty($profile[1])){
		$name = $profile[0];
		$password = $profile[1];
		$res = $pdo->query("SELECT * FROM users WHERE name = '$name' AND password = '$password'");
		
		if($res->rowCount() == 1){
			session_start();
			$_SESSION['name'] = $name;
			header('Location: http://projectforpractica/main.php');
		}

		else{
			echo "Неверный логин или пароль";
		}
	}

	else{
		echo "Не все поля заполнены";
		foreach ($_POST as $count){
			echo $count;
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/registr.css">
	<link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
	<div class="container">
		<div class="col-md-12">
			<div class="form-wrapper">
				<form action="" method="POST">
					<label for="name">Имя</label>
					<input type="text" name="name" id="name">
					<label for="password">Пароль</label>
					<input type="password" name="password" id="password">
					<input type="submit" name="submit" value="Авторизоваться">
					<a href="registr.php">Регистрация</a>
				</form>
			</div>
		</div>
	</div>






	<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>
</html>
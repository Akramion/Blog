<?php
require_once "php/database.php";

//Сохранение формы в массив
function save($name, $password, $email)
{
	$name = trim($name);
	$password = trim($password);
	$email = trim($email);

	$name = htmlspecialchars($name);
	$password = htmlspecialchars($password);

	return array($name, $password, $email);
}

//Проверка на нажатие кнопки
if(isset($_POST['submit'])){
	$profile = save($_POST["name"], $_POST["password"], $_POST["email"]);

	//Костыль
	$name = $profile['0'];
	$email = $profile['2'];


	//Проверка на заполненость полей
	if(!empty($profile[0]) && !empty($profile[1]) && !empty($profile[2])){

		//Проверка мыла и ника
		$res = $pdo -> query("SELECT * FROM users WHERE email = '$email'");
		$resName = $pdo -> query("SELECT * FROM users WHERE name = '$name'");

		//Проверка на дублирование емайла и ника
		if(($res->rowCount() == 0) && ($resName->rowCount() == 0)){

			//Сохранение файла
			$path = 'avatars/';
			$name = $_FILES["image"]["name"];
			$fullPath = $path . $name;

			//Загрузка аватарки на сервер
			if(move_uploaded_file($_FILES['image']['tmp_name'], $fullPath)){

				//Запрос с регистраций в базу данных
				$query = $pdo->prepare('INSERT INTO users(name,password,email,image) VALUES(?,?,?,?)');
				$profile[3] = $_FILES["image"]["name"];
				$query->execute($profile);
				header('Location: http://projectforpractica/login.php');
			}
			else{
				echo "Не удалось загрузить изображение";
			}

		}

		else{
			echo "Пользователь с таким email или ником уже зарегистрирован";
		}
	}


	else{
		echo "Не все поля заполнены";
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
				<form action="" method="POST" enctype="multipart/form-data">
					<label for="name">Никнейм</label>
					<input type="text" name="name" id="name" pattern="(?=.*[a-z]).{3,}" required="">
					<label for="password">Пароль</label>
					<input type="password" name="password" id="password" pattern="(?=.*\d)(?=.*[a-z]).{8,}" required="">
					<label for="email">Майл</label>
					<input type="email" name="email" id="email" required="">
					<label for="email">Выберите картинку</label>
					<input type="file" name="image" id="image">
					<input type="submit" name="submit" value="Регистрация">
				</form>
			</div>
		</div>
	</div>






	<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>
</html>
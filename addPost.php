<?php
require_once "php/database.php";

session_start();
date_default_timezone_set('UTC');

if(!isset($_SESSION['name'])){
	header('Location: http://projectforpractica/login.php');
}

function save($title, $text)
{
	$title = trim($title);
	$text = trim($text);

	$title = htmlspecialchars($title);
	$text = htmlspecialchars($text);

	return array($title ,$text);
}

if(isset($_POST['submit'])){
	$post = save($_POST["title"], $_POST["text"] );

	if(!empty($post[0]) && !empty($post[1])){
		$query = $pdo->prepare('INSERT INTO posts(title, text, name, date) VALUES(?,?,?,?)');
		$time = date('d.m.o');

		$post[2] = $_SESSION['name'];
		$post[3] = $time;
		$query->execute($post);
		header('Location: http://projectforpractica/main.php');
	}

	else{
		echo "Заполните поле";
	}
}

$name = $_SESSION['name'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" type="text/css" href="css/registr.css">
</head>
<body>

	<div class="container">
		<div class="col-md-12">
			<div class="form-wrapper">
				<form action="" method="POST">
					<label for="title">Введите заголовок</label>
					<textarea id="title" name="title" class="title"></textarea>
					<label for="text">Введите текст поста</label>
					<textarea id="text" name="text" class="postText"></textarea>
					<input type="submit" name="submit" value="Добавить">
				</form>
			</div>
		</div>
	</div>






	<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>
</html>
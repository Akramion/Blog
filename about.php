<?php
require_once "php/database.php";

session_start();
if(!isset($_SESSION['name'])){
	header('Location: http://projectforpractica/login.php');
}

function save($text)
{
	$text = trim($text);

	$text = htmlspecialchars($text);

	return $text;
}

if(isset($_POST['submit'])){
	$text = save($_POST["text"]);

	if(!empty($text)){
		$query = $pdo->prepare('UPDATE users SET about=? WHERE name=?');
		$data = array($text, $_SESSION['name']);
		$query->execute($data);
		header('Location: http://projectforpractica/main.php');
	}

	else{
		echo "Заполните поле";
	}
}

$name = $_SESSION['name'];
$about = $pdo -> query("SELECT about FROM users WHERE name = '$name'");
$about = $about->fetch();

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
					<label for="about">Введите информацию о себе</label>
					<textarea id="about" name="text"><?php echo $about['about']?></textarea>
					<input type="submit" name="submit" value="Добавить">
				</form>
			</div>
		</div>
	</div>






	<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>
</html>
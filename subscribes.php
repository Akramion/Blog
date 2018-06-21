<?php 
session_start();
if(!isset($_SESSION['name'])){
	header('Location: http://projectforpractica/login.php');
}
require_once "php/database.php";

$name = $_SESSION['name'];
$about = $pdo -> query("SELECT about FROM users WHERE name = '$name'");
$about = $about->fetch();

$image = $pdo -> query("SELECT image FROM users WHERE name = '$name'");
$image = $image->fetch();
$image = $image['image'];
$path = "avatars/" . $image;

$posts = $pdo -> query("SELECT * FROM posts WHERE name = '$name'");
$posts = $posts -> fetchAll();
$posts = array_reverse($posts);


if(isset($_POST['submit'])){
	$userName = $_SESSION['name'];
	$visitName = $_POST['name'];
	$res = $pdo -> query("SELECT * FROM subscriptions WHERE name = '$userName' AND subscriber = '$visitName'");
	if($res->rowCount() == 0){
		$data = array($_SESSION['name'], $visitName, date('d.m.o'));
		$query = $pdo->prepare('INSERT INTO subscriptions(name, subscriber,date) VALUES(?,?,?)');
		$query->execute($data);
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
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" type="text/css" href="css/subscribs.css">
</head>
<body>
	<div class="container">
		<header>
			<div class="row">
				<div class="logo">
					<a href="main.php"><img src="<?php echo $path?>" width="60px" height="60px"></a>
					<h2><?php echo $_SESSION['name'];?></h2>
					<form action="visit.php" method="POST">
						<input type="text" name="name" class="search text-search">
						<input type="submit" name="submit" class="search submit-search" value=" ">
					</form>
				</div>
				<div class="exit" ><a href="exit.php"></a></div>
			</div>
		</header>
		<div class="info">
			<div class="row">
				<div class="col-md-12">
					<p class="about"><?php echo $about['about'];?> <a href="about.php">Изменить</a></p>
				</div>
			</div>
		</div>
		<hr>
		<div class="row add-post">
			<div class="col-md-2">
				<a href="addPost.php">Добавить пост</a>
			</div>
		</div>

		
		<article>
			
			<div class="subscribs">
				<div class="logo">
					<img src="avatars/23565591.jpg.jpg" width="60px" height="60px">
				</div>
				<h3>Aleshka</h3>
				<p>29.03.2004</p>
			</div>
		</article>
		

		
		<hr>

		<footer>
			<div class="row">
				<div class="col-md-12">
					<p>Сделал Алёшка</p>
				</div>
			</div>
		</footer>

	</div>


	

	<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>
</html>
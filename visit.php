<?php 
session_start();
if(!isset($_SESSION['name'])){
	header('Location: http://projectforpractica/login.php');
}
require_once "php/database.php";


$name = htmlspecialchars($_POST['name']);
$res = $pdo -> query("SELECT * FROM users WHERE name = '$name'");
if($res->rowCount() == 0){
	header('Location: http://projectforpractica/main.php');
}

$about = $pdo -> query("SELECT about FROM users WHERE name = '$name'");
$about = $about->fetch();

$image = $pdo -> query("SELECT image FROM users WHERE name = '$name'");
$image = $image->fetch();
$image = $image['image'];
$path = "avatars/" . $image;

$posts = $pdo -> query("SELECT * FROM posts WHERE name = '$name'");
$posts = $posts -> fetchAll();
$posts = array_reverse($posts);




?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/index.css">
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
					<p class="about"><?php echo $about['about'];?></p>
				</div>
			</div>
		</div>
		<hr>

		<div class="row add-post">
			<div class="col-md-2">

			</div>
		</div>

		<?php foreach($posts as $post){?>
		<article>
			<div class="row">
				<div class="col-md-12 post">
					<div class="post-text">
						<h3><?php echo $post['title'];?></h3>
						<p class="post-text"><?php echo $post['text'];?></p>
						<div class="post-bottom">
							<div class="row">
								<div class="col-md-2">
									<time><?php echo $post['date'];?></time>
								</div>
								<div class="col-md-2 col-md-offset-8">
									<a href="#">Читать</a>
								</div> 
							</div>
						</div>
					</div>
				</div>
			</div>
		</article>
		<?php }?>

		
		<hr>

		<footer>
			<div class="row">
				<div class="col-md-12">
					<p>Сделал Бушуев Алексей</p>
				</div>
			</div>
		</footer>

	</div>


	

	<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>
</html>
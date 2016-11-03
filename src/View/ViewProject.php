<!DOCTYPE html>
<?php
	include '../Controler/ControlerInclude.php';
	cleanInclude();
	include '../Controler/ControlerProject.php';
	//$currProject = getProjectById($_POST["id"]);
	$currProject = mysqli_fetch_array(launchQuery("SELECT * FROM Project WHERE id = '1'"),MYSQLI_ASSOC);
?>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Projet <?php echo $currProject['title']; ?> </title>
	<link rel="stylesheet" href="../css/bootstrap.css"> 
	<link rel="stylesheet" href="../css/index.css"> 
</head>
<body>
	<?php include 'ViewMenuBar.php' ?>
	<h1>Project : </h1> <h2 style="color:red;"> <?php echo $currProject['title']; ?></h2>
	<h3>ScrumMaster</h3>
	<?php echo $currProject['scrummaster']; ?>
	<h3>ProductOwner</h3>
	<?php echo $currProject['productowner']; ?>
	<h3>KanBan</h3>
	<h3>Listes Des Tâches</h3>
	<h3>Matrice de Traçabilité</h3>
	<h3>UserStory</h3>
	<h3>Sprint</h3>
</body>
</html>


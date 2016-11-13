<!DOCTYPE html>
<?php
	include '../Controler/ControlerInclude.php';
	cleanInclude();
	include '../Controler/ControlerProject.php';
	$currProject = getProjectById($_GET["projet"]);
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
		<div class="panel panel-info">
			<div class="panel-heading">
				<h1 class="panel-title"><strong> Projet: <?php echo $currProject['title']; ?></strong></h3>
				<div class="panel-body">
					<h3>ScrumMaster</h3>
					<?php echo $currProject['scrummaster']; ?>
					<h3>ProductOwner</h3>
					<?php echo $currProject['productowner']; ?>
					
					<h3>KanBan</h3>
					<h3>Listes Des Tâches</h3>
					<h3>Matrice de Traçabilité</h3>
					<h3>UserStory</h3>
					<h3>Sprint</h3>
					
					<?php if(showButton($currProject)){ ?>
						<div class="littlespace">
							<a href="ViewAlterProject.php?id=<?php echo $currProject['id']; ?>" class="btn btn-default">Modifier le projet</a>
							<a href="todo.php?id=<?php echo $currProject['id']; ?>" class="btn btn-default">Ajouter un contributeur</a>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
</body>
</html>

<?php

	function showButton($currentProject){

		if(!isset($_SESSION['pseudo']))
			return FALSE;
		if(isContributor($currentProject['id']))
			return TRUE;
		return FALSE;

	}

	
	
?>
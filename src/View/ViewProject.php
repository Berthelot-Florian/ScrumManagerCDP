<!DOCTYPE html>
<?php
	include '../Controler/ControlerInclude.php';
	cleanInclude();
	include '../Controler/ControlerProject.php';
	include '../Controler/ControlerUser.php';
	$currProject = getProjectById($_GET["projet"]);
?>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Projet <?php echo $currProject['title']; ?> </title>
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/font-awesome-4.7.0/css/font-awesome.css">
	<link rel="stylesheet" href="../css/index.css">
</head>
<body>
	<?php include 'ViewMenuBar.php' ?>
		<div class="panel panel-info">
			<div class="panel-heading">
				<center>
				<h1 class="panel-title"><strong> Projet: <?php echo $currProject['title']; ?></strong></h3>
				<div class="panel-body">
					
					<h3>ScrumMaster</h3>
					<?php echo getUserByID($currProject['scrummaster'])[3]; ?>
					<h3>ProductOwner</h3>
					<?php echo getUserByID($currProject['productowner'])[3]; ?>
					
					<h3>Listes Des Tâches</h3>
					<h3>Matrice de Traçabilité</h3>
					<a style="text-decoration:none" href="ViewUS.php?projet=<?php echo $currProject['id'];?>">
						<h3>UserStory</h3>
					</a>
					<h3>Sprint</h3>
					<?php if(!showButton($currProject)){ ?>
						<div class="littlespace">
							<a href="ViewAlterProject.php?id=<?php echo $currProject['id']; ?>" class="btn btn-default">Modifier le projet</a>
							<a href="ViewAddProjectContributor.php?id=<?php echo $currProject['id']; ?>" class="btn btn-default"><i class="fa fa-plus"></i> Ajouter 
							un contributeur</a>
							<a href="ViewAnnexe.php?projet=<?php echo $currProject['id']; ?>" class="btn btn-default"> Ajouter un annexe</a>
							<a href="ViewUS.php?projet=<?php echo $currProject['id']; ?>" class="btn btn-default"> Voir les UserStory (Kanban)</a>
						</div>
					<?php } ?>
					</center>
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
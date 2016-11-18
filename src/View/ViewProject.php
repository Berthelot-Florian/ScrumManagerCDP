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
				<h1 class="panel-title"><strong> Projet: <?php echo $currProject['title']; ?></strong></h3>
				<div class="panel-body">
					<h3>ScrumMaster</h3>
					<?php echo getUserByID($currProject['scrummaster'])[3]; ?>
					<h3>ProductOwner</h3>
					<?php echo getUserByID($currProject['productowner'])[3]; ?>
					<h3>Contributors</h3>
					<?php
						$users = getAllUsers(); 
						while($row = mysqli_fetch_array($users,MYSQLI_ASSOC)){
							if($row['id']==$currProject['scrummaster'] || $row['id']==$currProject['productowner'])
								;
							else
								echo "$row[pseudo] ";
						}
					?>
					<h3>KanBan</h3>

					<h3>Listes Des Tâches</h3>
					<h3>Matrice de Traçabilité</h3>
					<a style="text-decoration:none" href="ViewUS.php?projet=<?php echo $currProject['id'];?>">
						<h3>UserStory</h3>
					</a>
					<h3>Sprint</h3>
					<h3>Annexes</h3>
					<a href="ViewAnnexe.php?projet=<?php echo $currProject['id']; ?>" class="btn btn-default"><i class="fa fa-eye"></i> Voir les annexes</a>
					<?php if(settingsMenu($currProject)){ ?>
						<div class="panel panel-danger">
							<div class="panel-heading">	
								<h1 class="panel-title"><strong>Modification du projet</strong></h1>
								<br>
								<a href="ViewAlterProject.php?id=<?php echo $currProject['id']; ?>" class="btn btn-default">Modifier le projet</a>
								<a href="ViewAddProjectContributor.php?id=<?php echo $currProject['id']; ?>" class="btn btn-default"><i class="fa fa-plus"></i> Ajouter un contributeur</a>
								<a href="ViewDeleteProjectContributor.php?id=<?php echo $currProject['id']; ?>" class="btn btn-default"><i class="fa fa-minus-circle"></i> Supprimer un contributeur</a>
								<a href="ViewAjoutUS.php?projet=<?php echo $currProject['id']; ?>" class="btn btn-default"><i class="fa fa-plus"></i> Ajouter US</a>
								<!--<a href="ViewUS.php?projet=<?php echo $currProject['id']; ?>" class="btn btn-default"> Voir les UserStory (Kanban)</a>-->
								<a href="ViewAnnexe.php?projet=<?php echo $currProject['id']; ?>" class="btn btn-default"><i class="fa fa-plus"></i> Ajouter un annexe</a>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
</body>
</html>

<?php

	function settingsMenu($currentProject){

		if(!isset($_SESSION['pseudo']))
			return FALSE;
		if(isContributor($currentProject['id']))
			return TRUE;
		return FALSE;

	}

	
	
?>
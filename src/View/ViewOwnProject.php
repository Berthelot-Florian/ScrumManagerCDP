<!DOCTYPE html>
<html>
    <head>
		<?php
	    	if(!isset($_SESSION['ControlerInclude']))
				include '../Controler/ControlerInclude.php';
			if(!isset($_SESSION['ControlerBdd']))
				include '../Controler/ControlerBdd.php';
			if(!isset($_SESSION['Variables']))
					require '../Model/Variables.php';
			if(!isset($_SESSION['ControlerUser']))
					include '../Controler/ControlerUser.php';
			if(!isset($_SESSION['ControlerProject']))
					include '../Controler/ControlerProject.php';
	 	?>
		
        <meta charset="utf-8" />
        <title>Titre</title>
		<link rel="stylesheet" href="../css/bootstrap.css"> 
		<link rel="stylesheet" href="../css/index.css"> 
    </head>
	<body>
	
	<?php include 'ViewMenuBar.php' ?>
	<?php
	
		$result = getAllProjectByPOID($_SESSION['id']);
		?>
		</br>
		<center>
				<legend>
					Liste des projets où vous êtes ProductOwner
				</legend>
		</center>		
		<?php
		if(mysqli_num_rows($result)==0){
			?>
			<!--- Si l'utilisateur n'est pas popriétaire -->
			<center>
			Vous n'êtes ProductOwner d'aucun projet
			</center>
		
		<?php
		}
		else{
			while($data = $result->fetch_array(MYSQLI_NUM))
				{
					?>
					<!--- Affichage de chaque projet -->
					<a style="text-decoration:none" href="ViewProject.php?projet=<?php echo $data[0];?>">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title"><strong><?php echo $data[1]; ?></strong></h3>
								<div class="panel-body">
									<strong>ScrumMaster : </strong><?php $row = getUserByID($data[3]); echo $row[3]; ?> <br/>
									<strong>ProductOwner : </strong><?php $row = getUserByID($data[3]); echo $row[3]; ?> <br/>
									<strong>Description : </strong><?php echo $data[4]; ?> <br/>
								</div>
							</div>
						</div>
					</a>
					<?php
				}
		}
		
		$result = getAllProjectByScMaID($_SESSION['id']);
		?>
		</br>
		<center>
				<legend>
					Liste des projets où vous êtes ScrumMaster
				</legend>
		</center>
		<?php
		if(mysqli_num_rows($result)==0){
			?>
			<!--- Si l'utilisateur n'est pas popriétaire -->
			<center>
				Vous êtes ScrumMaster d'aucun projet
			</center>
			
		<?php
		}
		else{
			while($data = $result->fetch_array(MYSQLI_NUM))
				{
					?>
					<!--- Affichage de chaque projet -->
					<a style="text-decoration:none" href="ViewProject.php?projet=<?php echo $data[0];?>">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title"><strong><?php echo $data[1]; ?></strong></h3>
								<div class="panel-body">
									<strong>ScrumMaster : </strong><?php $row = getUserByID($data[3]); echo $row[3]; ?> <br/>
									<strong>ProductOwner : </strong><?php $row = getUserByID($data[3]); echo $row[3]; ?> <br/>
									<strong>Description : </strong><?php echo $data[4]; ?> <br/>
								</div>
							</div>
						</div>
					</a>
					<?php
				}
		}
		
		$result = getAllProjectByScMaID($_SESSION['id']);
		?>
		</br>
		<center>
				<legend>
					Liste des projets où vous êtes Contributeur
				</legend>
		</center>
		<?php
		if(mysqli_num_rows($result)==0){
			?>
			<!--- Si l'utilisateur n'est pas popriétaire -->
			<center>
			Vous êtes Contributeur d'aucun projet
			</center>
			
		<?php
		}
		else{
			while($data = $result->fetch_array(MYSQLI_NUM))
				{
					$rest = getProjectById($data[0]);
					?>
					<!--- Affichage de chaque projet -->
					<a style="text-decoration:none" href="ViewProject.php?projet=<?php echo $data[0];?>">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title"><strong><?php echo $rest['title']; ?></strong></h3>
								<div class="panel-body">
									<strong>ScrumMaster : </strong><?php $row = getUserByID($rest['scrummaster']); echo $row[3]; ?> <br/>
									<strong>ProductOwner : </strong><?php $row = getUserByID($rest['productowner']); echo $row[3]; ?> <br/>
									<strong>Description : </strong><?php echo $rest['description']; ?> <br/>
								</div>
							</div>
						</div>
					</a>
					<?php
				}
		}
		?>

    </body>
</html>

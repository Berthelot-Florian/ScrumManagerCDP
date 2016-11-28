<!DOCTYPE html>

<html lang="fr">
 	<head>
	    <meta charset="utf-8">
	    <title>ViewSprint</title>
	    <?php
	    	include '../Controler/ControlerInclude.php';
	    	cleanInclude();
	    	// Include pour les fonction php 
	    	require '../Controler/ControlerUser.php';
	 		require '../Controler/ControlerProject.php';
	 		require '../Controler/ControlerSprint.php';
	 	?>

	    <link rel="stylesheet" href="../css/bootstrap.css"> 
		<link rel="stylesheet" href="../css/index.css"> 
  	</head>

  	<body>
  		<?php include 'ViewMenuBar.php'; ?>

  		<?php 
  		$projet = $_GET["projet"];
  		$sprint = $_GET["sprint"];
  		$infoprojet = getProjectById($projet);
  		echo "<h2> Visualisation d'un sprint ".$infoprojet['title']."</h2>";
  		?>
  		<table>
  			<thead>
  				<tr>
  					<td> Numero du sprint </td>
  					<td> Début du sprint </td>
  					<td> Fin du sprint </td>
  					<td> Etat du sprint </td>
  					<td> Action du le sprint </td>
  				</tr>
  			</thead>
  			<tbody>
  				<tr>
  					<?php 
  						echo "<td>".$infoprojet['number']."</td>";
  						echo "<td>".$infoprojet['start']."</td>";
  						echo "<td>".$infoprojet['end']."</td>";
  						echo "<td>".$infoprojet['state']."</td>";
  						echo "<td> 	Modifier
  									Supprimer</td>";
  					?>
  				</tr>
  			</tbody>
  		</table>
  		<h2> Visualisation des UserStory  associé et des tâche</h2>

  		<table>
  			<thead>
  				<tr>
  					<td> Description </td>
  					<td> Effort </td>
  					<td> Etat </td>
  					<td> UserStory associé </td>
  					<td> Description de la UserStory </td>
  				</tr>
  			<tbody>
  			<?php 
  				//Récupération des tâches et affichage 
  			?> 

  			</tbody>
  	</body>
</html>
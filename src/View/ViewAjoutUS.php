<!DOCTYPE html>

<html lang="fr">
 	<head>
	    <meta charset="utf-8">
	    <title>AjoutUserStory</title>
	    <?php
	    	include '../Controler/ControlerInclude.php';
	    	cleanInclude();
	    	// Include pour les fonction php 
	    	require '../Controler/ControlerUser.php';
	 		require '../Controler/ControlerUS.php';
	 		require '../Controler/ControlerProject.php';
	 		require '../Controler/ControlerSprint.php';
	 	?>

	    <link rel="stylesheet" href="../css/bootstrap.css"> 
		<link rel="stylesheet" href="../css/index.css"> 
  	</head>
  	<body>
	  	<?php
	    	include 'ViewMenuBar.php';
	 	?>	
	 	
	 	<?php 
	 		$projet = $_GET["projet"];
	 		$res = getProjectById($projet);
	 		echo "<a class=\"btn btn-default\" href=\"ViewUS.php?projet=$projet\">" . "Retour sur la page des UserStory."."</a>";
	 		echo "<center>";
	 		echo "<h2> Ajouter des UserStory pour le projet : ".$res['title']."</h2>";
	 		//Testons si l'utilisateur a lancé le formulaire
	 		if(isset($_POST['action']) && isset($_POST['rank']) && isset($_POST['goals']) ) {
	 			//Testons si tout les champs sont correctement remplis
	 			if(strlen($_POST['action'])>1 && strlen($_POST['rank'])>1 && strlen($_POST['goals'])>1 ) {
	 				//Ajout de la US
	 				if(AddUs($projet,$_POST['sprint'],$_POST['rank'],$_POST['action'],$_POST['goals'],$_POST['diff'])){
	 					echo "<h3>User Story correctement envoyé</h3>";	
	 				}
	 			} else {
	 				echo "<h3>Tout les champs doivent être remplis</h3>";
	 			}
	 			
	 		}
			 	
	 		$projet = $_GET["projet"];
	 		if(!isContributor($projet)){
	 			echo '<h2> Vous n\'êtes pas contributeur de ce projet, vous ne pouvez pas le modifier</h2>';
	 		} else {
	 			
	 			echo "<form action=\"ViewAjoutUS.php?projet=".$projet."\" method=\"post\" >";
	 	?>
	 	<br />
	 	<br />
	 	<table class="Anntable">
	 		<tbody>
	 			<tr>
	 				<td> En tant que : </td>
	 				<td> <textarea type="text" name="rank" rows="2" cols="30"> </textarea></td>
				</tr>
				<tr>
					<td> Je souhaite pouvoir : </td>
					<td> <textarea type="text" name="action" rows="2" cols="30"> </textarea></td>
				</tr>
				<tr>
					<td> Dans le but de : </td>
					<td> <textarea type="text" name="goals" rows="2" cols="30"> </textarea></td>
				</tr>
				<tr>
					<td>Difficulté :</td>
					<td>
						<select name="diff" class="objForm">
							<?php 
								for ($i = 1; $i <= 100; $i++) {
								    echo "<option value=".$i.">".$i."</option>";
								}	
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Sprint :</td>
					<td>

						<select name="sprint" class="objForm">
							<?php
								$sprints = getSprints($projet);
								
								while($sprint = mysqli_fetch_array($sprints,MYSQLI_ASSOC)){
									echo "<option value=".$sprint['number'].">".$sprint['number']."</option>";
								}	
							?>
						</select>
						
					</td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" value="Envoyer" /></td>
				</tr>
			</tbody>
		</table>
	 					
	 					<?php 
						while($sprint = mysqli_fetch_array($sprints,MYSQLI_ASSOC)){
							print_r($sprint);
							printf("coucou");
						}
						 ?>
	 	<?php echo "</form>";
	 	}?>
	 	</center>

	</body>
</html>

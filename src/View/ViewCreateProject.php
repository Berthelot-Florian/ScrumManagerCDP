<!DOCTYPE html>

<html lang="fr">
 	<head>
	    <meta charset="utf-8">
	    <title>CreateProject</title>
	    <?php
	    	// Include pour les fonction php 
	    	require '../Controler/ControlerUser.php';
	 		require '../Controler/ControlerProject.php';
	 	?>
	    <link rel="stylesheet" href="../Style/styleCreateProject.css"> 
  	</head>
  	
  	<body>
    	<h1 class="title">Create New Project</h1>
		<?php 
			// Si le formulaire a été lancé, on lance la requête sur la BDD sinon on ne fait rien
			if($_POST['req']==1){
				if(AddProject($_POST['title'],$_POST['ProductOwner'],$_POST['ScrumMaster'],$_POST['description'])){
					echo '<p>La requête s\'est correctement effectuee</p>';
				} else {
					echo '<p>La requête ne s\'est pas correctement effectuee</p>';
				}
			}
		?>
		<!--- FORMULAIRE DE CREATION DE PROJET -->
		<form method="post" action="ViewCreateProject.php">
			<label class="label">Project name :</label>
			<br />
			<input type="text" name="title"  class="objForm">
			<br />
			<label class="label">ScrumMaster : </label>
			<br />
			<select name="ScrumMaster" class="objForm">
				<?php
				// On ajoute comme choix possible tout les utilisateurs qui existe
					$users = getAllUsers(); 
					while($row = mysqli_fetch_array($users,MYSQLI_ASSOC)){
						echo "<option value=\"$row[id]\">$row[pseudo]</option>";
					}
				?>
			</select>
			<br />
			<label class="label">ProductOwner : </label>
			<br />
			<select name="ProductOwner" class="objForm">
				<?php
				// On ajoute comme choix possible tout les utilisateurs qui existe 
					$users = getAllUsers(); 
					while($row = mysqli_fetch_array($users,MYSQLI_ASSOC)){
						echo "<option value=\"$row[id]\">$row[pseudo]</option>";
					}
				?>
			</select>
			<br />
			<label class="label" name="description">Description : </label>
			<br />
	 		<textarea name="ameliorer" class="objForm" rows="10" cols="50">	</textarea>       
	 		<br />
			<input type="hidden" name="req" value="1">
			<input type="submit" name="Create New Project" value="Envoyer" class="subForm"/>
		</form>
  </body>
</html>
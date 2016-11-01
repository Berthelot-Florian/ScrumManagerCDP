<!DOCTYPE html>

<html lang="fr">
 	<head>
	    <meta charset="utf-8">
	    <title>CreateProject</title>
	    <?php
	    	include '../Controler/ControlerInclude.php';
	    	// Include pour les fonction php 
	    	require '../Controler/ControlerUser.php';
	 		require '../Controler/ControlerProject.php';
	 	?>

	    <link rel="stylesheet" href="../css/bootstrap.css"> 
		<link rel="stylesheet" href="../css/index.css"> 
  	</head>

  	<body>
	  	
	<?php
	    	include 'ViewMenuBar.php';
	 	?>
	
		<?php 
			// Si le formulaire a été lancé, on lance la requête sur la BDD sinon on ne fait rien
			if(isset($_POST['req'])){
				$title = $_POST['title'];
				AddProject($title,$_POST['productowner'],$_POST['scrummaster'],$_POST['description']);
			}
		?>
		
		
		<!--- FORMULAIRE DE CREATION DE PROJET -->
		<center>
			
				<form method="post" action="ViewCreateProject.php">
					<fieldset>
						<h2>Nom du Projet</h2><input type="text" name="title"/>
						<h2>ScrumMaster</h2>
							<select name="scrummaster" class="objForm">
								<?php
								// On ajoute comme choix possible tout les utilisateurs qui existe
								$users = getAllUsers(); 
								while($row = mysqli_fetch_array($users,MYSQLI_ASSOC)){
									echo "<option value=\"$row[id]\">$row[pseudo]</option>";
								}
								?>
							</select>
							<div class="littlespace">
						<h2>ProductOwner</h2>
							<select name="productowner" class="objForm">
								<?php
								// On ajoute comme choix possible tout les utilisateurs qui existe 
								$users = getAllUsers(); 
								while($row = mysqli_fetch_array($users,MYSQLI_ASSOC)){
									echo "<option value=\"$row[id]\">$row[pseudo]</option>";
								}
								?>
							</select>
						</div>							
						<label class="label" name="description">Description : </label>
						<br />
						<textarea name="description" class="objForm" rows="10" cols="50">	</textarea>       
						<br />
						
						<input type="hidden" name="req" value="1">
						<input type="submit" name="Create New Project" value="Envoyer" class="btn btn-default"/>

		</form>
  </body>
</html>
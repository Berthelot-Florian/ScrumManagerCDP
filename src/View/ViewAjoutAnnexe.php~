<!DOCTYPE html>

<html lang="fr">
 	<head>
	    <meta charset="utf-8">
	    <title>AjoutAnnexe</title>
	    <?php
	    	include '../Controler/ControlerInclude.php';
	    	cleanInclude();
	    	// Include pour les fonction php 
	    	require '../Controler/ControlerUser.php';
	 		require '../Controler/ControlerAnnexe.php';
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
 		echo "<a class=\"btn btn-default\" href=\"ViewAnnexe.php?projet=$projet\">" . "Retour sur la page des annexes."."</a>";
	 	echo "<br />";	
	 	echo "<br />";	
	 	//Test de l'envois du fichier 
	 	if(isset($_FILES['file'])) {
	 		//Test d'une eventuel erreur
	 		if($_FILES['file']['error'] == 0){
	 			//TEst de la taille du fichier 
	 			if ($_FILES['file']['size'] <= 1000000){
	 				//Test du format si il est signaler comme une image
	 				if( strcmp($_POST["type"],"image")==0){
		 				$infosfichier = pathinfo($_FILES['file']['name']);
		                $extension_upload = $infosfichier['extension'];
		                $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
		                if (in_array($extension_upload, $extensions_autorisees)){
		               		if(addAnnexe($projet,$_FILES['file']['name'],$_POST['type'])){
		               			move_uploaded_file($_FILES['file']['tmp_name'], '../Annexes/' . basename($_FILES['file']['name']));
		               			echo "<h3>Annexe ajouter avec succés</h3>";
		               		}
		                } else {
		                	echo "<h3>L'extension n'est pas autorisé en tant qu'image</h3>";
		                }
		            } else {
		            	if(addAnnexe($projet,$_FILES['file']['name'],$_POST['type'])){
		            		move_uploaded_file($_FILES['file']['tmp_name'], '../Annexes/' . basename($_FILES['file']['name']));
		               			echo "<h3>Annexe ajouter avec succés</h3>";
		            	}	
		            }
        		} else {
        			echo "<h3>Le Fichier que vous souhaitez mettre en annexe est trop volumineux</h3>";
        		}

	 		} else {
	 			echo "<h3> Il y a eu une erreur lors de l'envois de votre fichier</h3>";
	 		}
	 	} 
	 	?>
	 	<?php 
	 		$projet = $_GET["projet"];
	 		if(isContributor($projet)){
	 			echo '<h2> Vous n\'êtes pas contributeur de ce projet, vous ne pouvez pas le modifier</h2>';
	 		} else {
	 			echo "<form action=\"ViewAjoutAnnexe.php?projet=".$projet."\" method=\"post\" enctype=\"multipart/form-data\">";

	 			echo '<center>';
				echo "<h2> Fichier à ajouter en annexe </h2><br />";
				echo "<input type=\"file\" name=\"file\" /><br />";
				echo "<select name=\"type\" class=\"objForm\">";
				echo "<option value=\"image\">Image</option>";
				echo "<option value=\"Autre\">Autre</option>";
				echo "</select><br />"; 
				echo "<input type=\"hidden\" "  . "name=\"idProjet\" " . "value=\"$projet\""  . "/>" ;
				echo "<br />";
				echo "<input type=\"submit\" value=\"Ajouter l'annexe\" />";
			 	echo "</form>";
	 		}
	 		
	 	?>
	 	
	 	
	 	
	 	

  </body>
</html>
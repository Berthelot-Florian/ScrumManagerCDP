<!DOCTYPE html>

<html lang="fr">
 	<head>
	    <meta charset="utf-8">
	    <title>ViewTracabilite</title>
	    <?php
	    	include '../Controler/ControlerInclude.php';
	    	cleanInclude();
	    	// Include pour les fonction php 
	    	require '../Controler/ControlerUser.php';
	 		require '../Controler/ControlerUS.php';
	 		require '../Controler/ControlerTracab.php';
	 		require '../Controler/ControlerProject.php';
	 		?>
 	 	<link rel="stylesheet" href="../css/bootstrap.css">
		<link rel="stylesheet" href="../css/font-awesome-4.7.0/css/font-awesome.css">
		<link rel="stylesheet" href="../css/index.css">
		<link rel="stylesheet" href="../css/popup.css">
  	</head>
  	<body>

  		<?php
	    	include 'ViewMenuBar.php';
	 	?>	

	 	<?php 
	 		//Si on veut modifier un sprint
	 		$projet = $_GET["projet"];
	 		$res = getProjectById($projet);
			if(isset($_GET["sprint"]))
				$sprint = $_GET["sprint"];
	 		$tracab = getTracab($projet);
	 		$size   = mysqli_num_rows($tracab);
	 		echo "<h2>Ajout/modification de la tracabilité : ".$res['title']."</h2>";
	 		echo "<a class=\"btn btn-default\" href=\"ViewProject.php?projet=$projet\">" . "Retour à la page du projet"."</a>";
	 		echo "<br />";
	 		echo "<a class=\"btn btn-default\" href=\"ViewMatTracabilite.php?projet=$projet\">" . "Retour à la page tracabilité"."</a>";
	 		if(isset($_GET['sprint'])){
	 			$info = getTracabSp($projet,$sprint);
 				$info = mysqli_fetch_array($info,MYSQLI_ASSOC);

	 		} else {
	 			$sprint = $size+1;
	 		}
	 	?>
	 	<center>
	 	<form method="post" action="../Handler/tracab.php">
	 		<h3>Projet</h3> 
	 		<input type="text" value="<?php echo "$projet" ?>" name="projet" readonly="true"/>

	 		<h3>Sprint</h3> 
	 		<input type="text" value="<?php echo "$sprint" ?>" name ="sprint" <?php if(isset($_GET['sprint'])) echo "readonly=\"true\"" ?> />

	 		<h3>Commit</h3> 
	 		<?php  
	 		
	 			if(!isset($_GET['sprint'])){ 
	 				echo "<input type=\"text\"  name=\"commit\"/>";
	 			} else {
	 				echo "<input type=\"text\"  name=\"commit\" value=".$info['commit']." />";
	 			}
	 		?>

	 		<h3>liens</h3> 
	 		<?php 
	 			
	 			if($size > 0){
	 				$tra = mysqli_fetch_array($tracab,MYSQLI_ASSOC);
	 				echo "<input type=\"text\" value=".$tra['link']." name=\"link\"/>"; 
	 			} else {
	 				echo "<input type=\"text\"  name=\"link\"/>"; 
	 			}
	 			echo "<br />";
	 			echo "<br />";
	 			if(isset($_GET['sprint'])){
	 				echo "<input type=\"submit\" value=\"Modifier\" /> ";
	 			} else {
	 				echo "<input type=\"submit\" value=\"Ajouter\" /> ";
	 			}
	 		?>

	 		



	 	</form>

  	</body>
 </html>
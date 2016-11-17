<!DOCTYPE html>

<html lang="fr">
 	<head>
	    <meta charset="utf-8">
	    <title>Annexe</title>
	    <?php
	    	include '../Controler/ControlerInclude.php';
	    	cleanInclude();
	    	// Include pour les fonction php 
	    	require '../Controler/ControlerUser.php';
	 		require '../Controler/ControlerAnnexe.php';
	 		require '../Controler/ControlerProject.php';
	 	?>

	    <link rel="stylesheet" href="../css/bootstrap.css"> 
		<link rel="stylesheet" href="../css/index.css"> 
  	</head>
  	<body>
	  	<?php
	    	include 'ViewMenuBar.php';
	 	?>	
	 	
	 		<center>
	 			
	 			<?php 
			 		$projet = $_GET["projet"];
			 		$res = getProjectById($projet);
			 		echo "<h2> Annexe pour le projet : ".$res['title']."</h2>";
			 	?>
	 		</center>
	 	<br /><br />
	 	<?php 
	 		$projet = $_GET["projet"];
	 		
	 		echo "<a class=\"btn btn-default\" href=\"ViewAjoutAnnexe.php?projet=$projet\">"."Ajouter un document annexe au projet"."</a>";
 			echo "<br />";	
	 		echo "<br />";	
	 		$Annexe = getAnnexe($projet);
	 		echo "<center>";
	 		echo "<table class=\"Anntable\">"."<thead class=\"annThd\">";
	 		echo "<tr>";
	 		echo "<td>Type</td>";
	 		echo "<td>Nom</td>";
	 		echo "<td>Liens vers le document</td>";
	 		echo "<td>Supprimer ce document</td>";
	 		echo "</tr>";
	 		echo "</thead>";

	 		if(isContributor($projet)){
	 			while($row = mysqli_fetch_array($Annexe,MYSQLI_NUM)){
	 			echo "<tr>";
	 			echo "<td>".$row[3]."</td>";
	 			echo "<td>".$row[2]."</td>";
	 			echo "<td>"."<a href=\"../Annexes/$row[2]\">"."Afficher ce document"."</a>"."</td>";
	 			echo "<td>"."<a href=\"../Handler/suppAnnexe.php?file=$row[2]&projet=$projet\">"."Supprimer"."</a>"."</td>";
	 			echo "</tr>";
	 			}	
	 		} else {
	 			echo "<tr><td>Vous n'êtes pas contributeur</td><td></td><td></td><td></td></tr>";
	 		}
	 		
	 		echo "</table>";

	 	?>




	 	  </body>
</html>
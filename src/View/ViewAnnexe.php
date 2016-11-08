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
	 			<h2> Annexe pour le projet : </h2>
	 			<?php 
			 		$projet = $_GET["projet"];
			// 		$result = getProjetById($projet);
			// 		echo "<h3>".$result["titre"]."</h3>";
			 	?>
	 		</center>
	 	<br /><br />
	 	<?php 
	 		$projet = $_GET["projet"];
	 		echo "<a class=\"btn btn-default\" href=\"ViewAjoutAnnexe.php?projet=$projet\">" . "Ajouter un document annexe au projet"."</a>";
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

	 		while($row = mysqli_fetch_array($Annexe,MYSQLI_NUM)){
	 			echo "<tr>";
	 			echo "<td>".$row[2]."</td>";
	 			echo "<td>".$row[1]."</td>";
	 			echo "<td>"."<a href=\"../Annexes/$row[1]\">"."Afficher ce document"."</a>"."</td>";
	 			echo "<td>"."<a href=\"../Handler/suppAnnexe.php?file=$row[1]&projet=$projet\">"."Supprimer"."</a>"."</td>";
	 			echo "</tr>";
	 		}
	 		echo "</table>";

	 	?>




	 	  </body>
</html>
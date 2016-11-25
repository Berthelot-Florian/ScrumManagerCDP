<!DOCTYPE html>

<html lang="fr">
 	<head>
	    <meta charset="utf-8">
	    <title>CreateSprint</title>
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
		  	$infoprojet = getProjectById($projet);
	 		if(!isContributor($projet)){
	 			echo '<h2> Vous n\'êtes pas contributeur de ce projet, vous ne pouvez ajouter un sprint à ce projet</h2>';
	 		} else {
	 			echo '<h2> Ajout d\'un sprint au projet '.$infoprojet['title']."</h2>";
	 			//On vérifie que num est bien mis pour savoir si on viens sur la page ou si on a lancer le formulaire
	 			if(isset($_POST['num'])){
	 				//On vérifie que tout les champs on été remplis
		 			if(isset($_POST['start']) && isset($_POST['start']) ){
		 				$start 	= $_POST['start'];
		 				$end 	= $_POST['end'];
		 				$num 	= $_POST['num'];
		 				if(checkNumSprint($projet,$num)){
		 					// ON vérifie que les dates sont valide
		 					if(check_Date($start) && check_Date($end)){
		 						//On vérifie que la fate de début est bien avant celle de fin 
		 						if(check_Date2 ($start,$end)){
		 							addSprint($projet,$num,dateToGoodFormat($start),dateToGoodFormat($end));
		 						} else {
		 						echo '<h2> La date de début doit être avant la date de fin du sprint </h2>';
		 						}
		 					} else {
		 						echo '<h2> Veuiller mettre des dates valide </h2>';
		 					}
		 				} else {
		 					echo '<h2> Ce numéro de sprint existe déjà </h2>';
		 				}
		 			} else {
		 				echo '<h2> Veuiller tout remplir les champs correctement </h2>';
		 			}
		 		}
	 		
	 		echo "<a class=\"btn btn-default\" href=\"ViewProject.php?projet=$projet\">" . "Retour à la page du projet"."</a>";
	 		?>
	 		<center>
  		<table>
  			<thead>
  				<tr>
  					<td><h3> Sprint existant pour le projet</h3> </td>
  				</tr>
  			</thead>
  			<tbody class="SptTable">
				<?php
					$sprints = getSprints($projet);
					$tabSprints = [];
					$numSprint = 1;
					while($row = mysqli_fetch_assoc($sprints)){
							$tabSprints[$numSprint] = $row;
							$numSprint++;
					}
					echo "<tr><td class=\"SptName\">Numero du sprint</td>";
					foreach ($tabSprints as $key2 => $value2) {
						echo "<td> ".$value2['number']."</td>";
					}

					echo "</tr>";
					echo "<tr><td class=\"SptName\">Date de début</td>";
					foreach ($tabSprints as $key2 => $value2) {
						echo "<td> ".$value2['start']."</td>";
					}
					echo "</tr>";
					
					echo "<tr><td class=\"SptName\">Date de fin</td>";
					foreach ($tabSprints as $key2 => $value2) {
						echo "<td> ".$value2['end']."</td>";
					}
				?>
			</tbody>
		</table>
	  	
	  	<?php
		  	echo "<form action=\"ViewCreateSprint.php?projet=".$projet."\" method=\"post\" >";
		  	$sprints = getSprints($projet);
		  	$size = mysqli_num_rows($sprints) + 1;
			echo "<h2> Numéro du sprint </h2>";
		  	echo "<input type=\"text\" value=\"$size\" name=\"num\" />";
		 	echo "<h2> Date de debut : </h2>";
		 	echo "<input type=\"datetime\" name=\"start\"placeholder=\"jj/mm/aaaa\"/>";		
		 	echo "<h2> Date de fin : </h2>";
			echo "<input type=\"datetime\" name=\"end\" placeholder=\"jj/mm/aaaa\"/>";
			echo "<br />";
			echo "<br />";
			echo "<input type=\"submit\" value=\"Creer\" />";
	 		
	 		}
 		?>

	</body>

</html>
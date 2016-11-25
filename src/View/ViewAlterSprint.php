<!DOCTYPE html>

<html lang="fr">
 	<head>
	    <meta charset="utf-8">
	    <title>AlterSprint</title>
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
		  	$sprint = $_GET['sprint'];
		  	$infoprojet = getProjectById($projet);
		  	$infoSprint = getSprint($projet,$sprint);
	 		if(!isContributor($projet)){
	 			echo '<h2> Vous n\'êtes pas contributeur de ce projet, vous ne pouvez pas modifier un sprint de ce projet</h2>';
	 		} else {
	 			echo '<h2> Modification du sprint n°'.$sprint."</h2>";
	 			if( isset($_POST['num']) && isset($_POST['start']) && isset($_POST['end']) && isset($_POST['state'])){
	 				$start 	= $_POST['start'];
	 				$end 	= $_POST['end'];
	 				$num 	= $_POST['num'];
	 				$state 	= $_POST['state'];
	 				if(checkNumSprint($projet,$num) || $num == $sprint){

	 					alterSprint($infoSprint['id'],$num,$start,$end,$state);
	 					$sprint = $num;
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
							echo "<tr><td class=\"SptName\">Modifier le sprint</td>";
							foreach ($tabSprints as $key2 => $value2) { ?>
								<td>
								<?php if(isContributor($projet)) { ?>
									<a href="ViewAlterSprint.php?projet=<?php echo "$projet"."&sprint=".$key2 ?>" class="btn btn-default"><i class="fa fa-cog"></i> Modifier le Sprint</a>
									<?php }?>
								</td>
							<?php
							}
						echo "</tr>";
						echo "<tr><td class=\"SptName\">Etat du sprint</td>";
						foreach ($tabSprints as $key2 => $value2) { 
							if($value2['state'] == "todo"){
								echo "<td  class=\"tdTodo\">ToDo</td>";
							} else if($value2['state'] == "ongoing"){
								echo "<td  class=\"tdOnGoing\">En cours</td>";
							} else if($value2['state'] == "done"){
								echo "<td  class=\"tdDone\">Finis</td>";
							} else {
								echo "<td> Non défini </td>";
							}
						}
						echo "</tr>";
					?>

				</tbody>
			</table>

			<?php
			  	$infoSprint = getSprint($projet,$sprint);


			  	echo "<form action=\"ViewAlterSprint.php?projet=".$projet."&sprint=".$sprint."\" method=\"post\" >";
				echo "<h2> Numéro du sprint </h2>";
			  	echo "<input type=\"text\" value=".$infoSprint['number']." name=\"num\" />";
			 	echo "<h2> Date de debut : </h2>";
			 	echo "<input type=\"datetime\" value=".$infoSprint['start']." name=\"start\"placeholder=\"jj/mm/aaaa\"/>";		
			 	echo "<h2> Date de fin : </h2>";
				echo "<input type=\"datetime\" value=".$infoSprint['end']." name=\"end\" placeholder=\"jj/mm/aaaa\"/>";
				echo "<h2> Etat du projet </h2>";
				
				echo "<select name=\"state\" class=\"obj-form\">";
				
				echo "<option value=\"todo\" ";
				if($infoSprint['state']=="todo"){
					echo "selected";
				}
				echo ">A faire</option>";
				
				echo "<option value=\"ongoing\" ";
				if($infoSprint['state']=="ongoing"){
					echo "selected";
				}
				echo ">En cours</option>";
				
				echo "<option value=\"done\" ";
				if($infoSprint['state']=="done"){
					echo "selected";
				}
				echo ">Finis</option>";

				echo "</select>";

				echo "<br />";
				echo "<br />";
				echo "<input type=\"submit\" value=\"Modfier\" />";
	 		?>

	 		<?php
	 		}
	 		?>
	</body>

</html>	
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
	 		require '../Controler/ControlerTask.php';
	 		require '../Controler/ControlerUS.php';


	 	?>
		<script src="../js/jquery.js"></script>
		<script type="text/javascript" src="../js/bootstrap.min.js"></script>
	    <link rel="stylesheet" href="../css/bootstrap.css">
		<link rel="stylesheet" href="../css/font-awesome-4.7.0/css/font-awesome.css">
		<link rel="stylesheet" href="../css/index.css">
		<link rel="stylesheet" href="../css/popup.css">

  	</head>

  	<body>
  		<?php include 'ViewMenuBar.php'; ?>

  		<?php 
  		$projet = $_GET["projet"];
  		$sprint = $_GET["sprint"];
  		$infoprojet = getProjectById($projet);
  		$infosprint = getSprint($projet,$sprint);
  		echo "<h2> Visualisation du sprint n°".$sprint." du projet ".$infoprojet['title']."</h2>";
  		echo "<a class=\"btn btn-default\" href=\"ViewProject.php?projet=$projet\">" . "Retour à la page du projet"."</a>";
  		if(isset($_POST['description']) && isset($_POST['effort']) && isset($_POST['US']) && isset($_POST['state']) && isset($_POST['task']) ) {
	 			UpdateTask($_POST['description'],$_POST['effort'],$_POST['US'],$_POST['state'],$_POST['task']);
				header("location: {$_SERVER['PHP_SELF']}?projet=".$currProject['id']);
	 		}
  		?>
  		<center>
  		<br> <br>
  		<table class="sprintTable">
  			<thead class="sprintThead">
  				<tr>
  					<td>Numero du sprint</td>
  					<td> Début du sprint </td>
  					<td> Fin du sprint </td>
  					<td> Etat du sprint </td>
  					<td> Action du le sprint </td>
  				</tr>
  			</thead>
  			<tbody>
  				<tr>
  					<?php 
  						echo "<td>".$infosprint['number']."</td>";
  						echo "<td>".$infosprint['start']."</td>";
  						echo "<td>".$infosprint['end']."</td>";
  						if($infosprint['state'] == "todo"){
								echo "<td  class=\"tdTodo\">ToDo</td>";
							} else if($infosprint['state'] == "ongoing"){
								echo "<td  class=\"tdOnGoing\">En cours</td>";
							} else if($infosprint['state'] == "done"){
								echo "<td  class=\"tdDone\">Finis</td>";
							} else {
								echo "<td> Non défini </td>";
							}
  						?>
  						<td>
  						<?php if(isContributor($projet)) { ?>
							<a href="ViewAlterSprint.php?projet=<?php echo "$projet"."&sprint=".$sprint ?>" class="btn btn-default"><i class="fa fa-cog"></i> Modifier</a>
							<br />
							<a href="../Handler/RemoveSprint.php?projet=<?php echo "$projet"."&sprint=".$sprint ?>" class="btn btn-default"><i class="fa fa-window-close-o"></i> Supprimer</a>

						<?php }?>
						</td>			
  				</tr>
  			</tbody>
  		</table>
  		</center><br> <br>

  		<h2> Tâches à réaliser </h2>
  		<center>
  		<br />
  		<table class="sprintTable">
  			<thead class="sprintThead">
  				<tr>
  					<td colspan="5"> <a href="ViewTask.php?projet=<?php echo "$projet"."&sprint=".$sprint ?>" class="btn btn-default"><i class="fa fa-eye"></i> Page des tâche</a>
  					<a href="ViewKanban.php?projet=<?php echo "$projet"."&sprint=".$sprint ?>" class="btn btn-default"><i class="fa fa-eye"></i> Kanban</a>
  					<?php if(isContributor($projet)) { ?>
  					<a href="ViewAddTask.php?projet=<?php echo "$projet"."&sprint=".$sprint ?>" class="btn btn-default"><i class="fa fa-plus"></i> Ajouter une tâche</a>
  					 </td>
  					 <?php } ?>
  				</tr>
  				<tr>
  					<td> Description </td>
  					<td> Effort </td>
  					<td> Etat </td>
  					<td> Description de la UserStory </td>
  					<td> Action </td>
  				</tr>
  			<tbody>
  			<?php 
  				//Récupération des tâches du sprint
  				$listTask = getTaskBySprint($projet,$sprint);
  				while($row = mysqli_fetch_array($listTask,MYSQLI_ASSOC)){
  					//Récupération des infos de la tâche
  					$task = getTask($row['task']);
  					$task = mysqli_fetch_array($task,MYSQLI_ASSOC);  	
  					//Mise de la couleur sur la ligne			
  					if($task['state'] == 0){
						echo "<tr  class=\"tdTodo\">";
					} else if($task['state'] == 1){
						echo "<tr  class=\"tdOnGoing\">";
					} else if($task['state'] == 2){
						echo "<tr  class=\"tdDone\">";
					} else if($task['state'] == 3 ){
						echo "<tr class=\"tdDone\">";
					} else {
						echo "<tr>";
					}
  					echo "<td>".$task['description']."</td>";
  					echo "<td>".$task['effort']."</td>";
  					//Affichage de l'état
  					if($task['state'] == 0){
						echo "<td >A faire</td>";
					} else if($task['state'] == 1){
						echo "<td >En cours</td>";
					} else if($task['state'] == 2){
						echo "<td >En test</td>";
					} else if($task['state'] == 3 ){
						echo "<td> Finis </td>";
					} else {
						echo "<td> Etat inconnu </td>";
					}
  					//Affichage de l'US
  					$us = getUS($task['userstory']);
  					$us = mysqli_fetch_array($us,MYSQLI_ASSOC);
  					echo "<td>";
  					echo "En tant que ".$us['rank']." je souhaiterais ".$us['action']." dans le but de ".$us['goals'];
  					echo "</td>";
  					echo "<td>"; ?>
					<div id="modal<?php echo $task['id'] ?>" class = "modal fade" style="display: none;" >
							<div id="popup">
									<form id="pop"   method="post" action="ViewSprint.php?projet=<?php echo $projet ?>&sprint=<?php echo $sprint ?>">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Modification de la Tâche</h4>
										</div>
										
										<label for="description" class="ui-hidden-accessible">Description :</label>
										<textarea type="text" name="description" rows="2" cols="30"><?php echo $task['description']?></textarea>
										
										<label for="effort" class="ui-hidden-accessible">Effort :</label>
										<select name="effort" class="objForm">
											<?php 
												echo "<option value=".$task['effort']." selected=\"selected\">".$task['effort']."</option>";
												for ($i = 1; $i <= 100; $i++) {
													echo "<option value=".$i.">".$i."</option>";
												}	
											?>
										</select>
										
										<label for="US" class="ui-hidden-accessible">UserStory liée :</label>
										<select name="US" class="objForm">
											<?php 
												$allUS = GetUSByProject($projet);
												echo "<option value=".$task['userstory']." selected=\"selected\">".GetUSIdInProject($projet,$task['userstory'])."</option>";
												while($tmpUS = $allUS->fetch_array(MYSQLI_NUM))
													if($tmpUS[0] != $task['userstory'])
													echo "<option value=".$tmpUS[0].">".GetUSIdInProject($projet,$tmpUS[0])."</option>";
											?>
										</select><br />
										
										<label for="state" class="ui-hidden-accessible">État : </label>
										<select name="state" class="objForm">
											<?php 
												echo "<option value=".$task['state']." selected=\"selected\">".ToStringState($task['state'])."</option>";
												for ($i = 0; $i <= 3; $i++) {
													if($i != $task['state'])
														echo "<option value=".$i.">".ToStringState($i)."</option>";
												}	
											?>
										</select>
										
										<div class="modal-footer">
											<button type="submit" name="task" value="<?php echo $task['id'] ?>">Envoyer</button>
										</div>
									 </form>											
								</div>
							</div>
							<a data-toggle="modal" data-target="#modal<?php echo $task['id'] ?>" class="btn btn-default" style="cursor:  pointer;"><i class="fa fa-cog"></i> Modifier</a>  					<?php 
  					echo "</tr>";


  				}
  			?> 

  			</tbody>
  	</body>
</html>
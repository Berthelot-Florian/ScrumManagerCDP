<!DOCTYPE html>
<?php
	include '../Controler/ControlerInclude.php';
	cleanInclude();
	include '../Controler/ControlerProject.php';
	include '../Controler/ControlerTask.php';
	include '../Controler/ControlerUS.php';
	$currProject = getProjectById($_GET["projet"]);
?>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Projet <?php echo $currProject['title']; ?> </title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<script src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../css/font-awesome-4.7.0/css/font-awesome.css">
	<link rel="stylesheet" href="../css/index.css">
	<link rel="stylesheet" href="../css/popup.css">
</head>

<body>
	<?php include 'ViewMenuBar.php' ?>
	




	
	<?php
		if(isset($_GET["sprint"]))
			$result = GetTaskByProjectAndSprint($currProject['id'],$_GET["sprint"]);
		else 
			$result = GetTaskByProject($currProject['id']);
		//Testons si l'utilisateur a lancé un des formulaires (Modification US ou Modification de priorité)
			// Ici c'est la gestion du formulaire de priorité
	 		if(isset($_POST['prio'])) {
					$idUS = $_POST["US"];
	 				//Modification de la priorit de la US
					AlterPrioUS($_POST['prio'],$idUS);
					header("location: {$_SERVER['PHP_SELF']}?projet=".$currProject['id']);
	 		}
			// Ici c'est la gestion du formulaire de modification d'US
			if(isset($_POST['description']) && isset($_POST['effort']) && isset($_POST['US']) && isset($_POST['state']) && isset($_POST['task']) ) {
	 			UpdateTask($_POST['description'],$_POST['effort'],$_POST['US'],$_POST['state'],$_POST['task']);
				header("location: {$_SERVER['PHP_SELF']}?projet=".$currProject['id']);
	 		}

 		
		if(mysqli_num_rows($result)==0){
	?>
		
			<!--- Si aucune Tâche est associée au projet -->
			<center>
				<legend>
					Aucune Tâche n'est associée à ce projet.
				</legend>
			</center>
	<?php
		}
	else{
		?>
	<center><h2>Tâches du Projet <?php echo $currProject['title']; if(isset($_GET["sprint"])) echo " présentes dans le sprint ".$_GET["sprint"];?>  </h2></center>
		<table class="table">
			<thead>
			  <tr>
				<th>Description des Tâches</th>
				<th>Effort</th>
				<th>UserStory liée</th>
				<th>État</th>
				<?php if(isContributor($currProject['id'])){  ?> <th>Modification de la Tâche</th>  <?php } ?>
			  </tr>
			</thead>
			<tbody>
	
		<?php
		while($data = $result->fetch_array(MYSQLI_NUM))
			{
				?>
				<!--- Affichage de chaque Tâche -->
				<tr>
					<td><?php echo $data[2]; ?></td>
					<td><?php echo $data[3];?></td>
					<td><?php echo GetUSIdInProject($currProject['id'],$data[4]);?></td>
					<td><?php echo ToStringState($data[5]);?></td>
					<?php if(isContributor($currProject['id'])){ ?> 
						<td>
							<div id="modal<?php echo $data[0] ?>" class = "modal fade" style="display: none;" >
								<div id="popup">
									<form id="pop"   method="post" action="ViewTask.php?projet=<?php echo $currProject['id']?>">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Modification de la Tâche</h4>
										</div>
										
										<label for="description" class="ui-hidden-accessible">Description :</label>
										<textarea type="text" name="description" rows="2" cols="30"><?php echo $data[2]?></textarea>
										
										<label for="effort" class="ui-hidden-accessible">Effort :</label>
										<select name="effort" class="objForm">
											<?php 
												echo "<option value=".$data[3]." selected=\"selected\">".$data[3]."</option>";
												for ($i = 1; $i <= 100; $i++) {
													echo "<option value=".$i.">".$i."</option>";
												}	
											?>
										</select>
										
										<label for="US" class="ui-hidden-accessible">UserStory liée :</label>
										<select name="US" class="objForm">
											<?php 
												$allUS = GetUSByProject($currProject['id']);
												echo "<option value=".$data[4]." selected=\"selected\">".GetUSIdInProject($currProject['id'],$data[4])."</option>";
												while($tmpUS = $allUS->fetch_array(MYSQLI_NUM))
													if($tmpUS[0] != $data[4])
													echo "<option value=".$tmpUS[0].">".GetUSIdInProject($currProject['id'],$tmpUS[0])."</option>";
											?>
										</select><br />
										
										<label for="state" class="ui-hidden-accessible">État : </label>
										<select name="state" class="objForm">
											<?php 
												echo "<option value=".$data[5]." selected=\"selected\">".ToStringState($data[5])."</option>";
												for ($i = 0; $i <= 3; $i++) {
													if($i != $data[5])
														echo "<option value=".$i.">".ToStringState($i)."</option>";
												}	
											?>
										</select>
										
										<div class="modal-footer">
											<button type="submit" name="task" value="<?php echo $data[0] ?>">Envoyer</button>
										</div>
									 </form>											
								</div>
							</div>
							<a data-toggle="modal" data-target="#modal<?php echo $data[0] ?>" style="cursor:  pointer;">Modifier</a>
							|
							<a href = "../Handler/RemoveTask.php?projet=<?php echo $currProject['id']?>&Task=<?php echo $data[0]?>">Supprimer</a>
						</td>  
					<?php } ?>
				</tr>
				<?php
			}
		?>
			</tbody>
		</table>
		<?php
	}
	echo "<center><a class=\"btn btn-default\" href=\"ViewProject.php?projet=$currProject[id]\">" . "Retour à la page du projet"."</a></center>";
?>

</body>
</html>
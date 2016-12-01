<!DOCTYPE html>
<?php
	include '../Controler/ControlerInclude.php';
	cleanInclude();
	include '../Controler/ControlerProject.php';
	include '../Controler/ControlerUS.php';
	include '../Controler/ControlerTask.php';
	include '../Controler/ControlerSprint.php';
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
		$result = GetUSByProject($currProject['id']);
		//Testons si l'utilisateur a lancé un des formulaires (Modification US ou Modification de priorité)
			// Ici c'est la gestion du formulaire de priorité
	 		if(isset($_POST['prio'])) {
					$idUS = $_POST["US"];
	 				//Modification de la priorit de la US
					AlterPrioUS($_POST['prio'],$idUS);
					header("location: {$_SERVER['PHP_SELF']}?projet=".$currProject['id']);
	 		}
			// Ici c'est la gestion du formulaire de modification d'US
			if(isset($_POST['action']) && isset($_POST['rank']) && isset($_POST['goals']) ) {
				$idUS = $_POST["US"];
	 			//Testons si tout les champs sont correctement remplis
	 			if(strlen($_POST['action'])>1)
					AlterActionUS($_POST['action'],$idUS);
				if(strlen($_POST['rank'])>1)
					AlterRankUS($_POST['rank'],$idUS);
				if(strlen($_POST['goals'])>1) 
					AlterGoalUS($_POST['goals'],$idUS);
				AlterDifficultyUS($_POST['diff'],$idUS);
				AlterSprintUS($_POST['sprint'],$idUS);
				header("location: {$_SERVER['PHP_SELF']}?projet=".$currProject['id']);
	 		}
			if(isset($_POST['description']) && isset($_POST['effort']) && isset($_POST['US'])) {
				$idUS = $_POST["US"];
	 			//Testons si tout les champs sont correctement remplis
				if(NotExistTask($idUS,$_POST['description']))
					AddTask($currProject['id'],$_POST['description'],$_POST['effort'],$idUS);
	 		}

		
 		
		if(mysqli_num_rows($result)==0){
	?>
		
			<!--- Si aucune US est associée au projet -->
			<center>
				<legend>
					Aucune UserStory n'est associée à ce projet.
				</legend>
			</center>
	<?php
		}
	else{
		?>
		<center><h2>UserStories du Projet <?php echo $currProject['title'];  ?> </h2></center>
		
		<table class="table">
			<thead>
			  <tr>
				<th>Numéro</th>
				<th>Description de la UserStory</th>
				<th>Difficulté</th>
				<th>Priorité</th>
				<?php if(isContributor($currProject['id'])){  ?> <th>Modification de la UserStory</th>  <?php } ?>
			  </tr>
			</thead>
			<tbody>
	
		<?php
		$idUSInPage = 1;
		while($data = $result->fetch_array(MYSQLI_NUM))
			{
				?>
				<!--- Affichage de chaque US -->
				<tr>
					<td><?php echo $idUSInPage;?></td>
					<td>En tant que <?php echo $data[3]; ?>, je souhaite pouvoir <?php echo $data[4]; ?>, dans le but de <?php echo $data[5];?>. </td>
					<td><?php echo $data[7];?></td>
					<td>
					<?php 
							if($data[6]!=null){echo $data[6];} 
							//Si l'utilisateur est le productowner on lui donne le droit de changer la priorité
							if( isset($_SESSION['id']) && isPO($currProject['id'])){  ?>
								<div id="prio_modal<?php echo $data[0] ?>" class = "modal fade" style="display: none;">
										<div id="popup">
											<form id="pop" method="post" action="ViewUS.php?projet=<?php echo $currProject['id']?>">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h3>Changer la priorité pour la UserStory <?php echo $idUSInPage ?> </h3>
													<label for="prio" class="ui-hidden-accessible">Priorité:</label>
													<select name="prio" class="objForm">
														<?php 
															for ($i = 1; $i <= 100; $i++) {
																echo "<option value=".$i.">".$i."</option>";
															}	
														?>
													</select>
													<button type="submit" name="US" value="<?php echo $data[0] ?>">Valider</button>
											 </form>
										</div>
									</div>
									<a style="text-decoration:none"  data-toggle="modal" data-target="#prio_modal<?php echo $data[0] ?>" style="cursor:  pointer;"><span class="glyphicon glyphicon-cog"></span></a>
										<?php } ?>
								</td>
								<!--- Si l'utilisateur est un contributeur, on lui permet de midifier et supprimer une US -->
								<?php if(isContributor($currProject['id'])){ ?> 
										<td>
											<div id="modal<?php echo $data[0] ?>" class = "modal fade" style="display: none;" >
												<div id="popup">
													<form id="pop"   method="post" action="ViewUS.php?projet=<?php echo $currProject['id']?>">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<h4 class="modal-title">Modification de la UserStory <?php echo $idUSInPage ?> </h4>
														</div>
														<label for="rank" class="ui-hidden-accessible">En tant que :</label>
														<textarea type="text" name="rank" rows="2" cols="30"><?php echo $data[3]?></textarea>
														<label for="action" class="ui-hidden-accessible">Je souhaite pouvoir : </label>
														<textarea type="text" name="action" rows="2" cols="30"><?php echo $data[4]?></textarea>
														<label for="goals" class="ui-hidden-accessible">Dans le but de : </label>
														<textarea type="text" name="goals" rows="2" cols="30"><?php echo $data[5] ?></textarea>
														<label for="sprint" class="ui-hidden-accessible">Sprint </label>
														<select name="sprint" class="objForm">
															<?php
																$sprints = getSprints($currProject['id']);
																echo "<option value=".$data[2]." selected=\"selected\">".$data[2]."</option>";
																while($sprint = mysqli_fetch_array($sprints,MYSQLI_ASSOC)){
																	echo "<option value=".$sprint['number'].">".$sprint['number']."</option>";
																}	
															?>
														</select>
														<label for="diff" class="ui-hidden-accessible">Difficulté </label>
															<select name="diff" class="objForm">
																<?php 
																	echo "<option value=".$data[7]." selected=\"selected\">".$data[7]."</option>";
																	for ($i = 1; $i <= 100; $i++) {
																		echo "<option value=".$i.">".$i."</option>";
																	}	
																?>
															</select>
														<div class="modal-footer">
															<button type="submit" name="US" value="<?php echo $data[0] ?>">Envoyer</button>
														</div>
													 </form>											
												</div>
											</div>
											<a data-toggle="modal" data-target="#modal<?php echo $data[0] ?>" style="cursor:  pointer;">Modifier</a>
											|
											<a href = "../Handler/RemoveUS.php?projet=<?php echo $currProject['id']?>&US=<?php echo $data[0] ?>">Supprimer</a>
											|
											<div id="add_task_modal<?php echo $data[0] ?>" class = "modal fade" style="display: none;" >
												<div id="popup">
													<form id="pop"   method="post" action="ViewUS.php?projet=<?php echo $currProject['id']?>">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<h4 class="modal-title">Ajout d'une tâche à la UserStory <?php echo $idUSInPage ?> </h4>
														</div>
														<label for="description" class="ui-hidden-accessible">Description :</label>
														<textarea type="text" name="description" rows="2" cols="30"></textarea>
														<label for="effort" class="ui-hidden-accessible">Effort :</label>
														<select name="effort" class="objForm">
																<?php 
																	//echo "<option value=".$data[7]." selected=\"selected\">".$data[7]."</option>";
																	for ($i = 1; $i <= 100; $i++) {
																		echo "<option value=".$i.">".$i."</option>";
																		//echo "<option value=".$i.">".$i."</option>";
																	}	
																?>
														</select>
														<div class="modal-footer">
															<button type="submit" name="US" value="<?php echo $data[0] ?>">Valider</button>
														</div>
													 </form>											
												</div>
											</div>
											<a data-toggle="modal" data-target="#add_task_modal<?php echo $data[0] ?>" style="cursor:  pointer;">Ajouter une tâche</a>
										</td>  <?php } ?>
							</tr>
						
				<?php
				$idUSInPage++ ;
			}
		?>
			</tbody>
		</table> 
		<?php
	}
	if(isContributor($currProject['id'])){ ?> 
		<center>
			<a href="ViewAjoutUS.php?projet=<?php echo $currProject['id']; ?>" class="btn btn-default"> Ajouter une UserStory</a>
		</center>
	<?php } ?>	
		<center>
			<a class="btn btn-default" href="ViewProject.php?projet=<?php echo $currProject['id']; ?>">Retour à la page du projet</a>
		</center> 
</body>
</html>
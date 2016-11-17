<!DOCTYPE html>
<?php
	include '../Controler/ControlerInclude.php';
	cleanInclude();
	include '../Controler/ControlerProject.php';
	include '../Controler/ControlerUS.php';
	$currProject = getProjectById($_GET["projet"]);
?>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Projet <?php echo $currProject['title']; ?> </title>
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/font-awesome-4.7.0/css/font-awesome.css">
	<link rel="stylesheet" href="../css/index.css">
	<link rel="stylesheet" href="../css/popup.css">
	<script>
			//Function To Display Popup
		function div_show(id) {
			document.getElementById("id"+id).style.display = "block";
		}
			//Function to Hide Popup
		function div_hide(id){
			document.getElementById("id"+id).style.display = "none";
		}
	</script>
</head>

<body>
	<?php include 'ViewMenuBar.php' ?>
	<?php
		$result = GetUSByProject($currProject['id']);
		//Testons si l'utilisateur a lancé un des formulaires (Modification US ou Modification de priorité)
			// Ici c'est la gestion du formulaire de priorité
	 		if(isset($_POST['prio'])) {
					$idUS = $_GET["US"];
	 				//Modification de la priorit de la US
					AlterPrioUS($_POST['prio'],$idUS);
					header("Refresh:0");
	 		}
			// Ici c'est la gestion du formulaire de modification d'US
			if(isset($_POST['action']) && isset($_POST['rank']) && isset($_POST['goals']) ) {
				$idUS = $_GET["US"];
	 			//Testons si tout les champs sont correctement remplis
	 			if(strlen($_POST['action'])>1)
					AlterActionUS($_POST['action'],$idUS);
				if(strlen($_POST['rank'])>1)
					AlterRankUS($_POST['rank'],$idUS);
				if(strlen($_POST['goals'])>1) 
					AlterGoalUS($_POST['goals'],$idUS);
				AlterDifficultyUS($_POST['diff'],$idUS);
				header("Refresh:0");
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
		<table class="table">
			<thead>
			  <tr>
				<th>Description des UserStory du projet <?php echo $currProject['title'];  ?></th>
				<th>Difficulté</th>
				<th>Priorité</th>
				<?php if(isContributor($currProject['id'])){  ?> <th>Modification de la UserStory</th>  <?php } ?>
			  </tr>
			</thead>
			<tbody>
	
		<?php

		while($data = $result->fetch_array(MYSQLI_NUM))
			{
				?>
				<!--- Affichage de chaque US -->
				<tr>
					<td>En tant que <?php echo $data[2]; ?>, je souhaite pouvoir <?php echo $data[3]; ?>, dans le but de <?php echo $data[4];?>. </td>
					<td><?php echo $data[6];?></td>
					<td>
					<?php 
							if($data[5]!=null){echo $data[5];} 
							//Si l'utilisateur est le productowner on lui donne le droit de changer la priorité
							if( isset($_SESSION['id']) &&isPO($currProject['id'],$_SESSION['id'])){
											echo "<style type=\"text/css\">
														#id$data[0] {
															width:100%;
															height:100%;
															opacity:.95;
															top:0;
															left:0;
															display:none;
															position:fixed;
															background-color:#F8F8F8;
															overflow:auto
														}
													 </style>
											 ";?>
								<div id="id<?php echo $data[0];?>">
										<div id="popup">
											<form id="pop"   method="post" action="ViewUS.php?projet=<?php echo $currProject['id']?>&US=<?php echo $data[0] ?>">
												<a id="close" class="glyphicon glyphicon-remove"  onclick ="div_hide(<?php echo $data[0] ?>)"></a>
													<h3>Changer la priorité pour la UserStory <?php echo $data[0] ?> </h3>
													<label for="prio" class="ui-hidden-accessible">Priorité:</label>
													<select name="prio" class="objForm">
														<?php 
															for ($i = 1; $i <= 100; $i++) {
																echo "<option value=".$i.">".$i."</option>";
															}	
														?>
													</select>
													<input type="submit" data-inline="true" value="Valider">
											 </form>
											
										</div>
									</div>
									<a style="text-decoration:none"  onclick="div_show(<?php echo $data[0]; ?>)"><span class="glyphicon glyphicon-cog"></span></a>
										<?php } ?>
								</td>
								<?php if(isContributor($currProject['id'])){  
										echo "<style type=\"text/css\">
														#id$data[0]000 {
															width:100%;
															height:100%;
															opacity:.95;
															top:0;
															left:0;
															display:none;
															position:fixed;
															background-color:#F8F8F8;
															overflow:auto
														}
													 </style>
												";?> 
										<td>
											<div id="id<?php echo $data[0];?>000">
										<div id="popup">
											<form id="pop"   method="post" action="ViewUS.php?projet=<?php echo $currProject['id']?>&US=<?php echo $data[0] ?>">
												<a id="close" class="glyphicon glyphicon-remove"  onclick ="div_hide(<?php echo $data[0] ?>000)"></a>
												<h3>Modification de la UserStory <?php echo $data[0] ?> </h3>
												<label for="rank" class="ui-hidden-accessible">En tant que :</label>
													<select name="rank" class="objForm">
														<option selected="selected"><?php echo $data[2] ?></option>
														<option value="Visitor">Visiteur</option>
														<option value="TeamMember">Membre de l'équipe</option>
														<option value="ProductOwner">ProductOwner</option>
													</select>
												<label for="action" class="ui-hidden-accessible">Je souhaite pouvoir : </label>
												<textarea type="text" name="action" rows="2" cols="30"><?php echo $data[3]?></textarea>
												<label for="goals" class="ui-hidden-accessible">Dans le but de : </label>
												<textarea type="text" name="goals" rows="2" cols="30"><?php echo $data[4] ?></textarea>
												<label for="diff" class="ui-hidden-accessible">Difficulté </label>
													<select name="diff" class="objForm">
														<?php 
															echo "<option value=".$data[6]." selected=\"selected\">".$data[6]."</option>";
															for ($i = 1; $i <= 100; $i++) {
																echo "<option value=".$i.">".$i."</option>";
															}	
														?>
													</select>
												<input type="submit" value="Envoyer"> 
											 </form>
											
										</div>
									</div>
										<a style="text-decoration:none"  onclick="div_show(<?php echo $data[0];?>000)" >Modifier</a>
										</td>  <?php } ?>
							</tr>
						
				<?php
			}
		?>
			</tbody>
		</table>
		<?php
	}
?>
</body>
</html>
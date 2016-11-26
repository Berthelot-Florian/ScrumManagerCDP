<!DOCTYPE html>
<?php
	include '../Controler/ControlerInclude.php';
	cleanInclude();
	include '../Controler/ControlerProject.php';
	include '../Controler/ControlerUser.php';
	require '../Controler/ControlerSprint.php';
	$currProject = getProjectById($_GET["projet"]);
	ini_set('display_errors','on');
?>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Projet <?php echo $currProject['title']; ?> </title>
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/font-awesome-4.7.0/css/font-awesome.css">
	<link rel="stylesheet" href="../css/index.css">
</head>
<body>
	<?php include 'ViewMenuBar.php' ?>
		<div class="panel panel-info">
			<div class="panel-heading">
				<h1 class="panel-title"><strong> Projet: <?php echo $currProject['title']; ?></strong></h1>
				<div class="SMPO">
					<table class="SMPO">
						<tr>
							<td>
								<h3>ScrumMaster</h3>
							</td>
							<td>
								<?php echo "<h1 class=\"nameContrib\">".getUserByID($currProject['scrummaster'])[3]."</h1>"; ?>
							</td>
						</tr>
						<tr>
							<td>
								<h3>ProductOwner</h3>
							</td>
							<td>
								<?php echo "<h1 class=\"nameContrib\">".getUserByID($currProject['productowner'])[3]."</h1>"; ?>
							</td>
						</tr>
						</table>
						</div>
						<div class="Contrib">
						<?php if(isContributor( $_GET["projet"])) { ?>
									<a href="ViewAddProjectContributor.php?id=<?php echo $currProject['id']; ?>" class="btn btn-default"><i class="fa fa-plus"></i> Ajouter un contributeur</a>
						<?php }?>
						<table class="ContribTable"> 
							<tr>
								<th> <h3>Contributors</h3> </th>
								<th> <h3>Action</h3></th>
							</tr>
							<?php
								$idprojet = $_GET["projet"];
								$users = getContribByProject($_GET["projet"]);
								while($row = mysqli_fetch_array($users,MYSQLI_ASSOC)){
									$row = getUserByID($row['contributor']);
									if($row['0']==$currProject['scrummaster'] || $row['0']==$currProject['productowner'])
										;
									else {
										echo "<tr>";
											echo "<td>";
												echo "<h4 class=\"nameContrib\">"."$row[3] "."</h4>";
											echo "</td>";
											echo "<td>";
												if(isContributor($idprojet)){
													?>

													<a href="../Handler/RemoveContrib.php?projet=<?php echo "$idprojet" ?>&contrib=<?php echo"$row[0]" ?>"><i class="fa fa-window-close-o"></i></a>

													<?php
												} else {
													echo "Vous n'êtes pas contributeur de ce projet";
												}
												
											echo "</td>";
										echo "</tr>";
									}

								}
							?>
						</table>
					</div>
					<div  class="panel-info">
					<?php

					//////////////////////////////////////////////////
					// MENU DE VISU DE SPRINT
					// //////////////////////////////////////////////////
					
						//Variable pour le div
						$sprints = getSprints($idprojet);
						$tabSprints = [];
						$numSprint = 1;
					
						while($row = mysqli_fetch_assoc($sprints)){
							$tabSprints[$numSprint] = $row;
							$numSprint++;
						}

						echo "<center>";
						echo "<table class=\'table-Spt\'>";
						?>
						<thead>
							<tr>
								<td> <h3 class="bli"> Sprint du projet : </h3> </td>
								<?php if(isContributor($idprojet)){ ?>
									<td class="tdSprint"> <a href="./ViewCreateSprint.php?projet=<?php echo $_GET["projet"] ?>" class="btn btn-default"><i class="fa fa-plus"></i> Ajouter un sprint</a></td>
								<?php } ?>
							</tr>
						</thead>
						<tbody class="SptTable">
						<?php
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
						echo "</tr>";

						echo "<tr><td class=\"SptName\">Kanban du sprint</td>";
						foreach ($tabSprints as $key2 => $value2) {
						?>
							<td>
								
								<a href="ViewKanban.php?projet=<?php echo "$idprojet"."&sprint=".$value2['number'] ?>" class="btn btn-default"><i class="fa fa-eye"></i> Kanban</a>
								
							</td>
						<?php 
						}
						echo "</tr>";
				
						echo "<tr><td class=\"SptName\">Tache du sprint</td>";
						foreach ($tabSprints as $key2 => $value2) { ?>
							<td>
								<?php if(isContributor($idprojet)) { ?>
								<a href="ViewTasks.php?projet=<?php echo "$idprojet"."&sprint=".$value2['number'] ?>" class="btn btn-default"><i class="fa fa-eye"></i> Tache</a>
								<?php }?>
							</td>
						<?php
						}
						echo "</tr>";

						echo "<tr><td class=\"SptName\">Modifier le sprint</td>";
						foreach ($tabSprints as $key2 => $value2) { ?>
							<td>
							<?php if(isContributor($idprojet)) { ?>
								<a href="ViewAlterSprint.php?projet=<?php echo "$idprojet"."&sprint=".$value2['number'] ?>" class="btn btn-default"><i class="fa fa-cog"></i> Modifier le Sprint</a>
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
						echo "</tbody>";
						echo "</table>";
				?>

				</div>
					<a style="text-decoration:none" href="ViewUS.php?projet=<?php echo $currProject['id'];?>">
					</a>
					
					
					<?php 
					//////////////////////////////////////////////////
					// MENU DE VISUALISATION DU PROJET
					// ////////////////////////////////////////////////// ?>
						<div class="panel panel-title">
							<div class="panel-heading">	
								<h1 class="panel-title"><strong>Visualisation des informations du projet</strong></h1>
								<br>
								<a href="ViewTask.php?projet=<?php echo $currProject['id']; ?>" class="btn btn-default"><i class="fa fa-eye"></i>Voir les tâches</a>
								<a href="ViewMatTracabilite.php?projet=<?php echo $currProject['id']; ?>" class="btn btn-default"><i class="fa fa-eye"></i> Voir la Matrice de Traçabilité</a>
								<a href="ViewUS.php?projet=<?php echo $currProject['id']; ?>" class="btn btn-default"><i class="fa fa-eye"></i> Voir toutes les UserStorys</a>
					
								<a href="ViewAnnexe.php?projet=<?php echo $currProject['id']; ?>" class="btn btn-default"><i class="fa fa-eye"></i> Voir les Annexes</a>
							</div>
						</div>
				

				</div>
					<a style="text-decoration:none" href="ViewUS.php?projet=<?php echo $currProject['id'];?>">
					</a>
					<?php if(isContributor($idprojet)){ 
					//////////////////////////////////////////////////
					// MENU DE MODIFICATION DU PROJET
					// //////////////////////////////////////////////////
						?>
						<div class="panel panel-danger">
							<div class="panel-heading">	
								<h1 class="panel-title"><strong>Modification du projet</strong></h1>
								<br>
								<a href="ViewAlterProject.php?id=<?php echo $currProject['id']; ?>" class="btn btn-default">Modifier le projet</a>
								<a href="ViewAddProjectContributor.php?id=<?php echo $currProject['id']; ?>" class="btn btn-default"><i class="fa fa-plus"></i> Ajouter un contributeur</a>
								<a href="ViewDeleteProjectContributor.php?id=<?php echo $currProject['id']; ?>" class="btn btn-default"><i class="fa fa-minus-circle"></i> Supprimer un contributeur</a>
								<a href="ViewAjoutUS.php?projet=<?php echo $currProject['id']; ?>" class="btn btn-default"><i class="fa fa-plus"></i> Ajouter US</a>
								<!--<a href="ViewUS.php?projet=<?php echo $currProject['id']; ?>" class="btn btn-default"> Voir les UserStory (Kanban)</a>-->
								<a href="ViewAjoutAnnexe.php?projet=<?php echo $currProject['id']; ?>" class="btn btn-default"><i class="fa fa-plus"></i> Ajouter un annexe</a>
								<a href="../Handler/RemoveProject.php?projet=<?php echo $_GET["projet"] ?>" class="btn btn-default"><i class="fa fa-trash"></i> Supprimer le projet</a>
							</div>
						</div>
					<?php } ?>
				
				


				</div>

			</div>
		</div>
</body>
</html>

<?php
	// CA FAIT QUOI CA LA ? ?????????????
	function settingsMenu($currentProject){

		if(!isset($_SESSION['pseudo']))
			return FALSE;
		if(isContributor($currentProject['id']))
			return TRUE;
		return FALSE;

	}

	
	
?>
<?php

if(!isset($_SESSION['ControlerBdd']))
		include '../Controler/ControlerBdd.php';
if(!isset($_SESSION['Variables']))
		require '../Model/Variables.php';
if(!isset($_SESSION['ControlerUser']))
		include '../Controler/ControlerUser.php';



$result = getAllProject();

if(mysqli_num_rows($result)==0){
	?>
	<!--- Si aucun projet n'est créé -->
	<center>
		<legend>
			Aucun projet n'a été créé
		</legend>
	</center>
	<?php
}

else{
	while ($data = $result->fetch_array(MYSQLI_NUM))
		{
			?>
			<!--- Affichage de chaque projet -->
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title"><strong><?php echo $data[1]; ?></strong></h3>
					<div class="panel-body">
						<strong>ScrumMaster : </strong><?php $row = getUserByID($data[3]); echo $row[3]; ?> <br/>
						<strong>ProductOwner : </strong><?php $row = getUserByID($data[3]); echo $row[3]; ?> <br/>
						<strong>Description : </strong><?php echo $data[4]; ?> <br/>
						<a href="ViewProject.php?id=<?php echo htmlspecialchars($data[0]); ?>" class="btn btn-default">Voir le projet</a>
						<a href="ViewAlterProject.php?id=<?php echo htmlspecialchars($data[0]); ?>" class="btn btn-default">Modifier le projet</a>
						<a href="todo.php?id=<?php echo htmlspecialchars($data[0]); ?>" class="btn btn-default">Ajouter un contributeur</a>
					</div>
				</div>
			</div>
			<?php
		}
}
?>
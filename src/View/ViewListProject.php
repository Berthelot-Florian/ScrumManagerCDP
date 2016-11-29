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
			<a style="text-decoration:none" href="ViewProject.php?projet=<?php echo $data[0];?>">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title"><strong><?php echo $data[1]; ?></strong></h3>
						<div class="panel-body">
							<strong>ScrumMaster : </strong><?php $row = getUserByID($data[2]); echo $row[3]; ?> <br/>
							<strong>ProductOwner : </strong><?php $row = getUserByID($data[3]); echo $row[3]; ?> <br/>
							<strong>Description : </strong><?php echo $data[4]; ?> <br/>
						</div>
					</div>
				</div>
			</a>
			<?php
		}
}
?>
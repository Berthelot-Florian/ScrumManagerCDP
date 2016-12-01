<!DOCTYPE html>

<html lang="fr">
 	<head>
	    <meta charset="utf-8">
	    <title>ViewTracabilite</title>
	    <?php
	    	include '../Controler/ControlerInclude.php';
	    	cleanInclude();
	    	// Include pour les fonction php 
	    	require '../Controler/ControlerUser.php';
	 		require '../Controler/ControlerUS.php';
	 		require '../Controler/ControlerTracab.php';
	 		require '../Controler/ControlerProject.php';
	 		?>
 	 	<link rel="stylesheet" href="../css/bootstrap.css">
		<link rel="stylesheet" href="../css/font-awesome-4.7.0/css/font-awesome.css">
		<link rel="stylesheet" href="../css/index.css">
		<link rel="stylesheet" href="../css/popup.css">
  	</head>
  	<body>

		<?php
	    	include 'ViewMenuBar.php';
	 	?>	
  		<?php 
	 		$projet = $_GET["projet"];
	 		$res = getProjectById($projet);
	 		$tracab = getTracab($projet);
			$first  = 1;
  			$size   = mysqli_num_rows($tracab);
	 		echo "<h2>Matrice de traçabilité du projet : ".$res['title']."</h2>";
	 		echo "<a class=\"btn btn-default\" href=\"ViewProject.php?projet=$projet\">" . "Retour à la page du projet"."</a>";
	 	?>
	 	<center>
  		<table class="sprintTable">
  			<thead>
  				<tr>
  					<td>
  						<a href="./ViewAlterAddTracab.php?projet=<?php echo "$projet"?>" class="btn btn-default"><i class="fa fa-plus"></i> Ajouter un commit </a>
  					</td>
  				</tr>
  				<tr class="sprintThead">
  					<td>Numéro du sprint</td>
  					<td>Numéro du commit</td>
  					<td>Lien du dépot</td>
  					<td>Action</td>				
  				</tr>
  			</thead>
  			<tbody>
  			<?php 
  				
  				while($tra = mysqli_fetch_array($tracab,MYSQLI_ASSOC)){
  					echo "<tr>";
  					echo "<td>".$tra['sprint']."</td>";
  					echo "<td>".$tra['commit']."</td>";
  					if($first == 1){
  						$first = 0;
  						echo "<td rowspan=\"$size\">".$tra['link']."</td>";
  					}
  					echo "<td>"; ?>
  					<a href="./ViewAlterAddTracab.php?projet=<?php echo "$projet"."&sprint=".$tra['sprint'] ?>" class="btn btn-default"><i class="fa fa-cog"></i> Modifier</a>
  					<a href="../Handler/removeTracab.php?projet=<?php echo "$projet"."&sprint=".$tra['sprint'] ?>" class="btn btn-default"><i class="fa fa-window-close-o"></i></a>
  					<?php
  					echo "</tr>";
  				}
  			?>
  				
  			</tbody>


  	</body>
</html>
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
	<script type="text/javascript" src="../js/chart.js"></script>
	<link rel="stylesheet" href="../css/font-awesome-4.7.0/css/font-awesome.css">
	<link rel="stylesheet" href="../css/index.css">
	<link rel="stylesheet" href="../css/popup.css">
</head>

<body>
	<?php include 'ViewMenuBar.php' ?>
	
	<?php 
	
		$sprints = getSprints($currProject['id']);
		
		

		if(mysqli_num_rows($sprints)==0){?>		
			<!--- Si aucune aucun sprint n'est associé au projet -->
			<center>
				<legend>
					Aucun Sprint n'a été créé.
				</legend>
			</center>
		<?php
		}
		else{
			
			
			
			$totalDifficulty = GetTotalUSDifficultyInProject($currProject['id']);
			$projectionDifficultyBySprint = GetUSDifficultiesBySprints($currProject['id'],$totalDifficulty);
			$effectiveDifficultyBySprint = GetEffectiveDifficultiesBySprints($currProject['id'],$totalDifficulty);
			$labelAxial = GetLabelAxial(mysqli_num_rows($sprints));
			
			?>
			<center>
				<legend>
					BurnDownChart du Projet <?php echo $currProject['id']?> 
				</legend>
				<canvas id = "lineChart" height="400" width = "400"> </canvas>
			</center>
			
			
			<script>
				Chart.defaults.global.maintainAspectRatio = false;
				Chart.defaults.global.responsive = false;
				var projection_data = [<?php echo '"'.implode('","', $projectionDifficultyBySprint).'"' ?>];
				var effective_data = [<?php echo '"'.implode('","', $effectiveDifficultyBySprint).'"' ?>];
				var label_axial = [<?php echo '"'.implode('","', $labelAxial).'"' ?>];
				console.log(projection_data);
				console.log(effective_data);
				console.log(label_axial);
				var ctx = document.getElementById('lineChart').getContext('2d');
				var myChart = new Chart(ctx, {
				  type: 'line',
				  data: {
					labels: label_axial,
					datasets: [{
					  fill: false,
					  lineTension: 0.1,
					  label: 'effectif',
					  data: effective_data,
					  backgroundColor: "rgba(153,255,51,0.4)",
					  borderColor: "rgba(153,255,51,0.4)"
					}, {
					  fill: false,
					  lineTension: 0.1,
					  label: 'projection',
					  data: projection_data,
					  backgroundColor: "rgba(75,192,192,1)",
					  borderColor: "rgba(75,192,192,1)"
					}]
				  }
				});
			</script>
			
			
			
		<?php	
		}
	?>
	<center>
			<a class="btn btn-default" href="ViewProject.php?projet=<?php echo $currProject['id']; ?>">Retour à la page du projet</a>
		</center> 
	
</body>
</html>
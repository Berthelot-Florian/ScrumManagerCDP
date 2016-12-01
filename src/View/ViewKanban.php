<!DOCTYPE html>
<?php
	include '../Controler/ControlerInclude.php';
	cleanInclude();
	include '../Controler/ControlerProject.php';
	include '../Controler/ControlerUser.php';
	include '../Controler/ControlerSprint.php';
	include '../Controler/ControlerTask.php';
	$currProject = getProjectById($_GET["projet"]);
	$currSprint = getSprint($_GET["projet"],$_GET["sprint"]);
	$currContrib = getContribByProject($_GET["projet"]);
?>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Sprint <?php echo $currSprint['number']; ?> du projet <?php echo $currProject['title']; ?> </title>
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/font-awesome-4.7.0/css/font-awesome.css">
	<link rel="stylesheet" href="../css/index.css">
</head>
<body>
	<?php include 'ViewMenuBar.php' ?>
	<a class="btn btn-default" href="ViewProject.php?projet=<?php echo $currProject['id']; ?>">Retour à la page du projet</a>
	<br>
	<br>
	<h2>Sprint <?php echo $currSprint['number']; ?> du projet <?php echo $currProject['title']; ?></h2>
	<h3>Tâches à repartir</h3>
		<ul>
			<?php
				$tasks = getUntakenTask($currSprint['id']);
				while($row = mysqli_fetch_array($tasks,MYSQLI_ASSOC)){
					echo $row['description'];
				};
			?>
		</ul>
	<table class="table">
    	<thead>
      	<tr>
      			<th>Contributeurs</th>
    		    <th>A faire</th>
	        	<th>En cours de réalisation</th>
        		<th>En cours de test</th>
        		<th>Réalisé</th>
      		</tr>
	    </thead>
    	<tbody>
    		<?php
    			while($row = mysqli_fetch_array($currContrib,MYSQLI_ASSOC)){
    				$row = getUserByID($row['contributor']);
    				$toDo = getToDoTask($currSprint['id'], $row[0]);
    				$onGoing = getOnGoingTask($currSprint['id'], $row[0]);
    				$onTest = getOnTestTask($currSprint['id'], $row[0]);
    				$done = getDoneTask($currSprint['id'], $row[0]);
    				echo "<tr>
    						<td>"."$row[3]"."</td>
    						<td>";
    						while($taskToDo = mysqli_fetch_array($toDo,MYSQLI_ASSOC)){
    							echo $taskToDo['description'];
    							if(isContributor($_GET["projet"])){
    								echo "<a href=\"../Handler/MoveTaskToRight.php?task=".$taskToDo["id"]."&projet=".$_GET["projet"]."&sprint=".$_GET["sprint"]."\"><i class=\"fa fa-arrow-right\"></i></a>";
    							}
    						};
    						echo "</td><td>";
    						while($taskOnGoing = mysqli_fetch_array($onGoing,MYSQLI_ASSOC)){
    							echo $taskOnGoing['description'];
    							if(isContributor($_GET["projet"])){
    								echo "<a href=\"../Handler/MoveTaskToLeft.php?task=".$taskOnGoing["id"]."&projet=".$_GET["projet"]."&sprint=".$_GET["sprint"]."\"><i class=\"fa fa-arrow-left\"></i></a>";
    								echo "<a href=\"../Handler/MoveTaskToRight.php?task=".$taskOnGoing["id"]."&projet=".$_GET["projet"]."&sprint=".$_GET["sprint"]."\"><i class=\"fa fa-arrow-right\"></i></a>";
    							}
    						};
    						echo "</td><td>";
    						while($taskOnTest = mysqli_fetch_array($onTest,MYSQLI_ASSOC)){
    							echo $taskOnTest['description'];
    							if(isContributor($_GET["projet"])){
    								echo "<a href=\"../Handler/MoveTaskToLeft.php?task=".$taskOnTest["id"]."&projet=".$_GET["projet"]."&sprint=".$_GET["sprint"]."\"><i class=\"fa fa-arrow-left\"></i></a>";
    								echo "<a href=\"../Handler/MoveTaskToRight.php?task=".$taskOnTest["id"]."&projet=".$_GET["projet"]."&sprint=".$_GET["sprint"]."\"><i class=\"fa fa-arrow-right\"></i></a>";
    							}
    						};
    						echo "</td><td>";
    						while($taskDone = mysqli_fetch_array($done,MYSQLI_ASSOC)){
    							echo $taskDone['description'];
    							if(isContributor($_GET["projet"])){
    								echo "<a href=\"../Handler/MoveTaskToLeft.php?task=".$taskDone["id"]."&projet=".$_GET["projet"]."&sprint=".$_GET["sprint"]."\"><i class=\"fa fa-arrow-left\"></i></a>";
    							}
    						};
    				echo "</td></tr>";
    			};
    		?>
    	</tbody>
    </table>
</body>
</html>
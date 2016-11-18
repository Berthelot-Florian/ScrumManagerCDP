<!DOCTYPE html>
<?php
	include '../Controler/ControlerInclude.php';
	cleanInclude();
	include '../Controler/ControlerProject.php';
	require '../Controler/ControlerUser.php';
	//include '../Controler/ControlerAuth.php';
	$currProject = getProjectById($_GET['id']);
?>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Contributeurs du projet <?php echo $currProject['title']; ?> </title>
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/font-awesome-4.7.0/css/font-awesome.css">
	<link rel="stylesheet" href="../css/index.css"> 
</head>
<body>
	<?php include 'ViewMenuBar.php' ?>
	<?php 
		if(isset($_POST['req'])){
			$query="DELETE FROM ContributorProject WHERE contributor='".$_POST['contribToDel']."' AND project='".$_POST['projToDel']."'";
			launchQuery($query);
		}
	?>
	<a class="btn btn-default" href="ViewProject.php?projet=<?php echo $currProject['id']; ?>">Retour à la page du projet</a>
	<br />
 	<br />
	<h1>Supprimer un contributeurs</h3>
		<?php
			$users = getAllUsers(); 
			while($row = mysqli_fetch_array($users,MYSQLI_ASSOC)){
				if(isContributor2($currProject['id'],$row['id'])){
					if($row['id']==$currProject['scrummaster'] || $row['id']==$currProject['productowner'])
						;
					else{
						echo "<form method=\"post\" action=\"ViewDeleteProjectContributor.php?id=".$currProject['id']."\">
						<strong>$row[pseudo] : $row[id]</strong>
						<input type=\"hidden\" name=\"contribToDel\" value=\"$row[id]\">
						<input type=\"hidden\" name=\"projToDel\" value=\"$currProject[id]\">
						<input type=\"hidden\" name=\"req\" value=\"1\">
						<input type=\"submit\" name=\"DeleteContributor\" value=\"Delete\" class=\"btn btn-default\"/>
						</form>
						<br>";
					}
				}
			}
		?>
</body>
</html>
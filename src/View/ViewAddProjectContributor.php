<!DOCTYPE html>
<?php
	include '../Controler/ControlerInclude.php';
	cleanInclude();
	include '../Controler/ControlerProject.php';
	require '../Controler/ControlerUser.php';
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
			addContributor($_POST['project'], $_POST['contributor']);
			//header("Refresh:0");
		}
	?>
	<h1>Ajout de contributeurs au projet <?php echo $currProject['title']; ?> </h1>
	<form method="post" action="ViewAddProjectContributor.php?id=<?php echo $currProject['id']; ?>">
	<select name="contributor" class="objForm">
		<?php
			$users = getAllUsers(); 
			while($row = mysqli_fetch_array($users,MYSQLI_ASSOC)){
					echo "<option value=\"$row[id]\">$row[pseudo]</option>";
			}
		?>	
	</select>
	<input type="hidden" name="project" value=<?php echo "\"$currProject[id]\"" ?>>
	<input type="hidden" name="req" value="1">
	<input type="submit" name="AlterProject" value="&#43 Ajouter un contributeur" class="btn btn-default"/>
	</form>
</body>
</html>
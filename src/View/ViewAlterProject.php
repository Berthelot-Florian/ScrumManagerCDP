<!DOCTYPE html>
<?php
	include '../Controler/ControlerInclude.php';
	cleanInclude();
	include '../Controler/ControlerProject.php';
	require '../Controler/ControlerUser.php';
	$currProject = getProjectById($_GET['id']);
	//$currProject = getProjectById(1);
?>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Modification Projet <?php echo $currProject['title']; ?> </title>
	<link rel="stylesheet" href="../css/bootstrap.css"> 
	<link rel="stylesheet" href="../css/index.css"> 
</head>
<body>
	<?php include 'ViewMenuBar.php' ?>
	<?php 
		if(isset($_POST['req'])){
			if(is_string($_POST['title']) && is_string($_POST['description'])){
			launchQuery("UPDATE Project SET title='".$_POST['title']."', productowner='".$_POST['productowner']."', scrummaster='".$_POST['scrummaster']."', description='".$_POST['description']."' WHERE id = '".$currProject['id']."'");
			header("Refresh:0");
			}
		}
	?>
	<form method="post" action="ViewAlterProject.php">
		<h2>Nom du Projet</h2>
		<input type="text" name="title" value="<?php echo htmlspecialchars($currProject['title']); ?>"/>
		<h2>ScrumMaster</h2>
		<select name="scrummaster" class="objForm">
		<?php
			$users = getAllUsers(); 
			while($row = mysqli_fetch_array($users,MYSQLI_ASSOC)){
				if($row['id']==$currProject['scrummaster'])
					echo "<option value=\"$row[id]\" selected=\"selected\">$row[pseudo]</option>";
				else
					echo "<option value=\"$row[id]\">$row[pseudo]</option>";
			}
		?>
		</select>
		<h2>ProductOwner</h2>
		<select name="productowner" class="objForm">
		<?php
			$users = getAllUsers(); 
			while($row = mysqli_fetch_array($users,MYSQLI_ASSOC)){
				if($row['id']==$currProject['productowner'])
					echo "<option value=\"$row[id]\" selected=\"selected\">$row[pseudo]</option>";
				else
					echo "<option value=\"$row[id]\">$row[pseudo]</option>";
			}
		?>
		</select>
		<h2>Description</h2>							
		<label class="label" name="description">Description : </label>
		<br />
		<textarea name="description" class="objForm" rows="10" cols="50"><?php echo $currProject['description'];?></textarea>       
		<br />
		<input type="hidden" name="req" value="1">
		<input type="submit" name="AlterProject" value="Mettre à jour les données" class="btn btn-default"/>
	</form>
</body>
</html>

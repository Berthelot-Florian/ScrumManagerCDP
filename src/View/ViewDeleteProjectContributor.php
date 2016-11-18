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
			echo $_POST['contribToDel'];	
			$query="DELETE FROM ContributorProject WHERE contributor='".$_POST['contribToDel']."' AND project='".$_POST['projToDel']."'";
			echo $query;
			launchQuery($query);
			//header("Refresh:0");
		}
	?>
	<h1>Supprimer un contributeurs</h3>
		<form method="post" action="ViewDeleteProjectContributor.php?id=<?php echo $currProject['id']; ?>">
		<?php
			$users = getAllUsers(); 
			while($row = mysqli_fetch_array($users,MYSQLI_ASSOC)){
				if($row['id']==$currProject['scrummaster'] || $row['id']==$currProject['productowner'])
					;
				else{
					echo "<strong>$row[pseudo] : $row[id]</strong>
					<input type=\"hidden\" name=\"contribToDel\" value=\"$row[id]\">
					<input type=\"hidden\" name=\"projToDel\" value=\"$currProject[id]\">
					<input type=\"hidden\" name=\"req\" value=\"1\">
					<input type=\"submit\" name=\"DeleteContributor\" value=\"Delete\" class=\"btn btn-default\"/>
					<br>";
				}
			}
		?>
		</form>
</body>
</html>
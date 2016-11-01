<!DOCTYPE html>
<html>
    <head>
		<?php
	    	if(!isset($_SESSION['ControlerInclude']))
				include '../Controler/ControlerInclude.php';
	    	cleanInclude();
	    	// Include pour les fonction php 
	    	require '../Controler/ControlerUser.php';
	 		require '../Controler/ControlerProject.php';
	 	?>
        <meta charset="utf-8" />
        <title>Titre</title>
		<link rel="stylesheet" href="../css/bootstrap.css"> 
		<link rel="stylesheet" href="../css/index.css"> 
    </head>
	<body>
	
	<?php include 'ViewMenuBar.php' ?>
	<?php include 'ViewListProject.php' ?>

    </body>
</html>







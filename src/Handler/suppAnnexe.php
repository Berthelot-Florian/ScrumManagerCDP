<?php
$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname(dirname($_SERVER['PHP_SELF'])), '/\\');
	$extra = '/View/ViewAnnexe.php';
	header("Location: http://$host$uri$extra");

	include '../Controler/ControlerInclude.php';
	cleanInclude();
	require '../Controler/ControlerAnnexe.php';
	$fich = $_GET['file'];
	$fichier = "../Annexes/$fich";

	echo "<br />";
	$projet = $_GET['projet'];
	if( file_exists ( $fichier)){
		printf("coucou1\n");
		suppAnnexe($projet,$fich);
     	unlink( $fichier ) ;
	}

 	
	exit;

<?php

	include '../Controler/ControlerInclude.php';
	cleanInclude();
	require '../Controler/ControlerAnnexe.php';
	
	$fich = $_GET['file'];
	$fichier = "../Annexes/$fich";
	$projet = $_GET['projet'];
	
	if( file_exists ( $fichier)){
		suppAnnexe($projet,$fich);
     	unlink( $fichier ) ;
	}
 	
	//redirection
 	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname(dirname($_SERVER['PHP_SELF'])), '/\\');
	$extra = '/View/ViewAnnexe.php';
	$projet = '?projet='.$_GET['projet'];
	header("Location: http://$host$uri$extra$projet",true);
	exit;

<?php
	include '../Controler/ControlerInclude.php';
	cleanInclude();
	require '../Controler/ControlerProject.php';
	require '../Controler/ControlerUser.php';
	require '../Controler/ControlerAuth.php';
	$projet = $_GET['projet'];
	$contribToDel = $_GET['contrib'];
	//Vérification qu'il a bien les droits
	if(isConnected() && isContributor($projet)){
		removeContrib($contribToDel,$projet);
	}
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname(dirname($_SERVER['PHP_SELF'])), '/\\');
	$extra = '/View/ViewProject.php';
	$projet = '?projet='.$_GET['projet'];
	header("Location: http://$host$uri$extra$projet",true);
	exit;

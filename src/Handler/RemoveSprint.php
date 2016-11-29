<?php
	include '../Controler/ControlerInclude.php';
	cleanInclude();
	require '../Controler/ControlerSprint.php';
	require '../Controler/ControlerUser.php';
	require '../Controler/ControlerAuth.php';
	$projet = $_GET['projet'];
	$sprint = $_GET['sprint'];
	//Vérification qu'il a bien les droits
	if(isConnected() && isContributor($projet)){
		removeSprint($projet,$sprint);
	}
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname(dirname($_SERVER['PHP_SELF'])), '/\\');

	$extra = '/View/ViewProject.php';
	$projet = '?projet='.$_GET['projet'];

	header("Location: http://$host$uri$extra$projet",true);
	exit;


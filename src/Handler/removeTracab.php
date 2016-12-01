<?php
	include '../Controler/ControlerInclude.php';
	cleanInclude();
	require '../Controler/ControlerUser.php';
	require '../Controler/ControlerTracab.php';
	require '../Controler/ControlerAuth.php';
	
	$projet = $_GET['projet'];
	$sprint = $_GET['sprint'];
	
	if(isContributor($projet)){
		removeTracab($projet,$sprint);
	}
	
	//Redirection
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname(dirname($_SERVER['PHP_SELF'])), '/\\');
	$extra = '/View/ViewMatTracabilite.php';
	$projet = '?projet='.$_GET['projet'];
	header("Location: http://$host$uri$extra$projet",true);
	exit;
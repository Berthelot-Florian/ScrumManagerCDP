<?php
	include '../Controler/ControlerInclude.php';
	cleanInclude();
	require '../Controler/ControlerProject.php';
	require '../Controler/ControlerAuth.php';
	$projet = $_GET['projet'];
	if(isConnected() && isContributor($projet)){
		RemoveProject($projet);
	}
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname(dirname($_SERVER['PHP_SELF'])), '/\\');
	$extra = '/View/ViewIndex.php';
	header("Location: http://$host$uri$extra",true);
	exit;
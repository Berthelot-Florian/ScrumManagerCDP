<?php
	include '../Controler/ControlerInclude.php';
	cleanInclude();
	include '../Controler/ControlerTask.php';
	require '../Controler/ControlerAuth.php';

	$task =getTask($_GET['task']);
	$task = mysqli_fetch_array($task,MYSQLI_ASSOC);
	if(isConnected() && isContributor($_GET['projet'])){
		takeTask($task['id']);
	}
	
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname(dirname($_SERVER['PHP_SELF'])), '/\\');
	$extra = '/View/ViewKanban.php';
	$projet = '?projet='.$_GET['projet'].'&sprint='.$_GET['sprint'];
	header("Location: http://$host$uri$extra$projet",true);
	exit;
	
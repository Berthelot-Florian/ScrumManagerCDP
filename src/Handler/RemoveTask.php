<?php 
	include '../Model/Variables.php';
	include '../Controler/ControlerProject.php';
	include '../Controler/ControlerAuth.php';
	include '../Controler/ControlerTask.php';
	$currProject = getProjectById($_GET["projet"]);
	$currTask = $_GET["Task"];	
	if(isConnected() && isContributor($currProject['id'])){
		DeleteTask($currTask);
	}
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname(dirname($_SERVER['PHP_SELF'])), '/\\');
	$extra = '/View/ViewTask.php?projet='.$currProject['id'];
	header("Location: http://$host$uri$extra");
	exit;
?>
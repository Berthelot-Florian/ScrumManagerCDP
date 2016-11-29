<?php 
	include '../Model/Variables.php';
	include '../Controler/ControlerProject.php';
	include '../Controler/ControlerAuth.php';
	include '../Controler/ControlerUS.php';
	$currProject = getProjectById($_GET["projet"]);
	$currUS = $_GET["US"];	
	if(isConnected() && isContributor($currProject['id'])){
		DeleteUs($currUS);
	}
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname(dirname($_SERVER['PHP_SELF'])), '/\\');
	$extra = '/View/ViewUS.php?projet='.$currProject['id'];
	header("Location: http://$host$uri$extra");
	exit;
?>
<?php 
	include '../Controler/ControlerAuth.php';

	disconnect();
	
	/* Redirection vers une page différente du même dossier */
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname(dirname($_SERVER['PHP_SELF'])), '/\\');
	$extra = '/View/ViewIndex.php';
	header("Location: http://$host$uri$extra");
	exit;
?>




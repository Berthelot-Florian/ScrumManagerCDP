<?php 
	include '../Controler/ControlerAuth.php';

	disconnect();
	
	/* Redirection vers une page différente du même dossier */
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'ViewIndex.php';
	header("Location: http://$host/Test/View/$extra");
	exit;
?>




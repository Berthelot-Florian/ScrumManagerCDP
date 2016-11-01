<?php 
	include '../Model/Variables.php';
	include '../Controler/ControlerAuth.php';
	
	$login = $_POST['login'];
	$password = $_POST['password'];
	
	if(!empty($login) || !empty($password)){
		printf("%s %s",$login,$password);
		connectUser($login,$password);
	}
	
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname(dirname($_SERVER['PHP_SELF'])), '/\\');
	$extra = '/View/ViewIndex.php';
	header("Location: http://$host$uri$extra");
	exit;
?>




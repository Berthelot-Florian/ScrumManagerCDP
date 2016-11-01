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
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'ViewIndex.php';
	header("Location: http://$host/Test/View/$extra");
	exit;
?>




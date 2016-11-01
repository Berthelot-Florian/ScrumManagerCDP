<?php include '../Controler/ControlerSignUp.php';
	  include '../Controler/ControlerAuth.php';

	$login = $_POST['login'];
	$password = $_POST['password'];
	$pseudo = $_POST['pseudo'];
	$email = $_POST['email'];
	if(!empty($login) && !empty($password) && !empty($pseudo) && !empty($email)){
		$result = signUp($login,$password,$pseudo,$email);
		if($result){
			/*Si l'inscription c'est bien passée on connecte l'utilisateur et on le renvoie vers la page d'Acceuil */
			connectUser($login,$password);
			$host  = $_SERVER['HTTP_HOST'];
			$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
			$extra = 'ViewIndex.php';
			header("Location: http://$host/Test/View/$extra");
			exit;
		}
	}
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = '../View/ViewSignUp.php';
	header("Location: http://$host/Test/View/$extra");
	exit;
?>
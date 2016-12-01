<?php
	include '../Controler/ControlerInclude.php';
	cleanInclude();
	require '../Controler/ControlerUser.php';
	require '../Controler/ControlerTracab.php';
	require '../Controler/ControlerAuth.php';

	$projet = $_POST['projet'];
	$sprint = $_POST['sprint'];
	$commit = $_POST['commit'];
	$link 	= $_POST['link'];

	if(isContributor($projet)){
		$info = getTracabSp($projet,$sprint);
		//C'est un ajout
		if(mysqli_num_rows($info) == 0){
			addTrac($projet,$sprint,$commit,$link);
		} else {
			//C'est une modification
			alterTracab($projet,$sprint,$commit,$link);
		}
	}

	//Redirection
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname(dirname($_SERVER['PHP_SELF'])), '/\\');
	$extra = '/View/ViewMatTracabilite.php';
	$projet = '?projet='.$_POST['projet'];
	header("Location: http://$host$uri$extra$projet",true);
	exit;
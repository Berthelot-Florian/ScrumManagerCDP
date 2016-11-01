<?php 

	$_SESSION['ControlerInclude'] = '1';
	
	function cleanInclude(){
		session_start();
		//détruit toute les variable relative aux includes qui évitent d'include 2 fois le même fichier
		unset($_SESSION['ControlerAuth']);
		unset($_SESSION['ControlerBdd']);
		unset($_SESSION['ControlerProject']);
		unset($_SESSION['ControlerUser']);
		unset($_SESSION['ControlerSignUp']);
		unset($_SESSION['Variables']);
	}


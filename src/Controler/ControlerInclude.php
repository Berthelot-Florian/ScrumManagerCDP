<?php 

	$_SESSION['ControlerInclude'] = '1';

	function cleanInclude(){
		session_start();
		//détruit toute les variable relative aux includes qui évitent d'include 2 fois le même fichier
		if(isset($_SESSION['ControlerAuth'])){
			unset($_SESSION['ControlerAuth']);
		}
		if(isset($_SESSION['ControlerBdd'])){
			unset($_SESSION['ControlerBdd']);
		}
		if(isset($_SESSION['ControlerProject'])) {
			unset($_SESSION['ControlerProject']);
		}
		if(isset($_SESSION['ControlerUser'])){
			unset($_SESSION['ControlerUser']);
		}
		if(isset($_SESSION['ControlerSignUp'])){
			unset($_SESSION['ControlerSignUp']);
		}
		if(isset($_SESSION['Variables'])){
			unset($_SESSION['Variables']);
		}
		if(isset($_SESSION['ControlerBdd'])){
			unset($_SESSION['ControlerBdd']);
		}
		if(isset($_SESSION['ControlerAnnexe'])){
			unset($_SESSION['ControlerAnnexe']);
		}
		if(isset($_SESSION['ControlerUS'])){
			unset($_SESSION['ControlerUS']);
		}
	}
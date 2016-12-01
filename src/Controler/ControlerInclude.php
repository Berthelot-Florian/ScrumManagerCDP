<?php 

	$_SESSION['ControlerInclude'] = '1';

	/**
	 * [cleanInclude Permet de cleaner l'ensemble des includes afin de ne pas pouvoir importer deux fois le même fichier]
	 */
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
		if(isset($_SESSION['ControlerSprint'])){
			unset($_SESSION['ControlerSprint']);
		}
		if(isset($_SESSION['ControlerTask'])){
			unset($_SESSION['ControlerTask']);
		}
		if(isset($_SESSION['ControlerTracab'])){
			unset($_SESSION['ControlerTracab']);
		}
		
	}
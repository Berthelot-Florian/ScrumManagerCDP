<?php 
<<<<<<< HEAD
	$_SESSION['ControlerUser'] = '1';
	if(!isset($_SESSION['ControlerBdd']))
		include '../Controler//ControlerBdd.php';
	if(!isset($_SESSION['Variables']))
		require '../Model/Variables.php';
	
=======
	include '../Controler//ControlerBdd.php';
	require '../Model/Variables.php';
>>>>>>> 0bad652f094890028bcef48aa8a37b3b40096c60

	/**
	 * [getAllUsers Fonction pour récupéré tout les utilisateurs]
	 * @return [mysqli_result] [toute les informations de l'utilisateur]
	 */
	function getAllUsers(){
		global $TableUserGlob;
		$query = "SELECT * FROM $TableUserGlob";
		$result = launchQuery($query);
		return $result;
	}

	
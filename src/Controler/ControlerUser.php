<?php 
	include '../Controler//ControlerBdd.php';
	require '../Model/Variables.php';

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

	
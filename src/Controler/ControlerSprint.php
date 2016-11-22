<?php 
	$_SESSION['ControlerSprint'] = '1';
	if(!isset($_SESSION['ControlerBdd']))
		include 'ControlerBdd.php';
	if(!isset($_SESSION['Variables']))
		require '../Model/Variables.php';


	function getSprints($idProjet){
		global $TableSprintglob;
		$query = "SELECT * FROM $TableSprintglob WHERE project='$idProjet' ";
		$result = launchQuery($query);
		return $result;
	}
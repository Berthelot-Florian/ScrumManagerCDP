<?php 
	$_SESSION['ControlerUS'] = '1';
	if(!isset($_SESSION['ControlerBdd']))
		include 'ControlerBdd.php';
	if(!isset($_SESSION['Variables']))
		require '../Model/Variables.php';

	/**
	 * [AddUS Permet d'ajouter une user story]
	 * @param [int] $idProject [description]
	 * @param [String] $rank      
	 * @param [String] $action    
	 * @param [String] $goals     
	 * @return [boolean] TRUE si réussie, false sinon
	 */
	function AddUs($idProject,$rank,$action,$goal,$priority){
		global $TableUSGlob;
		$query = "INSERT INTO `UserStory` (`id`, `project`, `rank`, `action`, `goal`, `priority`) VALUES (NULL,'$idProject','$rank','$action','$goal','$priority') ";
		return launchQuery($query);
	}
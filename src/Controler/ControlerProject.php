<?php 
	require '../ControlerBdd.php';
	require '../Model/Variables.php';

	/**
	 * [AddProject Fonction pour ajouter un projet]
	 * @param [String] $Title        		[Titre du projet]
	 * @param [Int] $ScrumMaster  			[Id du ScrumMaster]
	 * @param [Int] $ProductOwner 			[Id du ProductOwned]
	 * @param [Description] $description  	[Description du Projet]
	 * @return [Boolean]					[Retourne TRUE si la requête s'est correctement effectuer, FALSE sinon]
	 */
	function AddProject($Title,$ScrumMaster,$ProductOwner,$description){
		global $TableProjetGlob;
		if(is_string($Title) && is_string($description) ){
			$SM = intval($ScrumMaster);
			$PO = intval($ProductOwner);
			$query = "INSERT INTO $TableProjetGlob ( `titre`, `ScrumMaster`, `ProductOwner`, `description`) VALUES ('$Title','$SM','$PO','$description')";
			return launchQuery($query);
		}
		return false;
	}

	/**
	 * [RemoveProject Fonction pour supprimer un projet]
	 * @param [int] $id [id du projet que l'on veut supprimer]
	 * @return [Boolean]					[Retourne TRUE si la requête s'est correctement effectuer, FALSE sinon]
	 */
	function RemoveProject($id){
		global $TableProjetGlob;
		$idProject = intval($id);
		$query = "DELETE FROM $TableProjetGlob WHERE id = $idProject";
		return launchQuery($query);
	}

	/**
	 * [getProject Permet de récupéré les information d'un projet a partir de son id]
	 * @param  [int] $id [id du projet]
	 * @return [array assoc]     [information du projet retourné sous forme de tableau associatif]
	 */
	function getProjectById($id){
		global $TableProjetGlob;
		$idProject = intval($id);
		$query = "SELECT * FROM $TableProjetGlob WHERE id = '$idProject'";
		$result = launchQuery($query);
		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
		return $row;
	}

	/**
	 * [getProjectByName Permet de récupéré les information d'un projet a partir de son titre]
	 * @param  [String] $Title [Titre du projet]
	 * @return [array assoc]     [information du projet retourné sous forme de tableau associatif]
	 */
	function getProjectByName($Title){
		global $TableProjetGlob;
		if(is_string($Title)){
			$query = "SELECT * FROM $TableProjetGlob WHERE titre = '$Title' ";
			$result = launchQuery($query);
			$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
			return $row;
		}
		return FALSE;
	}

	/**
	 * [getAllProject Permet d'optenir tout les projets existant dans la BDD]
	 * @return [mysqli_result] [retourne tout les projets]
	 */
	function getAllProject(){
		global $TableProjetGlob;
		$query = "SELECT * FROM $TableProjetGlob";
		$result = launchQuery($query);
		return $result;
	}


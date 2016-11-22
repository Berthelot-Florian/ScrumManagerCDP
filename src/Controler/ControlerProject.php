<?php 
	$_SESSION['ControlerProject'] = '1';
	if(!isset($_SESSION['ControlerBdd']))
		include 'ControlerBdd.php';
	if(!isset($_SESSION['Variables']))
		require '../Model/Variables.php';

	/**
	 * [AddProject Fonction pour ajouter un projet]
	 * @param [String] $title        		[Titre du projet]
	 * @param [Int] $scrummaster  			[Id du ScrumMaster]
	 * @param [Int] $productowner 			[Id du ProductOwned]
	 * @param [Description] $description  	[Description du Projet]
	 * @return [Boolean]					[Retourne TRUE si la requête s'est correctement effectuer, FALSE sinon]
	 */
	function AddProject($title,$scrummaster,$productowner,$description){
		global $TableProjetGlob;
		global $TableContribGlob;
		if(is_string($title) && is_string($description) ){
			$query = "INSERT INTO $TableProjetGlob ( `title`, `scrummaster`, `productowner`, `description`) VALUES ('$title','$scrummaster','$productowner','$description')";
			$result = launchQuery($query);
			if(!$result){
				return false; 
			}
			$idProject = getProjectByName($title)['id'];
			$query = "INSERT INTO $TableContribGlob (`contributor`, `project`) VALUES ('$scrummaster','$idProject')";
			$result = launchQuery($query);
			if(!$result){
				return false; 
			}
			$query = "INSERT INTO $TableContribGlob (`contributor`, `project`) VALUES ('$productowner','$idProject')";
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
			$query = "SELECT * FROM $TableProjetGlob WHERE title = '$Title' ";
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
	
	/**
	 * [getAllProjectByScMaID Permet d'obtenir tout les projets existant dans la BDD où l'utilisateur est ScrumMaster]
	 * @param  [int] $id [id de l'utilisateur]
	 * @return [mysqli_result] [retourne tout les projets]
	 */
	function getAllProjectByScMaID($UserID){
		global $TableProjetGlob;
		$query = "SELECT * FROM $TableProjetGlob WHERE scrummaster = '$UserID' ";
		$result = launchQuery($query);
		return $result;
	}

	/**
	 * [getAllProjectByPOID Permet d'obtenir tout les projets existant dans la BDD où l'utilisateur est ProductOwner]
	 * @param  [int] $id [id de l'utilisateur]
	 * @return [mysqli_result] [retourne tout les projets]
	 */
	function getAllProjectByPOID($UserID){
		global $TableProjetGlob;
		$query = "SELECT * FROM $TableProjetGlob WHERE productowner = '$UserID' ";
		$result = launchQuery($query);
		return $result;
	}
	
	/**
	 * [getAllProject Permet d'obtenir tout les projets existant dans la BDD où l'utilisateur est contributeur]
	 * @param  [int] $id [id de l'utilisateur]
	 * @return [mysqli_result] [retourne tout les projets]
	 */
	function getAllProjectByContributorID($UserID){
		global $TableProjetGlob;
		$query = "SELECT project FROM $TableContribGlob WHERE contributor = '$UserID' ";
		$result = launchQuery($query);
		return $result;
	}

	function getContribByProject($project){
		global $TableContribGlob;
		$query = "SELECT * FROM $TableContribGlob WHERE project = $project";
		return launchQuery($query);
	}

	function removeContrib($UserId,$project){
		global $TableContribGlob;
		$query = $query="DELETE FROM $TableContribGlob WHERE project='$project' AND contributor='$UserId'";
		$result = launchQuery($query);
		return $result; 
	}
	

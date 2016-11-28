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
	function AddUs($idProject,$rank,$action,$goal,$difficulty){
		global $TableUSGlob;
		$query = "INSERT INTO $TableUSGlob (`id`, `project`, `rank`, `action`, `goal`, `difficulty`) VALUES (NULL,'$idProject','$rank','$action','$goal','$difficulty') ";
		return launchQuery($query);
	}

	/**
	 * [DeleteUS Permet de supprimer une user story]
	 * @param [int] $idUS [description]    
	 * @return [boolean] TRUE si réussie, false sinon
	 */
	function DeleteUs($idUS){
		global $TableUSGlob;
		global $TableTaskGlob;
		$query = "DELETE FROM $TableUSGlob WHERE id = '$idUS'";
		$result = launchQuery($query);
		if($result){
			$query = "DELETE FROM $TableTaskGlob WHERE userstory = '$idUS'";
			$result = launchQuery($query);
		}
		return $result;
	}
	
	/**
	 * [GetUSByProject Permet de récupérer toutes les US d'un projet]
	 * @param [int] $idProject 
	 * @return Liste d'US.
	 */
	function GetUSByProject($idProject){
		global $TableUSGlob;
		$query = "SELECT * FROM $TableUSGlob WHERE project = '$idProject' ORDER BY id ASC";
		$result = launchQuery($query);
		return $result;
	}


	/**
	 * [AlterPrioUS Permet de modifier la priorité d'une US]
	 * @param [int] $idUS
	 * @param [int] $prioUS
	 * @return Void
	 */

	function AlterPrioUS($prioUS,$idUS){
		global $TableUSGlob;
		$query = "UPDATE $TableUSGlob SET priority = '$prioUS' WHERE id = '$idUS'";
		$result = launchQuery($query);
	}

	/**
	 * [AlterPrioUS Permet de modifier l'action d'une US]
	 * @param [int] $idUS
	 * @param [int] $actiobUS
	 * @return Void
	 */
	
	function AlterActionUS($actionUS,$idUS){
		global $TableUSGlob;
		$query = "UPDATE $TableUSGlob SET action = '$actionUS' WHERE id = '$idUS'";
		$result = launchQuery($query);
	}

	/**
	 * [AlterPrioUS Permet de modifier le champ rank d'une US]
	 * @param [int] $idUS
	 * @param [int] $rankUS
	 * @return Void
	 */

	function AlterRankUS($rankUS,$idUS){
		global $TableUSGlob;
		$query = "UPDATE $TableUSGlob SET rank = '$rankUS' WHERE id = '$idUS'";
		$result = launchQuery($query);
	}

	/**
	 * [AlterPrioUS Permet de modifier le champ goal d'une US]
	 * @param [int] $idUS
	 * @param [int] $goalUS
	 * @return Void
	 */

	function AlterGoalUS($goalUS,$idUS){
		global $TableUSGlob;
		$query = "UPDATE $TableUSGlob SET goal = '$goalUS' WHERE id = '$idUS'";
		$result = launchQuery($query);
	}

	/**
	 * [AlterPrioUS Permet de modifier la difficulté d'une US]
	 * @param [int] $idUS
	 * @param [int] $diffUS
	 * @return Void
	 */

	function AlterDifficultyUS($diffUS,$idUS){
		global $TableUSGlob;
		$query = "UPDATE $TableUSGlob SET difficulty = '$diffUS' WHERE id = '$idUS'";
		$result = launchQuery($query);
	}
	
	/**
	 * [GetUSIdInProject Permet de récupérer la position dans le projet d'une US]
	 * @param [int] $idProject
	 * @param [int] $idUS
	 * @return [int] The position of the US 
	 */
	
	function GetUSIdInProject($idProject,$idUS){
		$result = GetUSByProject($idProject);
		$idUSInPage = 1;
		while($data = $result->fetch_array(MYSQLI_NUM)){
			if($data[0] == $idUS)
				return $idUSInPage;
			$idUSInPage++;
		}
	}

	function getUS($idUs){
		global $TableUSGlob;
		$query = "SELECT * FROM $TableUSGlob WHERE id='$idUs' ";
		$result = launchQuery($query);
		return $result;
	}
	
	
	
	
	
	
	
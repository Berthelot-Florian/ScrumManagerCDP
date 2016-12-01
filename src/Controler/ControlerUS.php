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
	function AddUs($idProject,$sprint,$rank,$action,$goal,$difficulty){
		global $TableUSGlob;
		$query = "INSERT INTO $TableUSGlob (`project`,`sprint`, `rank`, `action`, `goal`, `difficulty`) VALUES ('$idProject',$sprint,'$rank','$action','$goal','$difficulty') ";
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
	 * [AlterSprintUS Permet de modifier le Sprint d'une US]
	 * @param [int] $idUS
	 * @param [int] $sprintUS
	 * @return Void
	 */

	function AlterSprintUS($sprintUS,$idUS){
		global $TableUSGlob;
		$query = "UPDATE $TableUSGlob SET sprint = '$sprintUS' WHERE id = '$idUS'";
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

	/**
	 * [getUS Permet de récupérer toutes les information d'une US avec son ID]
	 * @param  [int] $idUs [id de la userStory]
	 * @return [mysqli_result]       [information de la US]
	 */
	function getUS($idUs){
		global $TableUSGlob;
		$query = "SELECT * FROM $TableUSGlob WHERE id='$idUs' ";
		$result = launchQuery($query);
		return $result;
	}

	/**
	 * [GetUSByProjectSprint Permet de récupérer tout les US d'un sprint]
	 * @param [int] $idProject [numéro du projet]
	 * @param [int] $sprint    [numéro du sprint]
	 */
	function GetUSByProjectSprint($idProject,$sprint){
		global $TableUSGlob;
		$query = "SELECT * FROM $TableUSGlob WHERE project = '$idProject' AND sprint='$sprint' ORDER BY sprint ASC";
		$result = launchQuery($query);
		return $result;
	}
	
	/**
	 * [GetTotalUSDifficultyInProject Permet de récupérer le difficulté totale des US d'un projet]
	 * @param [int] $idProject [numéro du projet]
	 */
	function GetTotalUSDifficultyInProject($idProject){
		global $TableUSGlob;
		$totalDifficulty = 0;
		
		$query = "SELECT * FROM $TableUSGlob WHERE project = '$idProject' ";
		$result = launchQuery($query);
		
		while($data = $result->fetch_array(MYSQLI_NUM)){
			$totalDifficulty += $data[7];
		}		
		return $totalDifficulty;
	}
	
	/**
	 * [GetUSDifficultiesBySprints Permet de récupérer le difficulté totale des US d'un projet]
	 * @param [int] $idProject [numéro du projet]
	 */
	function GetUSDifficultiesBySprints($idProject,$totalDifficulty){
		global $TableUSGlob;
		$difficultyBySprint = [];
		$difficultyBySprint[0] = $totalDifficulty;
		$indexSprint=1;
		$result = getSprints($idProject);
		while($data = $result->fetch_array(MYSQLI_NUM)){
			$allUSBySprint = GetUSByProjectSprint($idProject,$data[1]);
			$difficultyBySprint[$indexSprint] = $difficultyBySprint[$indexSprint-1];
			while($us = $allUSBySprint->fetch_array(MYSQLI_NUM)){
				$difficultyBySprint[$indexSprint]-=$us[7];
			}
			$indexSprint++;
		}		
		return $difficultyBySprint;
	}
	
	/**
	 * [GetEffectiveDifficultiesBySprints Permet de récupérer le difficulté totale des US d'un projet]
	 * @param [int] $idProject [numéro du projet]
	 */
	function GetEffectiveDifficultiesBySprints($idProject,$totalDifficulty){
		global $TableUSGlob;
		$difficultyBySprint = [];
		$difficultyBySprint[0] = $totalDifficulty;
		$indexSprint=1;
		$result = getSprints($idProject);
		while($data = $result->fetch_array(MYSQLI_NUM)){
			$allUSBySprint = GetUSByProjectSprint($idProject,$data[1]);
			$difficultyBySprint[$indexSprint] = $difficultyBySprint[$indexSprint-1];
			while($us = $allUSBySprint->fetch_array(MYSQLI_NUM)){
				if(IsUsDone($us[0])){
					$difficultyBySprint[$indexSprint]-=$us[7];
				}
			}
			
			$indexSprint++;
		}		
		return $difficultyBySprint;
	}
	
	/**
	 * [GetUSDifficultiesBySprints Permet de récupérer le difficulté totale des US d'un projet]
	 * @param [int] $idProject [numéro du projet]
	 */
	function IsUsDone($idUS){
		global $TableUSGlob;
		$isDone=true;
		$result = getTaskByUs($idUS);
		while($data = $result->fetch_array(MYSQLI_NUM)){
			if($data[5] != 3)
				$isDone = false;
		}		
		return $isDone;
	}
	
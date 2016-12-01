<?php 
	$_SESSION['ControlerTask'] = '1';
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
	function AddTask($idProject,$description,$effort,$idUS){
		global $TableTaskGlob;
		printf("id project ".$idProject."\n");
		printf("description ".$description."\n");
		printf("effort ".$effort."\n");
		printf("idUS ".$idUS."\n");
		$query = "INSERT INTO $TableTaskGlob (`project`, `description`, `effort`, `userstory`,`state` ) VALUES ('$idProject','$description','$effort','$idUS',0) ";
		return launchQuery($query);
	}
	
	/**
	 * [NotExistTask Vérifie qu'une tache n'existe pas déjà]
	 * @param [int] $idUS        [id du l'US]
	 * @param [string] $description [Descritpion de la tache]
	 */
	function NotExistTask($idUS,$description){
		global $TableTaskGlob;
		$query = "SELECT * FROM $TableTaskGlob WHERE userstory = '$idUS' AND description = '$description'";
		$result = launchQuery($query);
		if(mysqli_num_rows($result)==0)
			return true;
		return false;
	}
	
	/**
	 * [GetTaskByProject Permet de récupéré toute les tache d'un projet]
	 * @param [int] $idProject [id du projet]
	 */
	function GetTaskByProject($idProject){
		global $TableTaskGlob;
		$query = "SELECT * FROM $TableTaskGlob WHERE project = '$idProject' ORDER BY userstory ASC";
		return launchQuery($query);
	}
	
	/**
	 * [ToStringState Permet de passé un état en string afin de pouvoir l'afficher]
	 * @param [string] $state [état à passé en string]
	 */
	function ToStringState($state){
		switch($state){
			case 0:
				return "To Do";
			case 1:
				return "On Going";
			case 2:
				return "On Test";
			case 3:
				return "Done";
		}
	}
	
	/**
	 * [UpdateTask Permet de mettre a jour une tache]
	 * @param [string] $description [description de la tache]
	 * @param [int] $effort      [effort de la tache]
	 * @param [int] $linkedUS    [userstory lié a cette tache]
	 * @param [string] $state       [état de la tache]
	 * @param [int] $task        [id de la tache a mettre a jour]
	 */
	function UpdateTask($description,$effort,$linkedUS,$state,$task){
		global $TableTaskGlob;
		$query = "UPDATE $TableTaskGlob SET description = '$description' , effort = '$effort' , userstory = '$linkedUS' , state = '$state' WHERE id = '$task'";
		$result = launchQuery($query);
	}
	
	/**
	 * [DeleteTask Permet de supprimer une tâche]
	 * @param [int] $idTask [id de la tache]    
	 * @return [boolean] TRUE si réussie, false sinon
	 */
	function DeleteTask($idTask){
		global $TableTaskGlob;
		$query = "DELETE FROM $TableTaskGlob WHERE id = '$idTask'";
		return launchQuery($query);
	}

	/**
	 * [getTask permet de récupéré une tache en particulier]
	 * @param  [int] $idTask [id de la tache a récupéré]
	 * @return [MySqli_result]         [tache a récupéré]
	 */
	function getTask($idTask){
		global $TableTaskGlob;
		$query = "SELECT * FROM $TableTaskGlob WHERE id='$idTask'";
		$result = launchQuery($query);
		return $result;
	}
	
	/**
	 * [getTaskByUs Permet de récupéré toute les tache ratacher à une userStory en particulier]
	 * @param  [int] $us [id de la UserStory]
	 * @return [Mysqli_result]     [tache lié a la US]
	 */
	function getTaskByUs($us){
		global $TableTaskGlob;
		$query = "SELECT * FROM $TableTaskGlob WHERE userstory='$us'";
		$result = launchQuery($query);
		return $result;
	}

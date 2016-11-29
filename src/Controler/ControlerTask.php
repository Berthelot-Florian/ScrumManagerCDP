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
	
	function NotExistTask($idUS,$description){
		global $TableTaskGlob;
		$query = "SELECT * FROM $TableTaskGlob WHERE userstory = '$idUS' AND description = '$description'";
		$result = launchQuery($query);
		if(mysqli_num_rows($result)==0)
			return true;
		return false;
	}
	
	function GetTaskByProject($idProject){
		global $TableTaskGlob;
		$query = "SELECT * FROM $TableTaskGlob WHERE project = '$idProject' ORDER BY userstory ASC";
		return launchQuery($query);
	}
	
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
	
	function UpdateTask($description,$effort,$linkedUS,$state,$task){
		global $TableTaskGlob;
		$query = "UPDATE $TableTaskGlob SET description = '$description' , effort = '$effort' , userstory = '$linkedUS' , state = '$state' WHERE id = '$task'";
		$result = launchQuery($query);
	}
	
	/**
	 * [DeleteTask Permet de supprimer une tâche]
	 * @param [int] $idTask [description]    
	 * @return [boolean] TRUE si réussie, false sinon
	 */
	function DeleteTask($idTask){
		global $TableTaskGlob;
		$query = "DELETE FROM $TableTaskGlob WHERE id = '$idTask'";
		return launchQuery($query);
	}


	/**
	 * [getTask description]
	 * @param  [type] $idTask [description]
	 * @return [type]         [description]
	 */
	function getTask($idTask){
		global $TableTaskGlob;
		$query = "SELECT * FROM $TableTaskGlob WHERE id='$idTask'";
		$result = launchQuery($query);
		return $result;
	}
	
	function getTaskByUs($us){
		global $TableTaskGlob;
		$query = "SELECT * FROM $TableTaskGlob WHERE userstory='$us'";
		$result = launchQuery($query);
		return $result;
	}

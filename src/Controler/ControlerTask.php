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
	/**
	 * [getTasksOfSprint Permet de récupérer toutes les tâches d'un sprint]
	 * @param  [int] $idSprint [id du sprint]
	 * @return [Mysqli_result]     [tâches du sprint]
	 */
	function getTasksOfSprint($idSprint){
		global $TableTaskGlob;
		global $TableUSGlob;
		$query="SELECT * FROM $TableTaskGlob WHERE userstory IN (SELECT id FROM $TableUSGlob WHERE sprint='$idSprint')";
		$result = launchQuery($query);
		return $result;
	}
	/**
	 * [GetTaskByProjectAndSprint Permet de récupéré toute les taches d'un sprint]
	 * @param [int] $idProject [id du projet]
	 * @param [int] $idSprint  [id du sprint]
	 */
	function GetTaskByProjectAndSprint($idProject,$idSprint){
		$result = GetUSByProjectSprint($idProject,$idSprint);
		$data = $result->fetch_array(MYSQLI_NUM);
		$allTask = getTaskByUs($data[0]);
		while($data = $result->fetch_array(MYSQLI_NUM)){
			$usTasks = getTaskByUs($data[0]);
			mysqli_stmt_bind_result($allTask,$usTasks);
		}
		return $allTask;
	}	
	/**
	 * [getUntakenTask Permet de récupérer les tâches non affectés àun utilisateur d'un sprint]
	 * @param  [int] $idSprint [id du sprint]
	 * @return [Mysqli_result]     [tâches non affectés du sprint]
	 */
	function getUntakenTask($idSprint){
		global $TableTaskGlob;
		global $TableUSGlob;
		global $TableContribTaskGlob;
		$query="SELECT * FROM $TableTaskGlob WHERE userstory IN (SELECT id FROM $TableUSGlob WHERE sprint='$idSprint') AND id NOT IN (SELECT task FROM $TableContribTaskGlob)";
		$result = launchQuery($query);
		return $result;	
	}
	/**
	 * [getToDoTask Permet de récupérer toutes les tâches à faire d'un utilisateur sur un sprint]
	 * @param  [int] $idSprint [id du sprint]
	 * @param  [int] $idUser [id de l'utilisateur]
	 * @return [Mysqli_result]     [tâches à faire de l'utilisateur sur le sprint]
	 */
	function getToDoTask($idSprint, $idUser){
		global $TableTaskGlob;
		global $TableUSGlob;
		global $TableContribTaskGlob;
		$query="SELECT * FROM $TableTaskGlob WHERE state='0' AND userstory IN (SELECT id FROM $TableUSGlob WHERE sprint='$idSprint') AND id IN (SELECT task FROM $TableContribTaskGlob WHERE contributor='$idUser')";
		$result = launchQuery($query);
		return $result;
	}
	/**
	 * [getOnGoingTask Permet de récupérer toutes les tâches en cours d'un utilisateur sur un sprint]
	 * @param  [int] $idSprint [id du sprint]
	 * @param  [int] $idUser [id de l'utilisateur]
	 * @return [Mysqli_result]     [tâches en cours de l'utilisateur sur le sprint]
	 */
	function getOnGoingTask($idSprint, $idUser){
		global $TableTaskGlob;
		global $TableUSGlob;
		global $TableContribTaskGlob;
		$query="SELECT * FROM $TableTaskGlob WHERE state='1' AND userstory IN (SELECT id FROM $TableUSGlob WHERE sprint='$idSprint') AND id IN (SELECT task FROM $TableContribTaskGlob WHERE contributor='$idUser')";
		$result = launchQuery($query);
		return $result;
	}
	/**
	 * [getOnTestTask Permet de récupérer toutes les tâches en cours de test d'un utilisateur sur un sprint]
	 * @param  [int] $idSprint [id du sprint]
	 * @param  [int] $idUser [id de l'utilisateur]
	 * @return [Mysqli_result]     [tâches en cours de test de l'utilisateur sur le sprint]
	 */
	function getOnTestTask($idSprint, $idUser){
		global $TableTaskGlob;
		global $TableUSGlob;
		global $TableContribTaskGlob;
		$query="SELECT * FROM $TableTaskGlob WHERE state='2' AND userstory IN (SELECT id FROM $TableUSGlob WHERE sprint='$idSprint') AND id IN (SELECT task FROM $TableContribTaskGlob WHERE contributor='$idUser')";
		$result = launchQuery($query);
		return $result;
	}
	/**
	 * [getDoneTask Permet de récupérer toutes les tâches finies d'un utilisateur sur un sprint]
	 * @param  [int] $idSprint [id du sprint]
	 * @param  [int] $idUser [id de l'utilisateur]
	 * @return [Mysqli_result]     [tâches finies de l'utilisateur sur le sprint]
	 */
	function getDoneTask($idSprint, $idUser){
		global $TableTaskGlob;
		global $TableUSGlob;
		global $TableContribTaskGlob;
		$query="SELECT * FROM $TableTaskGlob WHERE state='3' AND userstory IN (SELECT id FROM $TableUSGlob WHERE sprint='$idSprint') AND id IN (SELECT task FROM $TableContribTaskGlob WHERE contributor='$idUser')";
		$result = launchQuery($query);
		return $result;
	}
	/**
	 * [updateTask Permet de modifier l'état d'avancement d'une tâche]
	 * @param [int] $newState [valeur de l'état]
	 * @param [int] $idTask  [id de la tâche]
	 */
	function updateState($newState,$idTask){
		global $TableTaskGlob;
		$query = "UPDATE $TableTaskGlob SET state = '$newState' WHERE id = '$idTask'";
		$result = launchQuery($query);
	}

	/**
	 * [takeTask Permet de s'approprier une tâche]
	 * @param [int] $task [id de la tâche]
	 */
	function takeTask($task){
		global $TableContribTaskGlob;
		$idContributor = $_SESSION['id'];
		$query = "INSERT INTO $TableContribTaskGlob VALUES ('$idContributor','$task')";
		launchQuery($query);
	}

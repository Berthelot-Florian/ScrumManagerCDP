<?php 
	$_SESSION['ControlerUser'] = '1';
	if(!isset($_SESSION['ControlerBdd']))
		include '../Controler//ControlerBdd.php';
	if(!isset($_SESSION['Variables']))
		require '../Model/Variables.php';
	

	/**
	 * @param [name] [<description>][getAllUsers Fonction pour récupéré tout les utilisateurs]
	 * @return [mysqli_result] [toute les informations de l'utilisateur]
	 */
	function getAllUsers(){
		global $TableUserGlob;
		$query = "SELECT * FROM $TableUserGlob";
		$result = launchQuery($query);
		return $result;
	}
	
/**
 * Cette fonction sert à récupérer un utilisateur par son ID
 *
 * @param int $id
 *     ID de l'utilisateur
 *
 * @return La ligne d'information de l'utilisateur ou FALSE si il n'est pas trouvé
 **/
	function getUserByID($id){
		
		global $TableUserGlob;
		$idUser = intval($id);
		
		$query = "SELECT * FROM $TableUserGlob WHERE id = '$idUser'";
		$result = launchQuery($query);
		
		$row = $result->fetch_array(MYSQLI_NUM);
		return $row;
	}

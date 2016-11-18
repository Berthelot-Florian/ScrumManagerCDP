<?php 
	$_SESSION['ControlerAuth'] = '1';
	if(!isset($_SESSION['ControlerBdd']))
		include 'ControlerBdd.php';
	if(!isset($_SESSION['Variables']))
		include '../Model/Variables.php';

	/**
	 * [connectUser Fonction pour connecter un utilisateur]
	 * @param  [String] $login    [Login de l'utilisateur essayant de ce connecter]
	 * @param  [String] $password [Passsword de l'utilisateur essayant de ce connecter]
	 * @return [Boolean]           [Retourne TRUE si l'utilisateur est correct et FALSE si ça ne l'est pas]
	 */
	function connectUser($login,$password){
		global $TableUserGlob;
		$conn = connectBdd();
		$login =  mysqli_real_escape_string($conn,$login);
		$password = md5(mysqli_real_escape_string($conn,$password));
		//On va chercher dans la BDD l'utilisateur correspondant 
		$query = "SELECT * FROM $TableUserGlob WHERE login='$login' and password='$password'" ;
		$result = launchQuery($query);	
		if(mysqli_num_rows($result)==1){
			session_start();
			$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
			$_SESSION['id'] = $row['id'];
			$_SESSION['login'] = $row['login'];
			$_SESSION['pseudo'] = $row['pseudo'];
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * [isConnected Check si l'utilisateur courant est connecter]
	 * @return boolean [Return TRUE si l'utilisateur est bien connecter sinon FALSE]
	 */
	function isConnected(){
		global $TableUserGlob;
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		if(isset($_SESSION['login'])){
			if($_SESSION['login'] == ''){
				return FALSE;
			}
			else 
				return TRUE;
		}
		else{
			return FALSE;
		}
	}
	/**
	 * [disconnect Permet de ce déconnecter]
	 */
	function disconnect(){
		session_start();
		session_destroy();
	}

		/**
	 * [isPO Permet de tester si l'utilisateur connecter est le ProductOwner d'un projet]
	 * @param  [int]  $idProjet [id du projet a tester]
	 * @return boolean           [Renvois TRUE si l'utilisateur est le PO et FALSE sinon]
	 */
	function isPO($id,$idUser){
		global $TableProjetGlob;
		$idProjet = intval($id);
		if(isConnected()){
			$query = "SELECT ProductOwner FROM $TableProjetGlob WHERE $idProjet = id AND $idUser = productowner";
			$result = launchQuery($query);
			$row = mysqli_fetch_array($result,MYSQLI_NUM);
				if($_SESSION['id'] == $row[0]){
					return TRUE;
				}
		} 
		return FALSE;
	}

	/**
	 * [isScrumMaster Permet de tester si l'utilisateur connecter est le SM d'un projet]
	 * @param  [int]  $idProjet [id du projet a tester]
	 * @return boolean           [Renvois TRUE si l'utilisateur est le SM et FALSE sinon]
	 */
	function isScrumMaster($idProjet){
		global $TableProjetGlob;
		if(isConnected()){
			$query = "SELECT ScrumMaster FROM $TableProjetGlob WHERE $idProjet = id ";
			$result = launchQuery($query);
			$row = mysqli_fetch_array($result,MYSQLI_NUM);
				if($_SESSION['id'] == $row[0]){
					return TRUE;
				}
		} 
		return FALSE;
	}

	/**
	 * [isContributor Permet de tester si l'utilisateur connecter est contribiteur d'un projet]
	 * @param  [id]  $idProjet [id du projet a tester]
	 * @return boolean           [Renvois TRUE si l'utilisateur est contributeur et FALSE sinon]
	 */
	function isContributor($idProjet){
		global $TableContribGlob;
		if(isConnected()){
			$idUser = $_SESSION['id'];
			$query = "SELECT * FROM $TableContribGlob WHERE $idProjet = Project AND $idUser = Contributor  ";
			$result = launchQuery($query);
			if(mysqli_num_rows($result)==1){
				return TRUE;
			}
		} 
		return FALSE;
	}

	/**
	 * [isContributor Permet de tester si l'utilisateur connecter est contribiteur d'un projet]
	 * @param  [id]  $idProjet [id du projet a tester]
	 * @param  [id]  $idUser [id du user a tester]
	 * @return boolean           [Renvois TRUE si l'utilisateur est contributeur et FALSE sinon]
	 */
	function isContributor2($idProjet,$idUser){
		global $TableContribGlob;
		if(isConnected()){
			$query = "SELECT * FROM $TableContribGlob WHERE $idProjet = Project AND $idUser = Contributor  ";
			$result = launchQuery($query);
			if(mysqli_num_rows($result)==1){
				return TRUE;
			}
		} 
		return FALSE;
	}

	/**
	 * [addContributor Permet d'ajouter un contributeur à un projet]
	 * @param [project] $idProjet [id du projet auquel on rajoute un contributeur]
	 * @param [contributor] $idContributor [id du contributeur ajouté au projet]
	 * @return boolean [retourne TRUE si l'ajout s'est bien déroulé]
	*/
	function addContributor($idProjet,$idContributor){
		global $TableContribGlob;
		if(isContributor($idProjet)){
			$query = "INSERT INTO $TableContribGlob ( `contributor`, `project` ) VALUES ('$idContributor','$idProjet')";
			return $result = launchQuery($query);
		}
		return FALSE;
	}
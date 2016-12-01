<?php 

	$_SESSION['ControlerTracab'] = '1';
	if(!isset($_SESSION['ControlerBdd']))
		include 'ControlerBdd.php';
	if(!isset($_SESSION['Variables']))
		require '../Model/Variables.php';
	

	/**
	 * [addTrac Permet d'ajouter la tracabilité d'un sprint]
	 * @param [int] $projet [id du projet]
	 * @param [int] $sprint [nuemro du sprint]
	 * @param [String] $commit [id du commit]
	 * @param [String] $link   [Lien du site de subversion]
	 */
	function addTrac($projet,$sprint,$commit,$link){
		global $TableTracabGlob;
		$query = "INSERT INTO $TableTracabGlob (`projet`, `sprint`, `commit`, `link`) VALUES ('$projet','$sprint','$commit','$link')";
		$result = launchQuery($query);
		return $result;
	}

	/**
	 * [getTracab Retourne toute les tracabilité d'un projet]
	 * @param  [int] $projet [id du projet]
	 * @return [MySQLI_result]         [Ensemble des tracabilite d'un projet]
	 */
	function getTracab($projet){
		global $TableTracabGlob;
		$query = "SELECT * FROM $TableTracabGlob WHERE projet='$projet'";
		$result = launchQuery($query);
		return $result;
	}

	/**
	 * [getTracabSp Permet de récupéré une tracabilité en particulier]
	 * @param [int] $projet [id du projet]
	 * @param [int] $sprint [nuemro du sprint]
	 * @return [MySQLI_result]         [Information de la tracabilité]
	 */
	function getTracabSp($projet,$sprint){
		global $TableTracabGlob;
		$query = "SELECT * FROM $TableTracabGlob WHERE projet='$projet' AND sprint='$sprint'";
		$result = launchQuery($query);
		return $result;
	}

	/**
	 * [alterTracab Permet de modifier une tracabilité]
	 * @param [int] $projet [id du projet]
	 * @param [int] $sprint [nuemro du sprint]
	 * @param [String] $commit [id du commit]
	 * @param [String] $link   [Lien du site de subversion]
	 * @return [Boolean]         [Vrai si réussi, faux sinon]
	 */
	function alterTracab($projet,$sprint,$commit,$link){
		global $TableTracabGlob;
		$query = "UPDATE $TableTracabGlob SET `commit`='$commit', `link`='$link' WHERE projet='$projet' AND sprint='$sprint'";
		$result = launchQuery($query);
		return $result;
	}

	/**
	 * [removeTracab Permet de supprimer une tracabilité]
	 * @param  [int] $projet [id du projet]
	 * @param  [int] $sprint [numéro du sprint]
	 * @return [boolean]         [vrai si réussi, faux sinon]
	 */
	function removeTracab($projet,$sprint){
		global $TableTracabGlob;
		$query = "DELETE FROM $TableTracabGlob WHERE `projet`='$projet' AND `sprint`='$sprint'";
		$result = launchQuery($query);
		return $result;
	}
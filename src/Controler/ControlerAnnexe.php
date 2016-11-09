<?php 
	$_SESSION['ControlerAnnexe'] = '1';
	if(!isset($_SESSION['ControlerBdd']))
		include 'ControlerBdd.php';
	if(!isset($_SESSION['Variables']))
		require '../Model/Variables.php';


	/**
	 * [addAnnexe Permet d'ajouter un annexe]
	 * @param [int] $idProjet 		[id du projet]
	 * @param [String] $file     	[nom du fichier]
	 * @param [String] $type     	[type du fichier]
	 * @return [Boolean] 			[True si réussis, false sinon]
	 */
	function addAnnexe($idProjet,$file,$type){
		global $TableAnnexeGlob;
		$idProjet = intval($idProjet);
		$query = "INSERT INTO $TableAnnexeGlob VALUES('$idProjet',$file','$type')";
		$result = launchQuery($query);
		return $result;
	}

	/**
	 * [getAnnexe Permet de récupéré l'ensemble des annexes d'un projet]
	 * @param  [int] $idProjet  [id du projet]
	 * @return [mysqli_result]  [Annexes du projet]
	 */
	function getAnnexe($idProjet){
		global $TableAnnexeGlob;
		$idProjet = intval($idProjet);
		$query = "SELECT * FROM $TableAnnexeGlob WHERE project = '$idProjet'";
		$result = launchQuery($query);
		return $result;
	}

	/**
	 * [suppAnnexe permet de supprimer un annexe]
	 * @param  [int] $idProjet 	  [id du projet]
	 * @param  [String] $file     [nom du fichier]
	 * @return [Boolean]          [True si réussi, false sinon]
	 */
	function suppAnnexe($idProjet,$file){
		global $TableAnnexeGlob;
		$idProjet = intval($idProjet);
		$query = "DELETE FROM $TableAnnexeGlob WHERE name = '$file'"; 
		$result = launchQuery($query);
		return $result;
	}
<?php 
	$_SESSION['ControlerAnnexe'] = '1';
	if(!isset($_SESSION['ControlerBdd']))
		include 'ControlerBdd.php';
	if(!isset($_SESSION['Variables']))
		require '../Model/Variables.php';



	function addAnnexe($idProjet,$file,$type){
		global $TableAnnexeGlob;
		$idProjet = intval($idProjet);
		$query = "INSERT INTO $TableAnnexeGlob VALUES('$idProjet',$file','$type')";
		$result = launchQuery($query);
		return $result;
	}


	function getAnnexe($idProjet){
		global $TableAnnexeGlob;
		$idProjet = intval($idProjet);
		$query = "SELECT * FROM $TableAnnexeGlob WHERE idProjet = '$idProjet'";
		$result = launchQuery($query);
		return $result;
	}

	function suppAnnexe($idProjet,$file){
		global $TableAnnexeGlob;
		$idProjet = intval($idProjet);
		$query = "DELETE FROM $TableAnnexeGlob WHERE name = '$file'"; 
		$result = launchQuery($query);
		return $result;
	}
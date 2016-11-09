<?php 
	$_SESSION['ControlerProject'] = '1';
	if(!isset($_SESSION['ControlerBdd']))
		include 'ControlerBdd.php';
	if(!isset($_SESSION['Variables']))
		require '../Model/Variables.php';
	
	
	
	/**
	 * [signUp Permet d'enregistrer un utilisateur dans la BDD]
	 * @return FALSE ou TRUE;
	 */
	function signUp($login,$password,$pseudo,$email){
		global $TableUserGlob;
		$conn = connectBdd();
		$password = md5($password);
		/* Vérification de doublon de login */
		$queryTest = "SELECT * FROM Users WHERE login='$login'" ;
		$resultTest = launchQuery($queryTest);
		if(mysqli_num_rows($resultTest)==1)
			return FALSE;
		$query = "INSERT INTO Users (login,password,pseudo,email) VALUES ('$login','$password','$pseudo','$email')" ;
		launchQuery($query);
		return TRUE;
	}
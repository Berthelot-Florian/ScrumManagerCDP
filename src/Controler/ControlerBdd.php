<?php
	include './Model/Variables.php';

	/**
	 * [Fonction de connexion a la BDD]
	 * @return [Object Mysqli] [Permet d'effectuer les actions sur la BDD] 
	 */
	function connectBdd(){
		//On prend les valeurs en global
		global $hostGlob,$userGlob,$passwdGlob,$bddGlob;
		$conn = mysqli_connect($hostGlob,$userGlob,$passwdGlob,$bddGlob) or die('Error connecting to database');	
		return $conn;
	}

	/**
	 * [Permet de lancer une requête MySQL sur la BDD]
	 * @param  [String] $query [requête MySQL correct]
	 * @return [mysqli_result]        [Résultat de la requête SQL ou FALSE si la requête a échouer]
	 */
	function launchQuery($query){
		$conn = connectBdd();
		//On retire les caractère spéciaux
		mysqli_real_escape_string($conn,$query);
		$result = mysqli_query($conn,$query);
		if($result === FALSE){
			printf("Echec de la requête");
		}
		return $result;
	}

	
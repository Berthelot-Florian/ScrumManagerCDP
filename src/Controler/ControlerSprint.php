<?php 
	$_SESSION['ControlerSprint'] = '1';
	if(!isset($_SESSION['ControlerBdd']))
		include 'ControlerBdd.php';
	if(!isset($_SESSION['Variables']))
		require '../Model/Variables.php';


	/**
	 * [getSprints Retourne tout les sprints d'un projet]
	 * @param  [int] $idProjet [id du projet]
	 * @return [mysqli_result]           [tout les sprints]
	 */
	function getSprints($idProjet){
		global $TableSprintglob;
		$query = "SELECT * FROM $TableSprintglob WHERE project='$idProjet' ";
		$result = launchQuery($query);
		return $result;
	}

	/**
	 * [alterSprint description]
	 * @param  [int] $id    [id du sprint]
	 * @param  [int] $num   [numero du sprint dans le projet]
	 * @param  [date] $start [date de debut du sprint]
	 * @param  [date] $end   [date de fin du sprint]
	 * @param  [string] $state [état du sprint]
	 * @return [boolean]        [True si réussi, false sinon]
	 */
	function alterSprint($id,$num,$start,$end,$state){
		global $TableSprintglob;
		$query = "UPDATE $TableSprintglob SET 
		`number`='$num',
		`start`='$start',
		`end`='$end', 
		`state`='$state'  
		WHERE id='$id'";
		return launchQuery($query);
	}

	/**
	 * [getSprint description]
	 * @param  [type] $idProjet [description]
	 * @param  [type] $num      [description]
	 * @return [type]           [description]
	 */
	function getSprint($idProjet,$num){
		global $TableSprintglob;
		$query = "SELECT * FROM $TableSprintglob WHERE project='$idProjet' AND number='$num'";
		$result = launchQuery($query);
		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
		return $row;
	}


	function addSprint($idProjet,$num,$start,$end){
		global $TableSprintglob;
		$state = "todo";
		$query = "INSERT INTO $TableSprintglob  (`number`, `project`, `start`, `end`,`state`) VALUES ('$num', '$idProjet', '$start', '$end','$state')" ;
		$result = launchQuery($query);
		return $result; 
	}


	/**
	 * [check_Date Permet de tester la validité d'une date]
	 * @param  [string] $date [la date a tester au format dd/mm/aaaa ]
	 * @return [boolean]       [Vrai si la date est bonne, faux sinon]
	 */
	function check_Date($date){
		$toTest = explode("/",$date);
		$jj = intval($toTest[0]);
		$mm = intval($toTest[1]);
		$aaaa = intval($toTest[2]);
		if ($jj >=1 && $jj <= 31){
			if ($mm >=1 && $mm <= 12){
				if ($aaaa >= 2016){
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * [check_Date2 Vérifie si start est avec end]
	 * @param  [string] $start [date depbut de sprint]
	 * @param  [string] $end   [date fin du sprint]
	 * @return [boolean]        [return vrai ou faux si la date est bonne]
	 */
	function check_Date2($start,$end){
		$start = explode("/",$start);
		$end = explode("/",$end);

		$jj = intval($start[0]);
		$mm = intval($start[1]);
		$aaaa = intval($start[2]);

		$jj2 = intval($end[0]);
		$mm2 = intval($end[1]);
		$aaaa2 = intval($end[2]);

		if ($aaaa <= $aaaa2){
			if ($mm <= $mm2){
				if ($jj >= $jj2){
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * [dateToGoodFormat passe au bon format une date]
	 * @param  [string] $date [date de type dd/mm/yyyy]
	 * @return [string]       [date du type yyyy-mm-dd]
	 */
	function dateToGoodFormat($date){
		$toTest = explode("/",$date);
		$jj = intval($toTest[0]);
		$mm = intval($toTest[1]);
		$aaaa = intval($toTest[2]);
		return ($aaaa."-".$mm."-".$jj);
	}

	function checkNumSprint($idProjet,$num){
		global $TableSprintglob;
		$query = " SELECT * FROM $TableSprintglob WHERE `project`='$idProjet' AND `number`='$num' ";
		$result = launchQuery($query);
		if(mysqli_num_rows($result) > 0){
			return false;
		} else {
			return true;
		}
	}

	function removeSprint($projet,$sprint){
		global $TableSprintglob;
		$query ="DELETE FROM $TableSprintglob WHERE `project`='$projet' AND `number`='$sprint' ";
		return launchQuery($query);
	}
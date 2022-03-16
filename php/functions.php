<?php
require_once("php/mysql.php");

/**
 * Checks that the user is logged in. 
 * @return Returns the row of the logged in user
 */
function check_user($redirect = TRUE) {
	global $pdo;
	
	if(!isset($_SESSION['userid']) && isset($_COOKIE['identifier']) && isset($_COOKIE['securitytoken'])) {
		$identifier = $_COOKIE['identifier'];
		$securitytoken = $_COOKIE['securitytoken'];
		
		$statement = $pdo->prepare("SELECT * FROM securitytokens WHERE identifier = ?");
		$result = $statement->execute(array($identifier));
		$securitytoken_row = $statement->fetch();
		#error_log(pdo_debugStrParams($statement));
		#error_log(print_r($securitytoken_row));
		if(sha1($securitytoken) !== $securitytoken_row['securitytoken']) {
			//error('');
			//Vermutlich wurde der Security Token gestohlen
			//Hier ggf. eine Warnung o.ä. anzeigen
			
		} else { //Token war korrekt
			//Setze neuen Token
			$neuer_securitytoken = md5(uniqid());
			$insert = $pdo->prepare("UPDATE securitytokens SET securitytoken = :securitytoken WHERE identifier = :identifier");
			$insert->execute(array('securitytoken' => sha1($neuer_securitytoken), 'identifier' => $identifier));
			setcookie("identifier",$identifier,time()+(3600*24*90)); //90 Tage Gültigkeit
			setcookie("securitytoken",$neuer_securitytoken,time()+(3600*24*90)); //90 Tage Gültigkeit
	
			//Logge den Benutzer ein
			$_SESSION['userid'] = $securitytoken_row['user_id'];
		}
	}
	print_r($_SESSION);

	#error_log(print_r($_SESSION,true));
	if(!isset($_SESSION['userid'])) {
		if($redirect) {
			header("location: login.php");
			exit();
		} else {
			return FALSE;
		}
	} else {
		$stmt = $pdo->prepare("SELECT * FROM permission_group, users WHERE users.permission_group = permission_group.id and users.id = ?");
		$stmt->bindValue(1, $_SESSION['userid'], PDO::PARAM_INT);
		$stmt->execute();
		$user = $stmt->fetch();
	    #error_log(pdo_debugStrParams($stmt));
		return $user;
	}
}

/**
 * Outputs an error message and stops the further exectution of the script.
 */
function error($error_msg) {
	global $pdo;
	include_once("templates/header.php");
	include_once("templates/error.php");
	include_once("templates/footer.php");
	exit();
}

function isMobile () {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

function pdo_debugStrParams($stmt) {
	ob_start();
	$stmt->debugDumpParams();
	$r = ob_get_contents();
	ob_end_clean();
	return $r;
}

function check_style() {
	if(isset($_COOKIE['style'])) {
		if ($_COOKIE['style'] == 'dark') {
			return 'dark';
		} else if ($_COOKIE['style'] == 'light') {
			return 'light';
		}
	} else {
		return 'light';
	}
}
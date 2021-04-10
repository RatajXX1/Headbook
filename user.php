<?php
	require_once "settings.php";

	$Real_password = "x";
	$Real_login;
	$Real_ID;

	function verifi_user($login_name, $password, $sid) {
		global $adres_database, $login_database, $password_database, $use_database;
		global $Real_password, $Real_login, $Real_ID;
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
		$connection = mysqli_connect($adres_database, $login_database, $password_database, $use_database);
		mysqli_set_charset($connection, "utf8");
		$resolut = mysqli_query($connection, "SELECT * FROM HD_session WHERE ids = '{$sid}' AND adress_IP = '{$ip}' ;");
		if (mysqli_num_rows($resolut) > 0) {
			$sid = intval($sid);
			$resolut = mysqli_query($connection, "SELECT * FROM HD_users WHERE ids = {$sid};");		
			if (mysqli_num_rows($resolut) == 1) {
				$resolut = mysqli_fetch_assoc($resolut);
				if ( hash("sha256", $resolut["hd_pass"]) == $password) {
					if (hash('sha256' , $resolut['hd_mail']) == $login_name) {
						$Real_login = $resolut["hd_mail"];
						$Real_password = $resolut["hd_pass"];
						$Real_ID = $sid;
						mysqli_close($connection);
						return True;
					}
					elseif (hash("sha256" , $resolut["hd_phone"]) == $login_name ) {
						$Real_login = $resolut["hd_mail"];
						$Real_password = $resolut["hd_phone"];
						$Real_ID = intval($resolut["ids"]);
						mysqli_close($connection);
						return True;
					}
					else {
						mysqli_close($connection);
						return False;
					}
				}	
				else {
					mysqli_close($connection);
					return False;
				}
			} else {
				mysqli_close($connection);
				return False;
			}
		}
		else {
			mysqli_close($connection);
			return False;
		}
	}

	function get_users($idUser) {
		global $adres_database, $login_database, $password_database, $use_database;
		global $Real_ID;
		$connection = mysqli_connect($adres_database, $login_database, $password_database, $use_database);
		mysqli_set_charset($connection, "utf8");
		if (is_numeric($idUser)) {
			$idUser = intval($idUser);
			if ($idUser == $Real_ID or $idUser == 0) {	
				$resolut = mysqli_query($connection, "SELECT * FROM HD_users WHERE ids = {$Real_ID} ;");
				$resolut = mysqli_fetch_assoc($resolut);
				$resp->name = $resolut["hd_name"];
				$resp->surrname = $resolut["hd_surr"];
				$resp->birhday = $resolut["hd_birth"];
				$resp->gender = $resolut["hd_gender"];
				echo json_encode($resp);
			} else {
				$resolut = mysqli_query($connection, "SELECT * FROM HD_users WHERE ids = {$idUser} ;");
				if (mysqli_num_rows($resolut) > 0 ) {
					$resolut = mysqli_fetch_assoc($resolut);
					$resp->name = $resolut["hd_name"];
					$resp->surrname = $resolut["hd_surr"];
					$resp->birhday = $resolut["hd_birth"];
					$resp->gender = $resolut["hd_gender"];
					echo json_encode($resp);
				} else {
					http_response_code(404);
					echo "User no exist";
				}
			}
		} else {
			http_response_code(404);
			echo "Wrong format";
		}
		mysqli_close($connection);
	}

	if ($_SERVER["REQUEST_METHOD"] == "GET") {
		if (isset($_COOKIE["LN"]) && isset($_COOKIE["PW"]) && isset($_COOKIE["SID"])) {
			if (verifi_user($_COOKIE["LN"], $_COOKIE["PW"], $_COOKIE["SID"])) {
				if (isset($_GET["User_ID"])) {
					get_users($_GET["User_ID"]);
				} elseif (isset($_GET["Friends"] )) {
					http_response_code(404);
					echo "Not user id";
				}
			}
			else {
				http_response_code(404);
				echo "Not verified";
			}
		}
	} 

?>
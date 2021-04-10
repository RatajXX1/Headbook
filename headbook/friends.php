<?php 
	require_once "settings.php";
	
	$Real_password;
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
		$connection = mysqli_connect($adres_database, $login_database, $password_database, $use_database );
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

	function get_list_friends($page) {
		global $adres_database, $login_database, $password_database, $use_database;
		$connection = mysqli_connect($adres_database, $login_database, $password_database, $use_database);
		mysqli_set_charset($connection, "utf8");
		$from = 1 * $page;
		$resolut = mysqli_query($connection, "SELECT * FROM HD_friends WHERE User_id = {$Real_ID} limit {$from}, 15;");
		if (mysqli_num_rows($resolut) > 0) {
			while ($rows = mysqli_fetch_assoc($resolut)) {
				$get_info = mysqli_query($connection, "SELECT * FROM HD_users WHERE ids = {$rows["Friend_id"]} ;");
				$get_info = mysqli_fetch_assoc($get_info);
				$info->fullName = $get_info["hd_name"] . " " . $get_info["hd_surr"];
				$info->ids = $get_info["ids"];
				echo json_encode($info);
				echo "|";
			}
		} else {
			http_response_code(404);
			echo "No users";
		}
		mysqli_close($connection);
	}

	function get_friends($type) {
		if ($type == "active") {
			echo "ok";
		} elseif ($type == "list") {
			if (isset($_GET["page"]) && is_numeric($_GET["page"])) {
				get_list_friends(intval($_GET["page"]));
			}
		}
	} 

	function serach_friends($text) {
		global $adres_database, $login_database, $password_database, $use_database;
		if (strlen($text) > 0) {
			$connection = mysqli_connect($adres_database, $login_database, $password_database, $use_database);
			mysqli_set_charset($connection, "utf8");
			$text = explode("_", $text);
			if (count($text) == 1) {
				$resolut = mysqli_query($connection, "SELECT * FROM HD_users WHERE hd_name LIKE '%{$text[0]}%' ;");
				if (mysqli_num_rows($resolut) > 0){
					while ($rows = mysqli_fetch_assoc($resolut)) {
						$re->name = $rows["hd_name"] . " " . $rows["hd_surr"];
						$re->ids = $rows["ids"];
						echo json_encode($re);
						echo "|";
					}
				} else {
					http_response_code(404);
					echo "Not found";
				}
			}
			elseif (count($text) == 2) {
				$resolut = mysqli_query($connection, "SELECT * FROM HD_users WHERE hd_name LIKE '%{$text[0]}%' AND hd_surr LIKE '%{$text[1]}%' ;");
				if (mysqli_num_rows($resolut) > 0){
					while ($rows = mysqli_fetch_assoc($resolut)) {
						$re->name = $rows["hd_name"] . " " . $rows["hd_surr"];
						$re->ids = $rows["ids"];
						echo json_encode($re);
						echo "|";
					}
				} else {
					http_response_code(404);
					echo "Not found";
				}
			}
		}
		mysqli_close($connection);
	}

	if ($_SERVER["REQUEST_METHOD"] == "GET") {
		if (isset($_COOKIE["LN"]) && isset($_COOKIE["PW"]) && isset($_COOKIE["SID"])) {
			if (verifi_user($_COOKIE["LN"], $_COOKIE["PW"], $_COOKIE["SID"])) {
				if (isset($_GET["type"])) {
					get_friends($_GET["type"]);
				}
			}
		}
	} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_COOKIE["LN"]) && isset($_COOKIE["PW"]) && isset($_COOKIE["SID"])) {
			if (verifi_user($_COOKIE["LN"], $_COOKIE["PW"], $_COOKIE["SID"])) {
				if (isset($_POST["query"])) {
					serach_friends($_POST["query"]);
				}
			}
		}
	}

?>
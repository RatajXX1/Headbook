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

	function add_post($respo) {
		global $adres_database, $login_database, $password_database, $use_database;
		$connection = mysqli_connect($adres_database, $login_database, $password_database, $use_database);
		mysqli_set_charset($connection, "utf8");
		global $Real_ID;
		$Real_ID = strval($Real_ID);
		$resolut = mysqli_query($connection, "INSERT INTO HD_post (user_id, likes, message, wheres_location, photos_urls) VALUES ('{$Real_ID}', 0, '{$respo->text}', '{$respo->location}', '${$respo->photos}' ) ;");
		mysqli_close($connection);
	}

	function load_post($sid, $page) {
		global $adres_database, $login_database, $password_database, $use_database;
		$connection = mysqli_connect($adres_database, $login_database, $password_database, $use_database);
		mysqli_set_charset($connection, "utf8");
		$from = 1 * (15 * $page);
		$resolut = mysqli_query($connection, "SELECT * FROM HD_post WHERE user_id = '{$sid}' ORDER BY time_data DESC  Limit {$from}, 15 ;");
		while ($res = mysqli_fetch_assoc($resolut)) {
			$od->from = $res["user_id"];
			$od->likes = $res["likes"];
			$od->text = $res["message"];
			$od->location = $res["wheres_location"];
			$od->photos = $res["photos_urls"];
			$od->time = $res["time_data"];
			$name = mysqli_query($connection, "SELECT * FROM HD_users WHERE ids = {$res["user_id"]} ;");
			$name = mysqli_fetch_assoc($name);
			$od->relname = $name["hd_name"] . " " . $name["hd_surr"];
 			echo json_encode($od);
			echo "|";
		}
		mysqli_close($connection);
		return $resp;				
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_COOKIE["LN"]) && isset($_COOKIE["PW"]) && isset($_COOKIE["SID"])) {
			if (verifi_user($_COOKIE["LN"], $_COOKIE["PW"], $_COOKIE["SID"])) {
				$json = file_get_contents('php://input');
				$json = json_decode($json);
				add_post($json);
				echo "OK";
			} else {
				http_response_code(404);
				echo "No authorized";
			}
		}
	} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
		if (isset($_COOKIE["LN"]) && isset($_COOKIE["PW"]) && isset($_COOKIE["SID"])) {
			if (verifi_user($_COOKIE["LN"], $_COOKIE["PW"], $_COOKIE["SID"])) {
				if (isset($_GET["page"])) {
					load_post($Real_ID, intval($_GET["page"]));
				}
			} else {
				http_response_code(404);
				echo "No authorized";
			}
		}
	}

?>
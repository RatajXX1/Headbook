<?php
    require_once "headbook/settings.php";

    function check_login($loginec) {
        global $adres_database, $login_database, $password_database, $use_database;
        if (strlen($loginec) > 1 ) {
            if (is_numeric($loginec)) {
                // Phone
                $connection = mysqli_connect($adres_database, $login_database, $password_database, $use_database);
                mysqli_set_charset($connection, "utf8");
                $resoult = mysqli_query($connection , "SELECT * FROM HD_users WHERE hd_phone = '{$loginec}' ;");
                if (mysqli_num_rows($resoult) > 0) {
                    mysqli_close($connection);
                    return False;
                } else {
                    mysqli_close($connection);
                    return True;
                } 
            } else {
                // email
                if (filter_var($loginec, FILTER_VALIDATE_EMAIL) ) {
                    $connection = mysqli_connect($adres_database, $login_database, $password_database, $use_database);
                    mysqli_set_charset($connection, "utf8");
                    $resoult = mysqli_query($connection, "SELECT * FROM HD_users WHERE hd_mail = '{$loginec}' ;");
                    if (mysqli_num_rows($resoult) > 0) {
                        mysqli_close($connection);       
                        return false;
                    } else {
                        mysqli_close($connection);
                        return True;
                    }
                } else {
                    return False;
                }
            }
        }
        else {
            return false;
        }
    }


    function what_is_login($login) {
        if (is_numeric($login)) {
            return "phone";
        } else {
            if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
                return "mail";
            } else {
                return "none";
            }
        }
    }

    function make_session($db_con , $user_id) {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $seid = strval($user_id);
        if (isset($_COOKIE["SID"])) {
            $resolut = mysqli_query($db_con, "SELECT * FROM HD_session WHERE ids = '{$user_id}' AND adress_IP = '{$ip}';");
            if (mysqli_num_rows($resolut) > 0) {
                setcookie("SID", $seid , time() + (7 * 24 * 60 * 60), "/" );   
            } else {
                setcookie("SID", $seid , time() + (7 * 24 * 60 * 60), "/" ); 
            }
        } else {
            $resolut = mysqli_query($db_con, "INSERT INTO HD_session (ids, adress_IP, ueser_ID, device) VALUES ('{$seid}', '{$ip}', '{$user_id}', '{$_SERVER["HTTP_USER_AGENT"]}' ) ;");
            setcookie("SID", hash("sha256", $seid) , time() + (7 * 24 * 60 * 60), "/" );
        }   
    }

    function register_into($name, $surr, $logn, $passwor, $birthday, $gender) {
        global $adres_database, $login_database, $password_database, $use_database;
        $connection = mysqli_connect($adres_database, $login_database, $password_database, $use_database);
        mysqli_set_charset($connection, "utf8");
        $type_login = "";
        if (is_numeric($logn)) {
            $type_login = "hd_phone";
        } else {
            $type_login = "hd_mail";
        }
        $resoult = mysqli_query($connection, "INSERT INTO HD_users (hd_name, hd_surr, {$type_login}, hd_pass, hd_birth, hd_gender) VALUES ('{$name}', '{$surr}', '{$logn}', '{$passwor}', '{$birthday}', '{$gender}'  ) ;");
        $resoult = mysqli_query($connection, "SELECT * FROM HD_users WHERE {$type_login} = '$logn' ;");
        make_session($connection, mysqli_fetch_assoc($resoult)["ids"] );
        mysqli_close($connection);
    }

    function login_into($login_name, $password) {
        global $adres_database, $login_database, $password_database, $use_database;
        $connection = mysqli_connect($adres_database, $login_database, $password_database, $use_database); 
        mysqli_set_charset($connection, "utf8");
        $type_login = what_is_login($login_name);
        if ($type_login == "mail") {
            $resoult = mysqli_query($connection, "SELECT * FROM HD_users WHERE hd_pass = '{$password}' AND hd_mail = '{$login_name}' ;");
            if (mysqli_num_rows($resoult) == 1 ) {
                setcookie("LN", hash('sha256', $login_name ), time() + (7 * 24 * 60 * 60), "/" );
                setcookie("PW", hash('sha256', $password), time() + (7 * 24 * 60 * 60), "/" );
                $udis = mysqli_fetch_assoc($resoult);
                setcookie("UID", $udis["ids"], time() + (7 * 24 * 60 * 60), "/");
                make_session($connection, $udis['ids']);
                header("Location: /headbook");
                echo "OK";
            } else {
                http_response_code(400);
                echo mysqli_connect_error();
            }
        } elseif ($type_login == "phone") {
            $resoult = mysqli_query($connection, "SELECT * FROM HD_users WHERE hd_pass = '{$password}' AND hd_phone = '{$login_name}' ;");
            if (mysqli_num_rows($resoult) == 1 ) {
                setcookie("LN", hash('sha256', $login_name ), time() + (7 * 24 * 60 * 60), "/" );
                setcookie("PW", hash('sha256', $password), time() + (7 * 24 * 60 * 60), "/" );
                $udis = mysqli_fetch_assoc($resoult);
                setcookie("UID", $udis["ids"], time() + (7 * 24 * 60 * 60), "/");
                make_session($connection, $udis['ids']);
                header("Location: /headbook");
                echo "OK";
            } else {
                http_response_code(400);
                echo "mail or password is wrong";
            }
        } else {
            http_response_code(400);
            echo "Login or password is wrong";
        }
        mysqli_close($connection);
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["Method"])) {
            if ($_POST["Method"] == "login") {
                if (isset($_POST["Login"]) && isset($_POST["Password"])) {
                    $login = $_POST["Login"];
                    $passw = $_POST["Password"];
                    if (strlen($login) > 1 && strlen($passw) >= 8) {
                        login_into($login, $passw);
                    } else {
                        http_response_code(400);
                        echo "Password or login is too short";
                    }
                } else {
                    http_response_code(404);
                    echo "Need Login and Password";
                }
            } elseif ($_POST["Method"] == "register") {
                if (isset($_POST["Name"]) &&  isset($_POST["Surrname"]) ) { 
                    $name = $_POST["Name"];
                    $surr = $_POST["Surrname"];
                    if (strlen($name) > 1 && strlen($surr) > 1 ) {
                        if (isset($_POST["Login"]) && isset($_POST["Password"]) ) {
                            $login = $_POST["Login"];
                            $pass = $_POST["Password"];
                            if (check_login($login)) {
                                if (strlen($pass) >= 8 ) {
                                    if (isset($_POST["Birthday"]) && isset($_POST["Gender"]) ) {
                                        register_into($name, $surr, $login, $pass, $_POST["Birthday"], $_POST["Gender"]);
                                        Header("Location: /headbook");
                                        http_response_code(200);
                                        echo "OK";
                                    } else {
                                        http_response_code(404);
                                        echo "Birthday and gender need";
                                    }
                                } else {
                                    http_response_code(404);
                                    echo "Password is too short";
                                }
                            } else {
                                http_response_code(404);
                                echo "Email or Mobile Phone is wrong or already usesd";
                            }
                        } else { 
                            http_response_code(404);
                            echo "Login and Password is need";
                        }
                    } else {
                        http_response_code(404);
                        echo "Name or Surrname is too short";
                    }
                } else { 
                    http_response_code(404);
                    echo "Need Name and Surrname";
                }
            } else {
                http_response_code(404);
                echo "Unknow Method";
            }
        }
        else {
            http_response_code(404);
            echo "Unknow method";
        }        
    }
?>

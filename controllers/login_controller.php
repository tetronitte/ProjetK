<?php

require_once(USER_MANAGER);

session_start();

//Tableau d'erreurs
$errors = array();

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nickname = checkNickname();
    if ($nickname != null) {
        $password = checkPassword($nickname);
    }  

    if(empty($errors)) {
        $userManager = new User_Manager();
        $req = $userManager->findUser($nickname);
        $nbr = $req->rowCount();
        if ($nbr > 0) {
            $result = array();
            while($res = $req->fetch()) {
                $result[] = $res;
            }
            if(password_verify($password,$result[0][1])) {
                logging($nickname,$result);
                header('Location: http://localhost/ProjetK/?action=login');
                exit();
            }
            else {
                throw new Exception('E_LOGIN_FALSE');
                //$errors[] = 'E_LOGIN_FALSE';
            }
        }
        else {
            throw new Exception('E_LOGIN_FALSE');
            //$errors[] = 'E_LOGIN_FALSE';
        }
    }
}

/**
 * @param mixed $nickname
 * @param mixed $result
 * 
 * @return [type]
 */
function logging($nickname,$result) {
    $_SESSION['nickname'] = $nickname;
    $_SESSION['id'] = $result[0][0];
    if($_POST['autolog'] == 'on') {
        $userManager = new UserManager();
        $tokenSize = $GLOBALS['parameters']->getTokenSize();
        $tokenTime = $GLOBALS['parameters']->getTokenTime();
        $token = bin2hex(random_bytes($tokenSize));
        setcookie('autolog',$token,time()+$tokenTime,'/');
        $userManager->updateToken($token,$result[0][0]);
    }
}

/**
 * @return [type]
 */
function checkNickname() {
    if(isset($_POST['nickname']) && !empty($_POST['nickname'])) {
        $nickname = validData($_POST['nickname']);
        if(!regexNickname($nickname)) $errors[] = 'E_NICKNAME_FALSE_CHARACTER';
        return $nickname;
    }
    else {
        return null;
    }
}

/**
 * @param mixed $nickname
 * 
 * @return [type]
 */
function checkPassword($nickname) {
    if(isset($_POST['password']) && !empty($_POST['password'])) {
        $password = validData($_POST['password']);
        if(strlen($password) > 18 || strlen($password) < 8) $errors[] = 'E_PWD_LENGTH';//Si 8 <= pwd <= 18
        if(!regexPassword($password)) $errors[] = 'E_PWD_FALSE_CHARACTER';//Si au moins 1 chiffre, 1 caractère spécial, 1 lettre minuscule et 1 lettre majuscule
        return $password;
    }
    else return null;
}

/**
 * @param mixed $string
 * 
 * @return [type]
 */
function regexNickname($string) {
    $regex = $GLOBALS['parameters']->getRegexNickname();
    return preg_match('/'.$regex.'/',$string);
}

/**
 * @param mixed $string
 * 
 * @return [type]
 */
function regexPassword($string) {
    $regex = $GLOBALS['parameters']->getregexPassword();
    return preg_match('/'.$regex.'/',$string);
}

/**
 * @param mixed $data
 * 
 * @return [type]
 */
function validData($data) {
    $data = trim($data); //Supprime les espaces en début et fin de chaine
    $data = stripcslashes($data);//Supprime les antislash d'une chaine
    $data = htmlspecialchars($data);//Convertit les caractères spéciaux
    return $data;
}

require_once(LOGIN_SIGNUP);
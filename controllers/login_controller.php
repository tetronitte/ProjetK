<?php

require_once(DB_PARAMETERS);
require_once(LOGIN_MODEL);

session_start();

//Tableau d'erreurs
$errors = array();

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nickname = checkNickname();
    if ($nickname != null) {
        $password = checkPassword($nickname);
    }  

    if(empty($errors)) {
        $req = findUser($nickname);
        $nbr = $req->rowCount();
        if ($nbr > 0) {
            $result = array();
            while($res = $req->fetch()) {
                $result[] = $res;
            }
            if(password_verify($password,$result[0][1])) {
                $_SESSION['nickname'] = $nickname;
                $_SESSION['id'] = $result[0][0];
                if($_POST['autolog'] == 'on') {
                    $token = bin2hex(random_bytes(TOKEN_SIZE));
                    setcookie('autolog',$token,time()+3600);
                    updateToken($token,$result[0][0]);
                }
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

//Vérification du pseudo
//@return nickname : le pseudo de l'utilisateur 
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

//Vérification du mot de passe
//@return password : le mot de passe de l'utilisateur 
function checkPassword($nickname) {
    if(isset($_POST['password']) && !empty($_POST['password'])) {
        $password = validData($_POST['password']);
        if(strlen($password) > 18 || strlen($password) < 8) $errors[] = 'E_PWD_LENGTH';//Si 8 <= pwd <= 18
        if(!regexPassword($password)) $errors[] = 'E_PWD_FALSE_CHARACTER';//Si au moins 1 chiffre, 1 caractère spécial, 1 lettre minuscule et 1 lettre majuscule
        return $password;
    }
    else return null;
}

//Vérifie les caractère du pseudo
//@param string : la chaine de caractère à vérifier
function regexNickname($string) {
    return preg_match('/'.REGEX_NICKNAME.'/',$string);
}

//Vérifie les caractère du mot de passe
//@param string : la chaine de caractère à vérifier
function regexPassword($string) {
    return preg_match('/'.REGEX_PASSWORD.'/',$string);
}

//Transforme la chaine de caractère envoyée par le formulaire pour la sécurisée
//@param data : la chaine de caractère à vérifier
//@return data : la chaine transformée
function validData($data) {
    $data = trim($data); //Supprime les espaces en début et fin de chaine
    $data = stripcslashes($data);//Supprime les antislash d'une chaine
    $data = htmlspecialchars($data);//Convertit les caractères spéciaux
    return $data;
}

require_once(LOGIN_SIGNUP);
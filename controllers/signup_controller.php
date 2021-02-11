<?php

require_once(USER_MANAGER);

//Tableau d'erreurs
$errors = array();

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $tmp = checkNickname();
    $nickname = $tmp[0];
    $errors = array_merge($errors,$tmp[1]);
    if ($nickname != null) {
        $tmp = checkPassword($nickname);
        $password = $tmp[0];
        $errors = array_merge($errors,$tmp[1]);
    }
    else {
        echo 'Aucun pseudo renseigné !';
    }
    
    if(empty($errors)) {
        $password = password_hash($password,PASSWORD_DEFAULT);//On hash le mot de passe
        $userManager = new User_Manager();
        $res = $userManager->insertUser($nickname,$password);//On insert l'utilisateur dans la db
    }
}

//Vérification du pseudo
//@return array : le pseudo de l'utilisateur et le tableau d'erreurs
function checkNickname() {
    $err = array();
    $userManager = new UserManager();
    if(isset($_POST['nickname']) && !empty($_POST['nickname'])) {
        $nickname = validData($_POST['nickname']);
        if(!regexNickname($nickname)) $err[] = 'E_NICKNAME_FALSE_CHARACTER';
        if($userManager->existNickname($nickname)) $err[] = 'E_NICKNAME_EXIST';
        return array($nickname,$err);
    }
    else {
        return array(null,$err);
    }
}

//Vérification du mot de passe
//@return array : le mot de passe de l'utilisateur et le tableau d'erreurs
function checkPassword($nickname) {
    $err = array();
    if(isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['vPassword']) && !empty($_POST['vPassword'])) {
        $pwdMinLength = $GLOBALS['parameters']->getPasswordMinLength();
        $pwdMaxLength = $GLOBALS['parameters']->getPasswordMaxLength();
        $password = validData($_POST['password']);
        $vPassword = validData($_POST['vPassword']);
        if($password == $nickname) $err[] = 'E_PWD_EQUAL_NICKNAME';
        if(strlen($password) > $pwdMaxLength || strlen($password) < $pwdMinLength) $err[] = 'E_PWD_LENGTH';
        if(!regexPassword($password)) $err[] = 'E_PWD_FALSE_CHARACTER';
        if($password != $vPassword) $err[] = 'E_VPWD_FALSE';
        return array($password,$err);
    }
    else return array(null,$err);
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
    $regex = $GLOBALS['parameters']->getRegexPassword();
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
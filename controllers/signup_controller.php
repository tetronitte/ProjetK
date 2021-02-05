<?php

require_once(DB_PARAMETERS);
require_once(SIGNUP_MODEL);

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
        $res = insertUser($nickname,$password);//On insert l'utilisateur dans la db
    }
}

//Vérification du pseudo
//@return array : le pseudo de l'utilisateur et le tableau d'erreurs
function checkNickname() {
    $err = array();
    if(isset($_POST['nickname']) && !empty($_POST['nickname'])) {
        $nickname = validData($_POST['nickname']);
        if(!regexNickname($nickname)) $err[] = 'E_NICKNAME_FALSE_CHARACTER';
        if(existNickname($nickname)) $err[] = 'E_NICKNAME_EXIST';
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
        $password = validData($_POST['password']);
        $vPassword = validData($_POST['vPassword']);
        if($password == $nickname) $err[] = 'E_PWD_EQUAL_NICKNAME';
        if(strlen($password) > 18 || strlen($password) < 8) $err[] = 'E_PWD_LENGTH';
        if(!regexPassword($password)) $err[] = 'E_PWD_FALSE_CHARACTER';
        if($password != $vPassword) $err[] = 'E_VPWD_FALSE';
        return array($password,$err);
    }
    else return array(null,$err);
}

//Vérifie les caractère du pseudo
//@param string : la chaine de caractère à vérifier
function regexNickname($string) {
    return preg_match('/^([0-9a-zA-ZàáâäæçéèêëîïôœùûüÿÀÂÄÆÇÉÈÊËÎÏÖÔŒÙÛÜŸ \-\']+)$/',$string);
}

//Vérifie les caractère du mot de passe
//@param string : la chaine de caractère à vérifier
function regexPassword($string) {
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_])[A-Za-z\d@$!%*?&_]{8,18}$/',$string);
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
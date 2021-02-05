<?php

include('../utiles/db_parameters.php');
include('../utiles/const_path.php');
include('../utiles/db_connection.php');

//Requête préparée
//enn -> exist nickname
//iu -> insert user
$enn = $dbh->prepare('SELECT utilisateurs_id FROM utilisateurs WHERE utilisateurs_pseudo LIKE :nickname');
$iu = $dbh->prepare('INSERT INTO utilisateurs (utilisateurs_id, utilisateurs_pseudo, utilisateurs_pwd, utilisateurs_token) VALUES (NULL,:nickname, :pwd, NULL);');


//Tableau d'erreurs
$errors = array();


if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $tmp = array_checkNickname($enn);
    $nickname = $tmp[0];
    $errors = array_merge($errors,$tmp[1]);
    if ($nickname != null) {
        $tmp = array_checkPassword($nickname);
        $password = $tmp[0];
        $errors = array_merge($errors,$tmp[1]);
    }    
    
    //Si il n'y a pas d'erreurs
    if(empty($errors)) {
        $password = password_hash($password,PASSWORD_DEFAULT);//On hash le mot de passe
        insertUser($iu,$nickname,$password);//On insert l'utilisateur dans la db
    }
    else {//Sinon on renvoie le tableau d'erreur
        session_start();
        $_SESSION['errors'] = $errors;
    }
    //Redirection sur l'index
    header('Location: '.LOGIN_SIGNIN);
    exit();
}

//Fermeture de la db
$dbh = null;

//Vérification du pseudo
//@return array : le pseudo de l'utilisateur et le tableau d'erreurs
function array_checkNickname($enn) {
    $err = array();
    if(isset($_POST['nickname']) && !empty($_POST['nickname'])) {
        $nickname = str_validData($_POST['nickname']);
        if(!bool_regexNickname($nickname)) $err[] = 'E_NICKNAME_FALSE_CHARACTER';
        if(bool_existNickname($enn,$nickname)) $err[] = 'E_NICKNAME_EXIST';
        return array($nickname,$err);
    }
    else {
        return array(null,$err);
    }
}

//Vérification du mot de passe
//@return array : le mot de passe de l'utilisateur et le tableau d'erreurs
function array_checkPassword($nickname) {
    $err = array();
    if(isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['vPassword']) && !empty($_POST['vPassword'])) {
        $password = str_validData($_POST['password']);
        $vPassword = str_validData($_POST['vPassword']);
        if($password == $nickname) $err[] = 'E_PWD_EQUAL_NICKNAME';//Si le pseudo == pwd
        if(strlen($password) > 18 || strlen($password) < 8) $err[] = 'E_PWD_LENGTH';//Si 8 <= pwd <= 18
        if(!bool_regexPassword($password)) $err[] = 'E_PWD_FALSE_CHARACTER';//Si au moins 1 chiffre, 1 caractère spécial, 1 lettre minuscule et 1 lettre majuscule
        if($password != $vPassword) $err[] = 'E_VPWD_FALSE';//Si la vérification de mot de passe est bonne
        return array($password,$err);
    }
    else return array(null,$err);
}

//Insert les paramètres dans la table utilisateurs de la db
//@param req : la requête à exécuter
//@param nickname : le pseudo de l'utilisateur
//@param pwd : le mot de passe de l'utilisateur
function insertUser($req,$nickname,$pwd) {
    $req->bindParam(':nickname',$nickname);
    $req->bindParam(':pwd',$pwd);
    $tmp = $req->execute();
}

//Vérifie si l'utilisateur éxiste déjà
//@param req : la requête à exécuter
//@param nickname : le pseudo de l'utilisateur
function bool_existNickname($req,$nickname) {
    $req->bindParam(':nickname',$nickname);
    $req->execute();
    $nbr = $req->fetchAll();//Retourne le nombre de ligne de la requete
    if(count($nbr) == 0) return false;
    else return true;
}

//Vérifie les caractère du pseudo
//@param string : la chaine de caractère à vérifier
function bool_regexNickname($string) {
    return preg_match('/^([0-9a-zA-ZàáâäæçéèêëîïôœùûüÿÀÂÄÆÇÉÈÊËÎÏÖÔŒÙÛÜŸ \-\']+)$/',$string);
}

//Vérifie les caractère du mot de passe
//@param string : la chaine de caractère à vérifier
function bool_regexPassword($string) {
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_])[A-Za-z\d@$!%*?&_]{8,18}$/',$string);
}

//Transforme la chaine de caractère envoyée par le formulaire pour la sécurisée
//@param data : la chaine de caractère à vérifier
//@return data : la chaine transformée
function str_validData($data) {
    $data = trim($data); //Supprime les espaces en début et fin de chaine
    $data = stripcslashes($data);//Supprime les antislash d'une chaine
    $data = htmlspecialchars($data);//Convertit les caractères spéciaux
    return $data;
}
?>
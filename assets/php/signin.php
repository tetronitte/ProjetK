<?php

include('db_parameters.php');

//Connexion à la db
$dbh = new PDO('mysql:host=localhost;dbname=projetk','phpmyadmin', 'root');

//Requête préparée
//enn -> exist nickname
//iu -> insert user
$enn = $dbh->prepare('SELECT utilisateurs_id FROM utilisateurs WHERE utilisateurs_pseudo LIKE :nickname');
$iu = $dbh->prepare('INSERT INTO utilisateurs (utilisateurs_id, utilisateurs_pseudo, utilisateurs_pwd) VALUES (NULL,:nickname, :pwd);');


//Tableau d'erreurs
$errors = array();


if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nickname = checkNickname();
    if ($nickname != null) {
        $password = checkPassword($nickname);
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
    header('Location: http://php.projetk/');
    exit();
}

//Fermeture de la db
$dbh = null;

//Vérification du pseudo
//@return nickname : le pseudo de l'utilisateur 
function checkNickname() {
    if(isset($_POST['nickname']) && !empty($_POST['nickname'])) {
        $nickname = validData($_POST['nickname']);
        if(!regexNickname($nickname)) array_push($errors,'E_NICKNAME_FALSE_CHARACTER');
        if(existNickname($enn,$nickname)) array_push($errors,'E_NICKNAME_EXIST');
        return $nickname;
    }
    else {
        return null;
    }
}

//Vérification du mot de passe
//@return password : le mot de passe de l'utilisateur 
function checkPassword($nickname) {
    if(isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['vPassword']) && !empty($_POST['vPassword'])) {
        $password = validData($_POST['password']);
        $vPassword = validData($_POST['vPassword']);
        if($password == $nickname) array_push($errors,'E_PWD_EQUAL_NICKNAME');//Si le pseudo == pwd
        if(strlen($password) > 18 || strlen($password) < 8)  array_push($errors,'E_PWD_LENGTH');//Si 8 <= pwd <= 18
        if(!regexPassword($password)) array_push($errors,'E_PWD_FALSE_CHARACTER');//Si au moins 1 chiffre, 1 caractère spécial, 1 lettre minuscule et 1 lettre majuscule
        if($password != $vPassword) array_push($errors,'E_VPWD_FALSE');//Si la vérification de mot de passe est bonne
        return $password;
    }
    else return null;
}

//Insert les paramètres dans la table utilisateurs de la db
//@param req : la requête à exécuter
//@param nickname : le pseudo de l'utilisateur
//@param pwd : le mot de passe de l'utilisateur
function insertUser($req,$nickname,$pwd) {
    $req->bindParam(':nickname',$nickname);
    $req->bindParam(':pwd',$pwd);
    $req->execute();
}

//Vérifie si l'utilisateur éxiste déjà
//@param req : la requête à exécuter
//@param nickname : le pseudo de l'utilisateur
function existNickname($req,$nickname) {
    $req->bindParam(':nickname',$nickname);
    $req->execute();
    $nbr = $req->fetchAll();//Retourne le nombre de ligne de la requete
    if(count($nbr) == 0) return false;
    else return true;
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
?>
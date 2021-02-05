<?php

include_once('../utiles/db_connection.php');
include_once('../utiles/db_parameters.php');
include_once('../utiles/const_path.php');

$db = dbConnect();

//Requête préparée
//fu -> find user
//ut -> update token
$fu = $db->prepare('SELECT utilisateurs_id, utilisateurs_pwd FROM utilisateurs WHERE utilisateurs_pseudo = :nickname');
$ut = $db->prepare('UPDATE utilisateurs SET utilisateurs_token = :token WHERE utilisateurs_id = :id;');

//Tableau d'erreurs
$errors = array();

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nickname = str_checkNickname();
    if ($nickname != null) {
        $password = str_checkPassword($nickname);
    }    
    
    //Si il n'y a pas d'erreurs
    session_start();
    if(empty($errors)) {
        $res = array_findUser($fu,$nickname);
        $tmp = $res;
        $nbr = $tmp->fetchAll();
        if ($nbr > 0) {//Si on a pas trouvé d'utilisateur
            if(password_verify($password,$res[0][1])) {//On vérifie le hachage du mot de passe en db et dans le formulaire
                $_SESSION['nickname'] = $nickname;
                $_SESSION['id'] = $res[0][0];
                if($_POST['autolog'][0] == 'on') {//Si on veut se log automatiquement on créer un token
                    $token = str_generateToken(TOKEN_SIZE);
                    setcookie('autolog',$token,time()+3600);
                    updateToken($ut,$token,$res[0][0]);
                }
            }
            else {
                $errors[] = 'E_LOGIN_FALSE';
            }
        }
        else {
            $errors[] = 'E_LOGIN_FALSE';
        }
    }
    //Si il y a une erreur qui est survenu entre temps
    if(!empty($errors)) {
        $_SESSION['errors'] = $errors;
    }
    //Redirection sur l'index
    header('Location: '.LOGIN_SIGNIN);
    exit();
}

//Fermeture de la db
$db = null;

//Vérification du pseudo
//@return nickname : le pseudo de l'utilisateur 
function str_checkNickname() {
    if(isset($_POST['nickname']) && !empty($_POST['nickname'])) {
        $nickname = str_validData($_POST['nickname']);
        if(!str_regexNickname($nickname)) $errors[] = 'E_NICKNAME_FALSE_CHARACTER';
        return $nickname;
    }
    else {
        return null;
    }
}

//Vérification du mot de passe
//@return password : le mot de passe de l'utilisateur 
function str_checkPassword($nickname) {
    if(isset($_POST['password']) && !empty($_POST['password'])) {
        $password = str_validData($_POST['password']);
        if(strlen($password) > 18 || strlen($password) < 8) $errors[] = 'E_PWD_LENGTH';//Si 8 <= pwd <= 18
        if(!str_regexPassword($password)) $errors[] = 'E_PWD_FALSE_CHARACTER';//Si au moins 1 chiffre, 1 caractère spécial, 1 lettre minuscule et 1 lettre majuscule
        return $password;
    }
    else return null;
}

//Cherche l'utilisateur dans la db
//@param req : la requête à exécuter
//@param nickname : la pseudo de l'utilisateur
//@return arr : tableau comprenant l'id et le mot de passe de l'utilisateur
function array_findUser($req,$nickname) {
    $arr = array();
    $req->bindParam(':nickname',$nickname);
    $req->execute();
    while($res = $req->fetch()) {
        array_push($arr,$res);
    }
    return $arr;
}

//Vérifie les caractère du pseudo
//@param string : la chaine de caractère à vérifier
function str_regexNickname($string) {
    return preg_match('/'.REGEX_NICKNAME.'/',$string);
}

//Vérifie les caractère du mot de passe
//@param string : la chaine de caractère à vérifier
function str_regexPassword($string) {
    return preg_match('/'.REGEX_PASSWORD.'/',$string);
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

//Créer un token de connexion automatique
//@param length : taille du token
//@return token : le token de connexion
function str_generateToken($length) {
    $token = "";
    $string = "123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@&#?!$%";
    shuffle($string);
    srand((double)microtime()*1000000);
    for($i = 0; $i < $length ; $i++){
        $token .= $string[rand()%strlen($string)];
    }
    return $token;
}

//Ajoute le token pour l'utilisateur en db
//@param req : la requête à exécuter
//@param token : le token à ajouter
//@param id : l'id de l'utilisateur
function updateToken($req,$token,$id) {
    $req->bindParam(':token',$token);
    $req->bindParam(':id',$id);
    $req->execute();
}
<?php
//Connexion à la db
$dbh = new PDO('mysql:host=localhost;dbname=projetk','phpmyadmin', 'root');

//Requête préparée
$enn = $dbh->prepare('SELECT utilisateurs_id FROM utilisateurs WHERE utilisateurs_pseudo LIKE :nickname');
$insertUser = $dbh->prepare('INSERT INTO utilisateurs (utilisateurs_id, utilisateurs_pseudo, utilisateurs_pwd) VALUES (NULL,:nickname, :pwd);');



$errors = array();


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Pseudo
    if(isset($_POST['nickname']) && !empty($_POST['nickname'])) {
        $nickname = validData($_POST['nickname']);
        if(!regexNickname($nickname)) array_push($errors,1);
        if(existNickname($enn,$nickname)) array_push($errors,2);
    }
    if(isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['vPassword']) && !empty($_POST['vPassword'])) {
        $password = validData($_POST['password']);
        $vPassword = validData($_POST['vPassword']);
        if($password == $nickname) array_push($errors,3);//Si le pseudo == pwd
        if(strlen($password) > 18 || strlen($password) < 8)  array_push($errors,4);//Si 8 <= pwd <= 18
        if(!regexPassword($password)) array_push($errors,5);//Si au moins 1 chiffre, 1 caractère spécial, 1 lettre minuscule et 1 lettre majuscule
        if($password != $vPassword) array_push($errors,6);
    }
    if(empty($errors)) {
        $password = password_hash($password,PASSWORD_DEFAULT);
        insertUser($insertUser,$nickname,$password);
        header('Location: http://php.projetk/');
        exit();
    }
    else {
        var_dump($errors);
    }
}


$dbh = null;



function insertUser($req,$nickname,$pwd) {
    $req->bindParam(':nickname',$nickname);
    $req->bindParam(':pwd',$pwd);
    $req->execute();
}

function existNickname($req,$nickname) {
    $req->bindParam(':nickname',$nickname);
    $req->execute();
    $nbr = $req->fetchAll();
    if(count($nbr) == 0) return false;
    else return true;
}

function regexNickname($string) {
    return preg_match('/^([0-9a-zA-ZàáâäæçéèêëîïôœùûüÿÀÂÄÆÇÉÈÊËÎÏÖÔŒÙÛÜŸ \-\']+)$/',$string);
}
function regexPassword($string) {
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_])[A-Za-z\d@$!%*?&_]{8,18}$/',$string);
}

function validData($data) {
    $data = trim($data); //Supprime les espaces en début et fin de chaine
    $data = stripcslashes($data);//Supprime les antislash d'une chaine
    $data = htmlspecialchars($data);//Convertit les caractères spéciaux
    return $data;
}




?>
<?php
//Connexion à la db
$dbh = new PDO('mysql:host=localhost;dbname=projetk','phpmyadmin', 'root');

//Requête préparée
$fu = $dbh->prepare('SELECT utilisateurs_id, utilisateurs_pwd FROM utilisateurs WHERE utilisateurs_pseudo = :nickname');


$errors = array();


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Pseudo
    if(isset($_POST['nickname']) && !empty($_POST['nickname'])) {
        $nickname = validData($_POST['nickname']);
        if(!regexNickname($nickname)) array_push($errors,1);
    }
    if(isset($_POST['password']) && !empty($_POST['password'])) {
        $password = validData($_POST['password']);
        if(strlen($password) > 18 || strlen($password) < 8)  array_push($errors,2);//Si 8 <= pwd <= 18
        if(!regexPassword($password)) array_push($errors,2);//Si au moins 1 chiffre, 1 caractère spécial, 1 lettre minuscule et 1 lettre majuscule
    }
    if(empty($errors)) {
        $res = findUser($fu,$nickname);
        if(password_verify($password,$res[0][1])) {
            session_start();
            $_SESSION['nickname'] = $nickname;
            $_SESSION['id'] = $password;
            if($_POST['autolog'][0] == 'on') {
                setcookie('nickname',$nickname,time()+3600);
                setcookie('pwd',$password,time()+3600);
            }
            header('Location: http://php.projetk/');
            exit();
        }
        else echo 'ERREUR';
    }
    else {
        var_dump($errors);
    }
}


$dbh = null;
function findUser($req,$nickname) {
    $arr = array();
    $req->bindParam(':nickname',$nickname);
    $req->execute();
    while($res = $req->fetch()) {
        array_push($arr,$res);
    }
    return $arr;
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
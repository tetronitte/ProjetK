<?php

include_once('../utiles/db_connection.php');
include_once('../utiles/const_path.php');

$db = dbConnect();

//Requête préparée
//dt -> update token
$dt = $db->prepare('UPDATE utilisateurs SET utilisateurs_token = null WHERE utilisateurs_id = :id;');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();

    // Suppression des cookies de connexion automatique
    if($_POST['noAutolog'][0] == 'on') {    
        setcookie('autolog','');
        deleteToken($dt,$_SESSION['id']);
    }

    // Suppression des variables de session et de la session
    $_SESSION = array();
    session_destroy(); 
}
//Fermeture de la db
$db = null;

header('Location: '.LOGIN_SIGNIN);
exit();


//Supprime le token de l'utilisateur en db
//@param req : la requête à exécuter
//@param id : l'id de l'utilisateur
function deleteToken($req,$id) {
    $req->bindParam(':id',$id);
    $req->execute();
}
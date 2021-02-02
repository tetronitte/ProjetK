<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();

    // Suppression des variables de session et de la session
    $_SESSION = array();
    session_destroy();

    // Suppression des cookies de connexion automatique
    if($_POST['noAutolog'][0] == 'on') {    
        setcookie('nickname','');
        setcookie('pwd','');
    }
}
header('Location: http://php.projetk/');
exit();
?>
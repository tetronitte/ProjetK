<?php

require_once(USER_MANAGER);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();

    // Suppression des cookies de connexion automatique
    $userManager = new UserManager();
    setcookie('autolog','',time(),'/');
    $userManager->deleteToken($_SESSION['id']);

    // Suppression des variables de session et de la session
    $_SESSION = array();
    session_destroy();
}

header('Location: http://localhost/ProjetK/?action=login');
exit();
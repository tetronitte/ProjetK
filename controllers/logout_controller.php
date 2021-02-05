<?php

require_once(LOGOUT_MODEL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();

    // Suppression des cookies de connexion automatique
    if($_POST['noAutolog'] == 'on') {    
        setcookie('autolog','');
        deleteToken($_SESSION['id']);
    }

    // Suppression des variables de session et de la session
    $_SESSION = array();
    session_destroy(); 
}

require_once(LOGIN_SIGNUP);
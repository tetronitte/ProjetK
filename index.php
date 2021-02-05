<?php

require_once('utiles/const_path.php');
require_once(DB_CONNECTION);
require_once(realpath(LIST_CONTROLLER));

try {
  if (isset($_GET['action'])) {
    switch ($_GET['action']) {
      case 'signup':
        signupController();
        break;
      case 'login':
        loginController();
        break;
      case 'logout':
        logoutController();
        break;
    }
  }
  else {
    header('Location: http://localhost/ProjetK/index.php?action=signup');
  }
}
catch(Exception $e) {
  echo 'Erreur : '.$e->getMessage();
}
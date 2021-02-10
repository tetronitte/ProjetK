<?php

require_once('utils/const_path.php');
require_once(LIST_CONTROLLER);
require_once(PARAMETERS);

global $parameters;
$parameters = new Parameters();
$parameters->getParameters();

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
<?php
    //CONTROLLERS
    define('LOGIN_CONTROLLER',$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/ProjetK/controllers/login.php');
    define('SIGNIN_CONTROLLER',$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/ProjetK/controllers/signin.php');
    define('LOGOUT_CONTROLLER',$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/ProjetK/controllers/logout.php');

    //VIEWS
    define('LOGIN_SIGNIN',$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/ProjetK/views/login_signin.php');
?>
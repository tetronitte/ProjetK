<?php
    //INI
    define('DB_INI',realpath('config/db.ini'));

    //CONTROLLERS
    define('LIST_CONTROLLER',realpath('controllers/list_controller.php'));
    define('LOGIN_CONTROLLER',realpath('controllers/login_controller.php'));
    define('SIGNUP_CONTROLLER',realpath('controllers/signup_controller.php'));
    define('LOGOUT_CONTROLLER',realpath('controllers/logout_controller.php'));

    //MODELS
    define('USER_MANAGER',realpath('models/UserManager.php'));
    define('MANAGER',realpath('models/Manager.php'));
    define('PARAMETERS',realpath('models/Parameters.php'));

    //VIEWS
    define('LOGIN_SIGNUP',realpath('views/login_signup.php'));

    //INDEX
    define('INDEX',realpath('index.php'));

    //UTILES
    

    // var_dump(DB_INI);
    // var_dump(LIST_CONTROLLER);
    // var_dump(LOGIN_CONTROLLER);
    // var_dump(SIGNUP_CONTROLLER);
    // var_dump(LOGOUT_CONTROLLER);
    // var_dump(USER_MANAGER);
    // var_dump(MANAGER);
    // var_dump(PARAMETERS);
    // var_dump(LOGIN_SIGNUP);
    // var_dump(INDEX);
    // exit();
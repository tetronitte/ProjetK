<?php
    //INI
    define('DB_INI',realpath('config/db.ini'));

    //CONTROLLERS
    define('LIST_CONTROLLER',realpath('controllers/list_controller.php'));
    define('LOGIN_CONTROLLER',realpath('controllers/login_controller.php'));
    define('SIGNUP_CONTROLLER',realpath('controllers/signup_controller.php'));
    define('LOGOUT_CONTROLLER',realpath('controllers/logout_controller.php'));

    //MODELS
    define('SIGNUP_MODEL',realpath('models/signup_model.php'));
    define('LOGIN_MODEL',realpath('models/login_model.php'));
    define('LOGOUT_MODEL',realpath('models/logout_model.php'));

    //VIEWS
    define('LOGIN_SIGNUP',realpath('views/login_signup.php'));

    //INDEX
    define('INDEX',realpath('index.php'));

    //UTILES
    define('DB_PARAMETERS',realpath('utiles/db_parameters.php'));
    define('DB_CONNECTION',realpath('utiles/db_connection.php'));

    // var_dump(DB_INI);
    // var_dump(LIST_CONTROLLER);
    // var_dump(LOGIN_CONTROLLER);
    // var_dump(SIGNUP_CONTROLLER);
    // var_dump(LOGOUT_CONTROLLER);
    // var_dump(SIGNUP_MODEL);
    // var_dump(LOGIN_SIGNUP);
    // var_dump(INDEX);
    // var_dump(DB_PARAMETERS);
    // var_dump(DB_CONNECTION);
    // exit();
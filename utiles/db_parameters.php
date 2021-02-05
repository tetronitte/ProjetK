<?php

$db = dbConnect();

$parameters = array();
$sp = $db->prepare('SELECT parametres_nom, parametres_valeur FROM parametres');
$sp->execute();
while($res = $sp->fetch()) {
    $parameters[$res[0]] = $res[1];
}

define('TOKEN_SIZE',$parameters['tokenSize']);
define('REGEX_NICKNAME',$parameters['regexNickname']);
define('REGEX_PASSWORD',$parameters['regexPassword']);

//Fermeture de la db
$db = null;
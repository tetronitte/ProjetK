<?php

//Connexion à la db
$dbh = new PDO('mysql:host=localhost;dbname=projetk','phpmyadmin', 'root');

$parameters = array();
$sp = $dbh->prepare('SELECT parametres_nom, parametres_valeur FROM parametres');
$sp->execute();
while($res = $sp->fetch()) {
    $parameters[$res[0]] = $res[1];
}
var_dump($parameters);

define('TOKEN_SIZE',$parameters['tokenSize']);
define('REGEX_NICKNAME',$parameters['regexNickname']);
define('REGEX_PASSWORD',$parameters['regexPassword']);

//Fermeture de la db
$dbh = null;

?>
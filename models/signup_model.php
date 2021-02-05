<?php

require_once(DB_CONNECTION);

//Insert les paramètres dans la table utilisateurs de la db
//@param nickname : le pseudo de l'utilisateur
//@param pwd : le mot de passe de l'utilisateur
function insertUser($nickname,$pwd) {
    $db = dbConnect();
    $req = $db->prepare('INSERT INTO utilisateurs (utilisateurs_id, utilisateurs_pseudo, utilisateurs_pwd, utilisateurs_token) VALUES (NULL,:nickname, :pwd, NULL);');
    $req->bindParam(':nickname',$nickname);
    $req->bindParam(':pwd',$pwd);
    $req->execute();
    $req->closeCursor();
}

//Vérifie si l'utilisateur éxiste déjà
//@param nickname : le pseudo de l'utilisateur
//@return bool : si il ya ou non une valeur sélectionnée
function existNickname($nickname) {
    $db = dbConnect();
    $req = $db->prepare('SELECT utilisateurs_id FROM utilisateurs WHERE utilisateurs_pseudo = :nickname');
    $req->bindParam(':nickname',$nickname);
    $req->execute();
    $nbr = $req->rowCount();
    $req->closeCursor();
    if($nbr == 0) return false;
    else return true;
}
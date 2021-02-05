<?php

//Ajoute le token pour l'utilisateur en db
//@param token : le token à ajouter
//@param id : l'id de l'utilisateur
function updateToken($token,$id) {
    $db = dbConnect();
    $req = $db->prepare('UPDATE utilisateurs SET utilisateurs_token_autolog = :token WHERE utilisateurs_id = :id');
    $req->bindParam(':token',$token);
    $req->bindParam(':id',$id);
    $req->execute();
    $req->closeCursor();
}

//Cherche l'utilisateur dans la db
//@param nickname : la pseudo de l'utilisateur
//@return arr : tableau comprenant l'id et le mot de passe de l'utilisateur
function findUser($nickname) {
    $db = dbConnect();
    $req = $db->prepare('SELECT utilisateurs_id, utilisateurs_pwd FROM utilisateurs WHERE utilisateurs_pseudo = :nickname');
    $req->bindParam(':nickname',$nickname);
    $req->execute();
    return $req;
}
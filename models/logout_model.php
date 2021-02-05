<?php

//Supprime le token de l'utilisateur en db
//@param id : l'id de l'utilisateur
function deleteToken($id) {
    $db = dbConnect();
    $req = $db->prepare('UPDATE utilisateurs SET utilisateurs_token = null WHERE utilisateurs_id = :id;');
    $req->bindParam(':id',$id);
    $req->execute();
    $req->closeCursor();
}
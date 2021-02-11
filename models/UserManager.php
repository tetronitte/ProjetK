<?php

class UserManager extends Manager {

    //Insert les paramètres dans la table utilisateurs de la db
    //@param nickname : le pseudo de l'utilisateur
    //@param pwd : le mot de passe de l'utilisateur
    function insertUser($nickname,$pwd) {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO users (id, nockname, pwd, token_autolog) VALUES (NULL,:nickname, :pwd, NULL)');
        $req->bindParam(':nickname',$nickname);
        $req->bindParam(':pwd',$pwd);
        $req->execute();
        $req->closeCursor();
        $db = $this->dbClose();
    }

    //Vérifie si l'utilisateur éxiste déjà
    //@param nickname : le pseudo de l'utilisateur
    //@return bool : si il ya ou non une valeur sélectionnée
    function existNickname($nickname) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id FROM users WHERE nickname = :nickname');
        $req->bindParam(':nickname',$nickname);
        $req->execute();
        $nbr = $req->rowCount();
        $db = $this->dbClose();
        if($nbr == 0) return false;
        else return true;
    }

    //Supprime le token de l'utilisateur en db
    //@param id : l'id de l'utilisateur
    function deleteToken($id) {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE users SET token_autolog = null WHERE id = :id;');
        $req->bindParam(':id',$id);
        $req->execute();
        $req->closeCursor();
        $db = $this->dbClose();
    }

    //Ajoute le token pour l'utilisateur en db
    //@param token : le token à ajouter
    //@param id : l'id de l'utilisateur
    function updateToken($token,$id) {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE users SET token_autolog = :token WHERE id = :id');
        $req->bindParam(':token',$token);
        $req->bindParam(':id',$id);
        $req->execute();
        $req->closeCursor();
        $db = $this->dbClose();
    }

    //Cherche l'utilisateur dans la db
    //@param nickname : la pseudo de l'utilisateur
    //@return arr : tableau comprenant l'id et le mot de passe de l'utilisateur
    function findUser($nickname) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, pwd FROM users WHERE nickname = :nickname');
        $req->bindParam(':nickname',$nickname);
        $req->execute();
        $db = $this->dbClose();
        return $req;
    }
}
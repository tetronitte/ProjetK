<?php

/**
 * [Description UserManager]
 */
class User_Manager extends Manager {

    /**
     * @param mixed $nickname
     * @param mixed $pwd
     * 
     * @return [type]
     */
    function insertUser($nickname,$pwd) {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO users (id, nockname, pwd, token_autolog) VALUES (NULL,:nickname, :pwd, NULL)');
        $req->bindParam(':nickname',$nickname);
        $req->bindParam(':pwd',$pwd);
        $req->execute();
        $req->closeCursor();
        $db = $this->dbClose();
    }

    /**
     * @param mixed $nickname
     * 
     * @return [type]
     */
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

    /**
     * @param mixed $id
     * 
     * @return [type]
     */
    function deleteToken($id) {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE users SET token_autolog = null WHERE id = :id;');
        $req->bindParam(':id',$id);
        $req->execute();
        $req->closeCursor();
        $db = $this->dbClose();
    }

    /**
     * @param mixed $token
     * @param mixed $id
     * 
     * @return [type]
     */
    function updateToken($token,$id) {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE users SET token_autolog = :token WHERE id = :id');
        $req->bindParam(':token',$token);
        $req->bindParam(':id',$id);
        $req->execute();
        $req->closeCursor();
        $db = $this->dbClose();
    }

    /**
     * @param mixed $nickname
     * 
     * @return [type]
     */
    function findUser($nickname) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, pwd FROM users WHERE nickname = :nickname');
        $req->bindParam(':nickname',$nickname);
        $req->execute();
        $db = $this->dbClose();
        return $req;
    }
}
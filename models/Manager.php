<?php

class Manager {

    protected function dbConnect() {
        $database = parse_ini_file(DB_INI);
        $host = $database['host'];
        $dbname = $database['dbname'];
        $username = $database['username'];
        $password = $database['password'];
        try{
            $db = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8', $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
            return $db;
        }
        catch(Exception $e){
            die('Erreur : ' .$e->getMessage());
        }
    }

    public function dbClose() {
        return null;
    }

}
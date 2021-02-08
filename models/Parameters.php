<?php

require_once(MANAGER);

class Parameters extends Manager {

    private $_parameters = array();

    public function getParameters() {
        $db = $this->dbConnect();
        $sp = $db->prepare('SELECT parametres_nom, parametres_valeur FROM parametres');
        $sp->execute();
        while($res = $sp->fetch()) {
            $this->_parameters[$res[0]] = $res[1];
        }
        $db = $this->dbClose();
    }

    public function getTokenSize() {
        return $this->_parameters['tokenSize'];
    }
    public function getRegexNickname() {
        return $this->_parameters['regexNickname'];
    }
    public function getRegexPassword() {
        return $this->_parameters['regexPassword'];
    }
    public function getPasswordMinLength() {
        return $this->_parameters['passwordMinLength'];
    }
    public function getPasswordMaxLength() {
        return $this->_parameters['passwordMaxLength'];
    }
    public function getTokenTime() {
        return $this->_parameters['tokenTime'];
    }
}

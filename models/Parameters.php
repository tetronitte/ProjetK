<?php

require_once(MANAGER);

/**
 * [Description Parameters]
 */
class Parameters extends Manager {

    private $_parameters = array();

    /**
     * @return [type]
     */
    public function getParameters() {
        $db = $this->dbConnect();
        $sp = $db->prepare('SELECT parametres_nom, parametres_valeur FROM parametres');
        $sp->execute();
        while($res = $sp->fetch()) {
            $this->_parameters[$res[0]] = $res[1];
        }
        $db = $this->dbClose();
    }

    /**
     * @return [type]
     */
    public function getTokenSize() {
        return $this->_parameters['tokenSize'];
    }
    /**
     * @return [type]
     */
    public function getRegexNickname() {
        return $this->_parameters['regexNickname'];
    }
    /**
     * @return [type]
     */
    public function getRegexPassword() {
        return $this->_parameters['regexPassword'];
    }
    /**
     * @return [type]
     */
    public function getPasswordMinLength() {
        return $this->_parameters['passwordMinLength'];
    }
    /**
     * @return [type]
     */
    public function getPasswordMaxLength() {
        return $this->_parameters['passwordMaxLength'];
    }
    /**
     * @return [type]
     */
    public function getTokenTime() {
        return $this->_parameters['tokenTime'];
    }
}

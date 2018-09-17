<?php

global $docRoot;
include_once($docRoot . 'models/login.php');
include_once($docRoot . 'validations/validateLogin.php');

class LoginBO extends Login {

    /**
     * 
     * @return type
     */
    function save() {
        $data = $this->getRequestData();
        $errorObj = new ValidateLogin();
        $errors = $errorObj->validate($data);
        if (!empty($errors)) {
            return array('errors' => $errors);
        }
        return parent::saveLoginMod($data);
    }

    /**
     * 
     * @return type
     */
    function forgotPwd() {
        $data = $this->getRequestData();
        $errorObj = new ValidateLogin();
        $errors = $errorObj->validate($data);
        if (!empty($errors)) {
            return array('errors' => $errors);
        }
        return parent::forgotPwdLoginMod($data);
    }

    /**
     * 
     * @return type
     */
    function getRequestData() {
        $tableCols = parent::tableDef();
        $data = array();
        foreach ($tableCols as $key => $tableCol) {
            if (isset($_REQUEST[$tableCol])) {
                $data[$tableCol] = $_REQUEST[$tableCol];
            }
        }
        return $data;
    }

}

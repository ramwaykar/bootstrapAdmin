<?php

global $docRoot;
include_once($docRoot . 'models/install.php');
include_once($docRoot . 'validations/validateInstall.php');

class InstallBO extends Install {

    /**
     * 
     * @return type
     */
    function save() {
        $adminData = $this->getAdminData();
        $dbData = $this->getDBData();
        $errorObj = new ValidateInstall();
        $errors = $errorObj->validate($adminData, $dbData);
        if (!empty($errors)) {
            return array('errors' => $errors);
        }
        return parent::saveInstallMod($adminData, $dbData);
    }

    /**
     * 
     * @return type
     */
    function getAdminData() {
        $tableCols = parent::tableDef();
        $data = array();
        foreach ($tableCols as $key => $tableCol) {
            if (isset($_REQUEST[$tableCol])) {
                $data[$tableCol] = $_REQUEST[$tableCol];
            }
        }
        return $data;
    }

    /**
     * 
     * @return type
     */
    function getDBData() {
        $fields = array('dbHost', 'dbName', 'dbUser', 'dbPassword', 'dbType');
        $data = array();
        foreach ($fields as $key => $field) {
            if (isset($_REQUEST[$field])) {
                $data[$field] = $_REQUEST[$field];
            }
        }
        return $data;
    }

    
}
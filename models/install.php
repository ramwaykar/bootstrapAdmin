<?php

include_once '../db/dbInstallation.php';

class Install {

    /**
     * 
     * @return type
     */
    protected function tableDef() {
        return array('id', 'username', 'password', 'email', 'phone');
    }

    /**
     * 
     * @param type $adminData
     * @param type $dbData
     * @return type
     */
    protected function saveInstallMod($adminData, $dbData) {
        return $this->createDB($adminData, $dbData);
    }

    /**
     * 
     * @param type $adminData
     * @param type $dbData
     * @return type
     */
    protected function createDB($adminData, $dbData) {
        $installDB = new InstallDB();
        $res = false;
        switch ($dbData['dbType']) {
            case 'mysql':
                $res = $installDB->createMySQLDB($dbData);
                if ($res) {
                    $res = $installDB->createTables($adminData, $dbData);
                }
                break;
            default:
                $res = $installDB->createMsSQLDB($dbData);
                if ($res) {
                    $res = $installDB->createTables($adminData, $dbData);
                }
        }
        return $res;
    }

}
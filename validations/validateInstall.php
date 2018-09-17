<?php

global $docRoot;
include_once $docRoot . 'validations/validateUser.php';

class ValidateInstall {

    /**
     * 
     * @param type $adminData
     * @param type $dbData
     * @return string
     */
    function validate($adminData, $dbData) {
        $validateUser = new ValidateUser();
        $errors = $validateUser->validate($adminData);

        if (!isset($dbData['dbType']) || empty($dbData['dbType'])) {
            $errors['dbType'] = '';
        }

        if (!isset($dbData['dbHost']) || empty($dbData['dbHost'])) {
            $errors['dbHost'] = '';
        }

        if (!isset($dbData['dbName']) || empty($dbData['dbName'])) {
            $errors['dbName'] = '';
        }

        if (!isset($dbData['dbUser']) || empty($dbData['dbUser'])) {
            $errors['dbUser'] = '';
        }


        return $errors;
    }

}


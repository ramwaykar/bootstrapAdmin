<?php

class ValidateSecurityGroup {

    /**
     * 
     * @param type $userData
     * @return string
     */
    function validate($userData) {
        $errors = array();
        if (!isset($userData['name']) || empty($userData['name'])) {
            $errors['name'] = '';
        }
        return $errors;
    }

}


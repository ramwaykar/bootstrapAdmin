<?php

class ValidateModuleCreator {

    /**
     * 
     * @param type $userData
     * @return string
     */
    function validate($data) {
        $errors = array();
        if (!isset($data['name']) || empty($data['name'])) {
            $errors['name'] = '';
        }
        return $errors;
    }

}


<?php

class ValidateAccess {

    /**
     * 
     * @param type $data
     * @return string
     */
    function validate($data) {
        $errors = array();
        if ((!isset($data['module']) || empty($data['module'])) && (!isset($data['id']) || empty($data['id']))) {
            $errors['cmodule'] = '';
        }
        return $errors;
    }

}


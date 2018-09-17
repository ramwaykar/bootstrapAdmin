<?php

class ValidateLogin {

    /**
     * 
     * @param type $data
     * @return type
     */
    function validate($data) {
        $errors = array();

        if (!isset($data['username']) || empty($data['username'])) {
            $errors['username'] = '';
        }

        if (!isset($data['password']) || empty($data['password'])) {
            $errors['password'] = '';
        }

        if ($_REQUEST['action'] === 'forgotPwd') {
            if (!isset($_REQUEST['cnfpwd']) || empty($_REQUEST['cnfpwd'])) {
                $errors['cnfpwd'] = '';
            } else if ($data['password'] != $_REQUEST['cnfpwd']) {
                $errors['pwd_not_matched'] = $en['errors']['user']['wrong'];
            }
        }

        return $errors;
    }

}


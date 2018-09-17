<?php

class ValidateUser {

    /**
     * 
     * @global type $en
     * @param type $userData
     * @return string
     */
    function validate($userData) {
        global $en;
        $errors = array();

        //validate while creating record only, not in update
        if (!isset($_REQUEST['id']) || empty($_REQUEST['id'])) {
            if (!isset($userData['username']) || empty($userData['username'])) {
                $errors['username'] = '';
            }

            if (!isset($userData['password']) || empty($userData['password'])) {
                $errors['password'] = '';
            }

            if (!isset($_REQUEST['cnfpwd']) || empty($_REQUEST['cnfpwd'])) {
                $errors['cnfpwd'] = '';
            } else if ($userData['password'] != $_REQUEST['cnfpwd']) {
                $errors['pwd_not_matched'] = $en['errors']['user']['wrong'];
            }
        }


        if (!isset($userData['email']) || empty($userData['email'])) {
            $errors['email'] = '';
        }

        if (!isset($userData['phone']) || empty($userData['phone'])) {
            $errors['phone'] = '';
        }

        //validate while creating new user, not while installing admin panel
        if (isset($_REQUEST['module']) && $_REQUEST['module'] === 'user') {
            if (!isset($userData['securityGroupId']) || empty($userData['securityGroupId'])) {
                $errors['securityGroupId'] = '';
            }
            if (!isset($userData['fName']) || empty($userData['fName'])) {
                $errors['fName'] = '';
            }
            if (!isset($userData['lName']) || empty($userData['lName'])) {
                $errors['lName'] = '';
            }
        }

        return $errors;
    }

}


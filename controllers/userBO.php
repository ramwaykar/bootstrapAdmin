<?php

global $docRoot;
include_once($docRoot . 'models/user.php');
include_once($docRoot . 'views/user/modConf.php');
include_once($docRoot . 'validations/validateUser.php');

class UserBO extends User {

    /**
     * 
     * @param type $query
     * @param type $fields
     * @param type $rel
     * @return type
     */
    function get($query = array(), $fields = array(), $rel = array()) {
        if (isset($_REQUEST['action']) && ($_REQUEST['action'] === 'getListData' || $_REQUEST['action'] === 'search')) {
            $modConfObj = new UserModConf();
            $modConf = $modConfObj->getModConf();
            if (isset($modConf['listSelectFields']) && !empty($modConf['listSelectFields'])) {
                $fields = $modConf['listSelectFields'];
            }
            if (isset($_REQUEST['columns']) && isset($modConf['listDisplayFields']) && !empty($modConf['listDisplayFields'])) {
                foreach ($modConf['listDisplayFields'] as $key => $val) {
                    $_REQUEST['columns'][$key]['name'] = $val;
                }
            }
        }

        $res = parent::getUserMod($query, $fields, $rel);
        return $res;
    }

    /**
     * 
     * @return type
     */
    function save() {
        $data = $this->getRequestData();
        $errorObj = new ValidateUser();
        $errors = $errorObj->validate($data);
        if (!empty($errors)) {
            return array('errors' => $errors);
        }
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = md5($data['password']);
        }

        return parent::saveUserMod($data);
    }

    /**
     * 
     * @param type $data
     * @return type
     */
    function forgotPwd($data) {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = md5($data['password']);
        }
        return parent::saveUserMod($data);
    }

    /**
     * 
     * @global type $en
     * @return type
     */
    function changePassword() {
        global $en;
        $errors = array();
        $data = $this->getRequestData();
        if (!isset($data['password']) || empty($data['password'])) {
            $errors['password'] = '';
        }

        if (!isset($_REQUEST['cnfpwd']) || empty($_REQUEST['cnfpwd'])) {
            $errors['cnfpwd'] = '';
        } else if ($data['password'] != $_REQUEST['cnfpwd']) {
            $errors['pwd_not_matched'] = $en['errors']['user']['wrong'];
        }
        if (!empty($errors)) {
            return array('errors' => $errors);
        }
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = md5($data['password']);
        }
        return parent::saveUserMod($data);
    }

    /**
     * 
     * @return type
     */
    function updateStatus() {
        $data['status'] = ($_REQUEST['status'] == 1) ? 0 : 1;
        $data['id'] = $_REQUEST['id'];
        return parent::updateStatusUserMod($data);
    }

    /**
     * 
     * @return type
     */
    function remove() {
        $data = $this->getRequestData();
        return parent::removeUserMod($data);
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

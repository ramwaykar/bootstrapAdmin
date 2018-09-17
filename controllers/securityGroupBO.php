<?php

global $docRoot;
include_once($docRoot . 'models/securityGroup.php');
include_once($docRoot . 'views/securityGroup/modConf.php');
include_once($docRoot . 'validations/validateSecurityGroup.php');

class SecurityGroupBO extends SecurityGroup {

    /**
     * 
     * @param type $query
     * @param type $fields
     * @param type $rel
     * @return type
     */
    function get($query = array(), $fields = array(), $rel = array()) {
        if (isset($_REQUEST['action']) && ($_REQUEST['action'] === 'getListData' || $_REQUEST['action'] === 'search')) {
            $modConfObj = new SecurityGroupModConf();
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

        $res = parent::getSecurityGroupMod($query, $fields, $rel);
        return $res;
    }

    /**
     * 
     * @return type
     */
    function updateStatus() {
        $data['status'] = ($_REQUEST['status'] == 1) ? 0 : 1;
        $data['id'] = $_REQUEST['id'];
        return parent::updateStatusSecurityGroupMod($data);
    }

    /**
     * 
     * @return type
     */
    function save() {
        $data = $this->getRequestData();
        $errorObj = new ValidateSecurityGroup();
        $errors = $errorObj->validate($data);
        if (!empty($errors)) {
            return array('errors' => $errors);
        }

        return parent::saveSecurityGroupMod($data);
    }

    /**
     * 
     * @return type
     */
    function remove() {
        $data = $this->getRequestData();
        return parent::removeSecurityGroupMod($data);
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
        $data['isAdmin'] = (isset($data['isAdmin'])) ? 1 : 0;
        return $data;
    }

}
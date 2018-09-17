<?php

global $docRoot;
include_once($docRoot . 'models/access.php');
include_once($docRoot . 'views/access/modConf.php');
include_once($docRoot . 'validations/validateAccess.php');

class AccessBO extends Access {

    /**
     * 
     * @param type $query
     * @param type $fields
     * @param type $rel
     * @return type
     */
    function get($query = array(), $fields = array(), $rel = array()) {
        if (isset($_REQUEST['action']) && ($_REQUEST['action'] === 'getListData' || $_REQUEST['action'] === 'search')) {
            $modConfObj = new AccessModConf();
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
        if ($_REQUEST['action'] === 'search') {
            $query = $this->getQuery();
        }

        $res = parent::getAccessMod($query, $fields, $rel);
        return $res;
    }

    /**
     * 
     * @return type
     */
    function getQuery() {
        $modConfObj = new AccessModConf();
        $modConf = $modConfObj->getModConf();
        $query = array();
        if (isset($modConf['searchFields']) && !empty($modConf['searchFields'])) {
            foreach ($modConf['searchFields'] as $key => $field) {
                if (isset($_REQUEST[$field['fieldName']]) && $_REQUEST[$field['fieldName']] !== '') {
                    $key = ($field['fieldName'] === 'cmodule') ? 'module' : $field['fieldName'];
                    $query[$key] = array(
                        'operator' => (isset($field['operator'])) ? $field['operator'] : 'eq',
                        'value' => $_REQUEST[$field['fieldName']],
                    );
                }
            }
        }
        return $query;
    }

    /**
     * 
     * @global type $en
     * @return type
     */
    function save() {
        global $en;
        $data = $this->getRequestData();
        $errorObj = new ValidateAccess();
        $errors = $errorObj->validate($data);
        if (!empty($errors)) {
            return array('errors' => $errors);
        }
        if (!isset($data['id']) || empty($data['id'])) {
            $query = array(
                'securityGroupId' => array(
                    'operator' => 'eq',
                    'value' => $data['securityGroupId'],
                ),
                'module' => array(
                    'operator' => 'eq',
                    'value' => $data['module'],
                ),
            );
            $access = $this->get($query);
            if (!empty($access)) {
                return array('errors' => array('already_exists' => $en['errors']['access']['exist']));
            }
        }
        return parent::saveAccessMod($data);
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
        if (!isset($data['id']) || empty($data['id'])) {
            $data['module'] = (isset($_REQUEST['cmodule'])) ? $_REQUEST['cmodule'] : '';
        } else {
            unset($data['module']);
        }
        return $data;
    }

}

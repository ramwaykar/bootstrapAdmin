<?php

global $docRoot;
include_once($docRoot . 'models/moduleCreator.php');
include_once($docRoot . 'views/moduleCreator/modConf.php');
include_once($docRoot . 'validations/validateModuleCreator.php');

class ModuleCreatorBO extends ModuleCreator {

    /**
     * 
     * @param type $query
     * @param type $fields
     * @param type $rel
     * @return type
     */
    function get($query = array(), $fields = array(), $rel = array()) {
        if (isset($_REQUEST['action']) && ($_REQUEST['action'] === 'getListData' || $_REQUEST['action'] === 'search')) {
            $modConfObj = new ModuleCreatorModConf();
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

        $res = parent::getModuleCreatorMod($query, $fields, $rel);
        return $res;
    }

    /**
     * 
     * @return type
     */
    function save() {
        $data = $this->getRequestData();
        $errorObj = new ValidateModuleCreator();
        $errors = $errorObj->validate($data);
        if (!empty($errors)) {
            return array('errors' => $errors);
        }

        return parent::saveModuleCreatorMod($data);
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

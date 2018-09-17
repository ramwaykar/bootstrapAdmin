<?php

global $docRoot;
include_once($docRoot . 'models/logger.php');
include_once($docRoot . 'views/logger/modConf.php');

class LoggerBO extends Logger {

    /**
     * 
     * @param type $query
     * @param type $fields
     * @param type $rel
     * @return type
     */
    function get($query = array(), $fields = array(), $rel = array()) {
        if (isset($_REQUEST['action']) && ($_REQUEST['action'] === 'getListData' || $_REQUEST['action'] === 'search')) {
            $modConfObj = new LoggerModConf();
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

        $res = parent::getLoggerMod($query, $fields, $rel);
        return $res;
    }

}
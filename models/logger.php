<?php

global $docRoot;
include_once($docRoot . 'db/dbUtil.php');

class Logger extends DBUtil{

    var $table = 'sp_logger';

    /**
     * 
     * @return type
     */
    protected function tableDef() {
        return array('id', 'tableName', 'recordId', 'operation');
    }

    /**
     * 
     * @param type $query
     * @param string $fields
     * @param type $rel
     * @return type
     */
    protected function getLoggerMod($query, $fields = array(), $rel = array()) {
        if (empty($fields)) {
            $fields = array($this->table . '.*');
        }
        return parent::getData($this->table, $query, $fields, $rel);
    }

}
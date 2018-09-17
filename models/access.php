<?php

global $docRoot;
include_once($docRoot . 'db/dbUtil.php');

class Access extends DBUtil{

    var $table = 'sp_access';

    /**
     * 
     * @return type
     */
    protected function tableDef() {
        return array('id', 'module', 'access', 'securityGroupId');
    }

    /**
     * 
     * @param type $query
     * @param string $fields
     * @param type $rel
     * @return type
     */
    protected function getAccessMod($query, $fields = array(), $rel = array()) {
        if (empty($fields)) {
            $fields = array($this->table . '.*');
        }
        return parent::getData($this->table, $query, $fields, $rel);
    }

    /**
     * 
     * @param type $data
     * @return type
     */
    protected function saveAccessMod($data) {
        return parent::saveData($this->table, $data);
    }

}
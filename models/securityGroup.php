<?php

global $docRoot;
include_once($docRoot . 'db/dbUtil.php');

class SecurityGroup extends DBUtil {

    var $table = 'sp_security_group';

    /**
     * 
     * @return type
     */
    protected function tableDef() {
        return array('id', 'name', 'isAdmin', 'status');
    }

    /**
     * 
     * @param type $query
     * @param string $fields
     * @param type $rel
     * @return type
     */
    protected function getSecurityGroupMod($query, $fields = array(), $rel = array()) {
        if (empty($fields)) {
            $fields = array($this->table . '.*');
        }
        return parent::getData($this->table, $query, $fields, $rel);
    }

    /**
     * 
     * @global type $en
     * @param type $data
     * @return type
     */
    protected function saveSecurityGroupMod($data) {
        global $en;
        if (isset($data['isAdmin']) && $data['isAdmin'] == 1) {
            $query['isAdmin'] = array('operator' => 'eq', 'value' => 1,);
            if (isset($data['id']) && !empty($data['id'])) {
                $query['id'] = array('operator' => 'ne', 'value' => $data['id'],);
            }
            $secGrp = $this->getSecurityGroupMod($query);
            if (!empty($secGrp)) {
                return array('errors' => array('name' => $en['errors']['securityGroup']['isAdmin']));
            }
        }

        return parent::saveData($this->table, $data);
    }

    /**
     * 
     * @param type $data
     * @return type
     */
    protected function updateStatusSecurityGroupMod($data) {
        return parent::updateStatus($this->table, $data);
    }

    /**
     * 
     * @param type $data
     * @return type
     */
    protected function removeSecurityGroupMod($data) {
        return parent::removeRecord($this->table, $data);
    }

}

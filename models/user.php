<?php

global $docRoot;
include_once($docRoot . 'db/dbUtil.php');

class User extends DBUtil {

    var $table = 'sp_user';

    /**
     * 
     * @return type
     */
    protected function tableDef() {
        return array('id', 'username', 'password', 'email', 'phone', 'fName', 'lName', 'securityGroupId', 'status');
    }

    /**
     * 
     * @param type $query
     * @param string $fields
     * @param type $rel
     * @return type
     */
    protected function getUserMod($query, $fields = array(), $rel = array()) {
        if (empty($fields)) {
            $fields = array($this->table . '.*');
        }
        if (empty($rel)) {
            $rel = $this->relations();
        }
        return parent::getData($this->table, $query, $fields, $rel);
    }

    /**
     * 
     * @return string
     */
    protected function relations() {
        $rel = array();
        $rel['securityGroupId'] = 'sp_security_group';
        return $rel;
    }

    /**
     * 
     * @global type $en
     * @param type $data
     * @return type
     */
    protected function saveUserMod($data) {
        global $en;
        if (!isset($data['id']) || (isset($data['id']) && empty($data['id']))) {
            $query = array(
                'username' => array(
                    'operator' => 'eq',
                    'value' => $data['username'],
                ),
            );
            $user = $this->getUserMod($query);
            if (is_array($user) && !empty($user) && (count($user > 0))) {
                return array('errors' => array('user_exist' => $en['errors']['user']['exist']));
            }
        }
        return parent::saveData($this->table, $data);
    }

    /**
     * 
     * @param type $data
     * @return type
     */
    protected function updateStatusUserMod($data) {
        return parent::updateStatus($this->table, $data);
    }

    /**
     * 
     * @param type $data
     * @return type
     */
    protected function removeUserMod($data) {
        $rel = $this->relations();
        return parent::removeRecord($this->table, $data, $rel);
    }

}

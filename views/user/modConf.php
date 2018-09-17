<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UserModConf {

    /**
     * 
     * @global type $en
     * @return type
     */
    function getModConf() {
        global $en;
        return array(
            'listHeadins' => array(
                $en['labels']['common']['name'],
                $en['labels']['user']['username'],
                $en['labels']['securityGroup']['securityGroup'],
                $en['labels']['common']['status'],
                $en['labels']['common']['createdBy'],
                $en['labels']['common']['updatedBy'],
                $en['labels']['common']['createdAt'],
                $en['labels']['common']['updatedAt'],
                ''
            ),
            'listDisplayFields' => array(
                'name', 'username', 'security_group', 'status', 'createdBy', 'updatedBy', 'createdAt', 'updatedAt'
            ),
            'listSelectFields' => array(
                'sp_user.id as DT_RowId', 'concat(fName," ",lName) as name', 'username',
                'email', 'phone', 'sp_security_group.name as security_group', 'sp_user.status',
                'sp_user.createdBy as CB', 'sp_user.updatedBy as UB', 'sp_user.createdAt', 'sp_user.updatedAt'
            ),
            'searchFields' => array(
                array('fieldName' => 'fName'),
                array('fieldName' => 'lName'),
                array('fieldName' => 'username'),
                array('fieldName' => 'email'),
                array('fieldName' => 'phone'),
                array('fieldName' => 'securityGroupId'),
                array('fieldName' => 'status')
            ),
        );
    }

}

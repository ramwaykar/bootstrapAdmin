<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AccessModConf {

    /**
     * 
     * @global type $en
     * @return type
     */
    function getModConf() {
        global $en;
        return array(
            'listHeadins' => array(
                $en['labels']['common']['module'],
                $en['labels']['securityGroup']['securityGroup'],
                $en['labels']['common']['accessDetails'],
                $en['labels']['common']['createdBy'],
                $en['labels']['common']['updatedBy'],
                $en['labels']['common']['createdAt'],
                $en['labels']['common']['updatedAt'],
                ''
            ),
            'listDisplayFields' => array(
                'module', 'securityGroupId', 'access', 'createdBy', 'updatedBy', 'createdAt', 'updatedAt'
            ),
            'listSelectFields' => array(
                'id as DT_RowId', 'module', 'access', 'securityGroupId as SG',
                "(SELECT sp_security_group.Name FROM sp_security_group where id = SG) as securityGroupId",
                'status', 'createdBy as CB', 'updatedBy as UB', 'createdAt', 'updatedAt'
            ),
            'searchFields' => array(
                array('fieldName' => 'cmodule'),
                array('fieldName' => 'securityGroupId')
            ),
        );
    }

}

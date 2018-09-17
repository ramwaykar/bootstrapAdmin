<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SecurityGroupModConf {

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
                $en['labels']['securityGroup']['isAdmin'],
                $en['labels']['common']['status'],
                $en['labels']['common']['createdBy'],
                $en['labels']['common']['updatedBy'],
                $en['labels']['common']['createdAt'],
                $en['labels']['common']['updatedAt'],
                ''
            ),
            'listDisplayFields' => array(
                'name', 'isAdmin', 'status', 'createdBy', 'updatedBy', 'createdAt', 'updatedAt'
            ),
            'listSelectFields' => array(
                'id as DT_RowId', 'isAdmin', 'name', 'status', 'createdBy as CB', 'updatedBy as UB', 'createdAt', 'updatedAt'
            ),
            'searchFields' => array(
                array('fieldName' => 'name'),
                array('fieldName' => 'status')
            ),
            'editImpact' => array('sp_user', 'sp_access'),
        );
    }

}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LoggerModConf {

    /**
     * 
     * @global type $en
     * @return type
     */
    function getModConf() {
        global $en;
        return array(
            'listHeadins' => array(
                $en['labels']['common']['createdAt'],
                $en['labels']['logger']['table'],
                $en['labels']['logger']['recordId'],
                $en['labels']['logger']['operation'],
                $en['labels']['common']['createdBy'],
                ''
            ),
            'listDisplayFields' => array(
                'createdAt', 'tableName', 'recordId', 'operation', 'createdBy'
            ),
            'listSelectFields' => array(
                'id as DT_RowId', 'tableName', 'recordId', 'operation',
                'createdBy as CB', 'updatedBy as UB', 'createdAt', 'updatedAt'
            ),
            'searchFields' => array(
                array('fieldName' => 'tableName'),
                array('fieldName' => 'operation')
            ),
        );
    }

}

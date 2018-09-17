<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DBLogger {

    /**
     * 
     * @global type $dbDateTimeFormat
     * @param type $table
     * @param type $recordId
     * @param type $operation
     * @param type $userId
     * @param type $conn
     * @param type $diff
     * @return boolean
     */
    function createLog($table, $recordId, $operation, $userId, $conn, $diff = '') {
        global $dbDateTimeFormat;
        $id = getUniqueId();
        $date = getCurrentDateTime($dbDateTimeFormat);
        $insert = "INSERT INTO sp_logger"
                . "(id, tableName, recordId, operation, diff, status, is_deleted, createdAt, createdBy, updatedAt, updatedBy)"
                . " VALUES ('" . $id . "','" . $table . "','" . $recordId . "','" . $operation . "','" . $diff . "',1,0,"
                . "'" . $date . "','" . $userId . "','" . $date . "','" . $userId . "')";
        $conn->query($insert);
        return true;
    }

}
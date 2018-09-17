<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CheckUserAccess {

    /**
     * 
     * @global type $docRoot
     * @param type $module
     * @return type
     */
    function check($module) {
        global $docRoot;
        include_once($docRoot . 'db/dbConf.php');
        $select = "SELECT sp_access.access FROM sp_access 
                    INNER JOIN sp_security_group ON sp_access.securityGroupId = sp_security_group.id
                    INNER JOIN sp_user ON sp_security_group.id = sp_user.securityGroupId
                    WHERE sp_user.username='" . $_SESSION['sp_username'] . "' and sp_access.module='" . $module . "'";
        $db = new DBConf();
        $conn = $db->createConnection();
        $res = $conn->query($select);
        $records = array();
        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
            $records[] = $row;
        }
        $access = (!empty($records)) ? $records[0]['access'] : 1;
        return $access;
    }

}

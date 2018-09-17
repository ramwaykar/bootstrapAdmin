<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
global $docRoot;
include_once($docRoot . 'db/dbConf.php');

class EditImpact {

    /**
     * 
     * @global type $docRoot
     * @param type $id
     * @return boolean
     */
    function manageEditImpactOfDelete($id) {
        global $docRoot;
        $module = $_REQUEST['module'];
        $file = $docRoot . 'views/' . $module . '/modConf.php';
        if (file_exists($file)) {
            include_once($file);
            $className = ucfirst($module) . 'ModConf';
            $obj = new $className();
            $conf = $obj->getModConf();
            if (isset($conf['editImpact']) && !empty($conf['editImpact'])) {
                $db = new DBConf();
                $conn = $db->createConnection();
                foreach ($conf['editImpact'] as $key => $relTable) {
                    $relFieldName = $module . 'Id';
                    $sql = "UPDATE " . $relTable . " SET is_deleted=1 WHERE " . $relFieldName . "='" . $id . "'";
                    $res = $conn->query($sql);
                    if ($res) {
                        return true;
                    } else {
                        return $conn->error;
                    }
                }
            }
        }
    }

    /**
     * 
     * @global type $docRoot
     * @param type $id
     * @param type $status
     */
    function manageEditImpactOfStatus($id, $status) {
        global $docRoot;
        $module = $_REQUEST['module'];
        $file = $docRoot . 'views/' . $module . '/modConf.php';
        if (file_exists($file)) {
            include_once($file);
            $className = ucfirst($module) . 'ModConf';
            $obj = new $className();
            $conf = $obj->getModConf();
            if (isset($conf['editImpact']) && !empty($conf['editImpact'])) {
                $db = new DBConf();
                $conn = $db->createConnection();
                foreach ($conf['editImpact'] as $key => $relTable) {
                    $relFieldName = $module . 'Id';
                    $sql = "UPDATE " . $relTable . " SET status=" . $status . " WHERE " . $relFieldName . "='" . $id . "'";                    
                    $res = $conn->query($sql);
                }
            }
        }
    }

}
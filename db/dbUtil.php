<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
global $docRoot;
include_once($docRoot . 'db/dbConf.php');
include_once($docRoot . 'db/editImpact.php');
include_once($docRoot . 'db/logger.php');

class DBUtil {

    /**
     * 
     * @param type $table
     * @param type $query
     * @param type $fields
     * @param type $rel
     * @return type
     */
    protected function getData($table, $query = array(), $fields = array(), $rel = array()) {
        $records = array();
        $result = array();
        $db = new DBConf();
        $conn = $db->createConnection();

        $select = "SELECT " . $this->getFields($fields) . ' FROM ' . $table;
        if (!empty($rel)) {
            $select .= $this->addJoins($table, $rel);
        }
        $select .= $this->getWhere($table, $query);
        $select .= $this->getOrderBy($table);

        $select .= $this->getLimit();
        $res = $conn->query($select);

        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
            $records[] = $row;
        }

        if (isset($_REQUEST['action']) && ($_REQUEST['action'] === 'getListData' || $_REQUEST['action'] === 'search')) {
            $countQuery = "SELECT COUNT(*) as cnt FROM " . $table;
            if (!empty($rel)) {
                $countQuery .= $this->addJoins($table, $rel);
            }
            $countQuery .= $this->getWhere($table, $query);
            $result = $conn->query($countQuery);
            $count = $result->fetch(PDO::FETCH_ASSOC);
            return array('count' => $count['cnt'], 'records' => $records);
        }

        return $records;
    }

    /**
     * 
     * @param type $table
     * @param type $rel
     * @return string
     */
    protected function addJoins($table, $rel) {
        $join = '';
        foreach ($rel as $lKey => $rTable) {
            $join .= ' INNER JOIN ' . $rTable . ' ON ' . $table . '.' . $lKey . '=' . $rTable . '.id ';
        }
        return $join;
    }

    /**
     * 
     * @param type $fields
     * @return string
     */
    protected function getFields($fields) {
        $select = '';
        if (empty($fields)) {
            $select .= '* ';
        } else {
            foreach ($fields as $key => $field) {
                if ($key > 0 && $key < count($fields)) {
                    $select .= ', ';
                }
                $select .= $field;
            }
        }


        if (isset($_REQUEST['action']) && ($_REQUEST['action'] === 'getListData' || $_REQUEST['action'] === 'search')) {
            $select .= ",(SELECT concat(sp_user.fName,' ',sp_user.lname) FROM sp_user where id = CB) as createdBy";
            $select .= ",(SELECT concat(sp_user.fName,' ',sp_user.lname) FROM sp_user where id=UB) AS updatedBy";
        }
        return $select;
    }

    /**
     * 
     * @param type $table
     * @param type $query
     * @return type
     */
    protected function getWhere($table, $query) {
        $where = $table . ".is_deleted=0";
        if (!empty($query)) {
            foreach ($query as $key => $val) {
                $where .= ' AND ';
                switch ($val['operator']) {
                    case 'ne':
                        $where .= $table . '.' . $key . " != '" . $val['value'] . "'";
                        break;
                    default :
                        $where .= $table . '.' . $key . " = '" . $val['value'] . "'";
                }
            }
        }

        //if user is not admin, fetch records created or updated by this user only
        if (isset($_SESSION['sp_isAdmin']) && empty($_SESSION['sp_isAdmin'])) {
            $where .= " AND (" . $table . ".createdBy = '" . $_SESSION['sp_user_id'] . "' 
                              OR " . $table . ".updatedBy= '" . $_SESSION['sp_user_id'] . "'
                            )";
        }

        return ' WHERE ' . $where;
    }

    /**
     * 
     * @param type $table
     * @return string
     */
    protected function getOrderBy($table) {
        $order = ' ORDER BY ' . $table . '.id DESC ';
        if (isset($_REQUEST['order']) && !empty($_REQUEST['order'])) {
            $order = ' ORDER BY ' . $_REQUEST['columns'][$_REQUEST['order'][0]['column']]['name'] . ' ' . strtoupper($_REQUEST['order'][0]['dir']);
        }
        return $order;
    }

    /**
     * 
     * @return string
     */
    protected function getLimit() {
        $limit = '';
        if (isset($_REQUEST['start']) && isset($_REQUEST['length'])) {
            $limit = ' LIMIT ' . $_REQUEST['start'] . ', ' . $_REQUEST['length'];
        }
        return $limit;
    }

    /**
     * 
     * @global type $dbDateTimeFormat
     * @param type $table
     * @param type $data
     * @return boolean
     */
    protected function saveData($table, $data) {
        global $dbDateTimeFormat;
        $operation = 1;
        $date = getCurrentDateTime($dbDateTimeFormat);
        if (isset($data['id']) && !empty($data['id'])) {
            $id = $data['id'];
            $operation = 2;
        } else {
            $id = getUniqueId();
            $data['is_deleted'] = 0;
            $data['status'] = 1;
            $data['createdAt'] = $date;
            $data['createdBy'] = $_SESSION['sp_user_id'];
        }

        $data['updatedAt'] = $date;
        $data['updatedBy'] = isset($_SESSION['sp_user_id']) ? $_SESSION['sp_user_id'] : '';

        $fields = '';
        $values = '';
        $ind = 0;

        if (isset($data['id']) && !empty($data['id'])) {
            unset($data['id']);
            foreach ($data as $key => $val) {
                if ($ind > 0 && $ind < count($data)) {
                    $fields .= ', ';
                }
                $fields .= $key . "='" . $val . "'";
                $ind++;
            }
            $sql = "UPDATE " . $table . " SET " . $fields . " WHERE " . $table . ".id='" . $id . "'";
        } else {
            $data['id'] = $id;
            foreach ($data as $key => $val) {
                if ($ind > 0 && $ind < count($data)) {
                    $fields .= ', ';
                    $values .= ', ';
                }
                $fields .= $key;
                $values .= "'" . $val . "'";
                $ind++;
            }
            $sql = "INSERT INTO " . $table . " (" . $fields . ") VALUES(" . $values . ")";
        }

        $db = new DBConf();
        $conn = $db->createConnection();
        $res = $conn->query($sql);
        $logger = new DBLogger();
        $logger->createLog($table, $id, $operation, (isset($_SESSION['sp_user_id']) ? $_SESSION['sp_user_id'] : ''), $conn);
        if ($res) {
            return true;
        } else {
            return $conn->error;
        }
    }

    /**
     * 
     * @param type $table
     * @param type $data
     * @param type $rel
     * @return boolean
     */
    protected function removeRecord($table, $data, $rel = array()) {
        global $dbDateTimeFormat;
        $date = getCurrentDateTime($dbDateTimeFormat);
        $updatedAt = $date;
        $updatedBy = isset($_SESSION['sp_user_id']) ? $_SESSION['sp_user_id'] : '';
        $sql = "UPDATE " . $table . " SET is_deleted=1,updatedBy='" . $updatedBy . "',updatedAt='" . $updatedAt . "' 
                 WHERE id='" . $data['id'] . "'";
        $db = new DBConf();
        $conn = $db->createConnection();
        $res = $conn->query($sql);
        if ($res) {
            $logger = new DBLogger();
            $logger->createLog($table, $data['id'], 3, $_SESSION['sp_user_id'], $conn);
            $editimpact = new EditImpact();
            $editimpact->manageEditImpactOfDelete($data['id']);
            return true;
        } else {
            return $conn->error;
        }
    }

    /**
     * 
     * @param type $table
     * @param type $data
     * @return boolean
     */
    protected function updateStatus($table, $data) {
        global $dbDateTimeFormat;
        $operation = ($data['status'] == 0 ) ? 5 : 4;
        $date = getCurrentDateTime($dbDateTimeFormat);
        $updatedAt = $date;
        $updatedBy = isset($_SESSION['sp_user_id']) ? $_SESSION['sp_user_id'] : '';
        $sql = "UPDATE " . $table . " SET status=" . $data['status'] . ",updatedBy='" . $updatedBy . "',updatedAt='" . $updatedAt . "' 
                 WHERE id='" . $data['id'] . "'";
        $db = new DBConf();
        $conn = $db->createConnection();
        $res = $conn->query($sql);
        if ($res) {
            $logger = new DBLogger();
            $logger->createLog($table, $data['id'], $operation, $_SESSION['sp_user_id'], $conn);
            $editimpact = new EditImpact();
            $editimpact->manageEditImpactOfStatus($data['id'], $data['status']);
            return true;
        } else {
            return $conn->error;
        }
    }

    /**
     * 
     * @param type $name
     * @return boolean
     */
    protected function createModuleTable($name) {
        $db = new DBConf();
        $conn = $db->createConnection();
        $sql = "CREATE TABLE sp_" . $name . " (
                    id VARCHAR(32) PRIMARY KEY, 
                    name varchar(50) NOT NULL,
                    status tinyint(1) NOT NULL,
                    is_deleted tinyint(1) NOT NULL,
                    createdAt varchar(20) NOT NULL,
                    createdBy VARCHAR(32) NOT NULL,
                    updatedAt varchar(20) NOT NULL,
                    updatedBy VARCHAR(32) NOT NULL
                 )";
        $conn->query($sql);
        return true;
    }

}

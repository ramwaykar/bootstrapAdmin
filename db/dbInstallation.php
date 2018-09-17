<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
global $docRoot;
include_once($docRoot . 'db/logger.php');

class InstallDB {

    /**
     * 
     * @param type $dbData
     * @return boolean
     */
    function createMySQLDB($dbData) {
        $response = false;
        $conn = new mysqli($dbData['dbHost'], $dbData['dbUser'], $dbData['dbPassword']);
        if ($conn->connect_error) {
            $response = false;
        } else {
            $this->createDbConfFile($dbData);
            $res = $conn->query("CREATE DATABASE " . $dbData['dbName']);
            $conn->close();
            $response = true;
        }

        return $response;
    }

    /**
     * 
     * @param type $dbData
     */
    protected function createDbConfFile($dbData) {
        $myfile = fopen("../db/dbConf.php", "w") or die("Unable to open file!");
        $txt = "<?php\n\n";
        $txt .= "\tclass DBConf{\n";
        $txt .= "\t\tprivate function conf(){\n";
        $txt .= "\t\t\treturn array(\n";
        $txt .= "\t\t\t\t'dbHost'=> '" . $dbData['dbHost'] . "',\n";
        $txt .= "\t\t\t\t'dbUser'=> '" . $dbData['dbUser'] . "',\n";
        $txt .= "\t\t\t\t'dbPassword'=> '" . $dbData['dbPassword'] . "',\n";
        $txt .= "\t\t\t\t'dbName'=> '" . $dbData['dbName'] . "'\n";
        $txt .= "\t\t\t);\n";
        $txt .= "\t\t}\n\n";
        $txt .= "\t\tfunction createConnection(){\n";
        $txt .= "\t\t\ttry {\n";
        $txt .= "\t\t\t\t" . '$conf = $this->conf();' . "\n";
        $txt .= "\t\t\t\t" . '$conn = new PDO("mysql:host=".$conf["dbHost"].";dbname=".$conf["dbName"]."", $conf["dbUser"], $conf["dbPassword"]);' . "\n";
        $txt .= "\t\t\t\t" . '$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);' . "\n";
        $txt .= "\t\t\t\t" . 'return $conn;' . "\n";
        $txt .= "\t\t\t\t}\n";
        $txt .= "\t\t\t" . 'catch(PDOException $e){' . "\n";
        $txt .= "\t\t\t\t" . 'return $e->getMessage();' . "\n";
        $txt .= "\t\t\t}\n";
        $txt .= "\t\t}\n\n";
        $txt .= "\t}";
        fwrite($myfile, $txt);
        fclose($myfile);
    }

    /**
     * 
     * @param type $dbData
     */
    function createMsSQLDB($dbData) {
        
    }

    /**
     * 
     * @param type $adminData
     * @param type $dbData
     * @return boolean
     */
    function createTables($adminData, $dbData) {
        $userId = getUniqueId();
        $securityGroupId = getUniqueId();
        $conn = $this->getConnection($dbData);
        if ($conn) {
            if ($this->createLoggerTable($conn)) {
                if ($this->createUsersTable($adminData, $userId, $securityGroupId, $conn)) {
                    if ($this->createSecurityGroupTable($userId, $securityGroupId, $conn)) {
                        if ($this->createAccessTable($securityGroupId, $userId, $conn)) {
                            $this->createModuleCreatorTable($userId, $conn);
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        return false;
    }

    /**
     * 
     * @param type $dbData
     * @return \PDO
     */
    function getConnection($dbData) {
        $conn = new PDO("mysql:host=" . $dbData['dbHost'] . ";dbname=" . $dbData['dbName'], $dbData['dbUser'], $dbData['dbPassword']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }

    /**
     * 
     * @param type $conn
     * @return boolean
     */
    function createLoggerTable($conn) {
        $sql = "CREATE TABLE sp_logger (
                    id VARCHAR(32) PRIMARY KEY, 
                    tableName varchar(50) NOT NULL,
                    recordId varchar(32) NOT NULL,
                    operation int(2) NOT NULL,
                    diff TEXT NOT NULL,
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

    /**
     * 
     * @global type $dbDateTimeFormat
     * @param type $adminData
     * @param type $userId
     * @param type $securityGroupId
     * @param type $conn
     * @return boolean
     */
    function createUsersTable($adminData, $userId, $securityGroupId, $conn) {
        global $dbDateTimeFormat;
        try {
            $date = getCurrentDateTime($dbDateTimeFormat);
            $sql = "CREATE TABLE sp_user (
                    id VARCHAR(32) PRIMARY KEY, 
                    fName varchar(100) NOT NULL,
                    lName varchar(100) NOT NULL,
                    username varchar(100) NOT NULL,
                    password varchar(255) NOT NULL,
                    email varchar(255) NOT NULL,
                    securityGroupId VARCHAR(32) NOT NULL,
                    phone varchar(20) NOT NULL,
                    status tinyint(1) NOT NULL,
                    is_deleted tinyint(1) NOT NULL,
                    createdAt varchar(20) NOT NULL,
                    createdBy VARCHAR(32) NOT NULL,
                    updatedAt varchar(20) NOT NULL,
                    updatedBy VARCHAR(32) NOT NULL
                 )";
            $conn->query($sql);

            $insert = "INSERT INTO sp_user
                        (id, fName, lName, username, password, email, securityGroupId,
                        phone, status, is_deleted, createdAt, createdBy, updatedAt, updatedBy)
                        VALUES ('" . $userId . "','" . $adminData['username'] . "','','" . $adminData['username'] . "',
                        '" . md5($adminData['password']) . "','" . $adminData['email'] . "','" . $securityGroupId . "',
                        '" . $adminData['phone'] . "',1,0,'" . $date . "','" . $userId . "','" . $date . "','" . $userId . "')";
            $conn->query($insert);
            $logger = new DBLogger();
            $logger->createLog('sp_user', $userId, 1, $userId, $conn);
            return true;
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    /**
     * 
     * @global type $dbDateTimeFormat
     * @param type $userId
     * @param type $securityGroupId
     * @param type $conn
     * @return boolean
     */
    protected function createSecurityGroupTable($userId, $securityGroupId, $conn) {
        global $dbDateTimeFormat;
        $response = false;
        $date = getCurrentDateTime($dbDateTimeFormat);
        try {
            if ($conn) {
                $sql = "CREATE TABLE sp_security_group (
                    id VARCHAR(32) PRIMARY KEY, 
                    name varchar(100) NOT NULL,
                    isAdmin tinyint(1) NOT NULL,
                    status tinyint(1) NOT NULL,
                    is_deleted tinyint(1) NOT NULL,
                    createdAt varchar(20) NOT NULL,
                    createdBy VARCHAR(32) NOT NULL,
                    updatedAt varchar(20) NOT NULL,
                    updatedBy VARCHAR(32) NOT NULL
                 )";
                $conn->query($sql);
                $insert = "INSERT INTO sp_security_group"
                        . "(id, name, isAdmin, status, is_deleted, createdAt, createdBy, updatedAt, updatedBy)"
                        . " VALUES ('" . $securityGroupId . "','Admin',1,1,0,'" . $date . "','" . $userId . "','" . $date . "','" . $userId . "')";
                $conn->query($insert);
                $logger = new DBLogger();
                $logger->createLog('sp_security_group', $securityGroupId, 1, $userId, $conn);
                $response = true;
            }
        } catch (PDOException $e) {
            //$response = $e->getMessage();
        }
        return $response;
    }

    /**
     * 
     * @global type $dbDateTimeFormat
     * @param type $securityGroupId
     * @param type $userId
     * @param type $conn
     * @return boolean
     */
    protected function createAccessTable($securityGroupId, $userId, $conn) {
        global $dbDateTimeFormat;
        $response = false;
        try {
            if ($conn) {
                $sql = "CREATE TABLE sp_access (
                    id VARCHAR(32) PRIMARY KEY, 
                    module varchar(100) NOT NULL,
                    access int(2) NOT NULL,
                    securityGroupId varchar(32) NOT NULL,
                    status tinyint(1) NOT NULL,
                    is_deleted tinyint(1) NOT NULL,
                    createdAt varchar(20) NOT NULL,
                    createdBy VARCHAR(32) NOT NULL,
                    updatedAt varchar(20) NOT NULL,
                    updatedBy VARCHAR(32) NOT NULL
                 )";
                $conn->query($sql);
                $existingModule = array('home', 'user', 'securityGroup', 'access', 'moduleCreator');
                for ($i = 0; $i < count($existingModule); $i++) {
                    $date = getCurrentDateTime($dbDateTimeFormat);
                    $id = getUniqueId();
                    $insert = "INSERT INTO sp_access"
                            . "(id, module, access, securityGroupId, status, is_deleted, createdAt, createdBy, updatedAt, updatedBy)"
                            . " VALUES ('" . $id . "','" . $existingModule[$i] . "',1,'" . $securityGroupId . "',1,0,"
                            . "'" . $date . "','" . $userId . "','" . $date . "','" . $userId . "')";
                    $conn->query($insert);
                    $logger = new DBLogger();
                    $logger->createLog('sp_access', $id, 1, $userId, $conn);
                }

                $response = true;
            }
        } catch (PDOException $e) {
            //$response = $e->getMessage();
        }
        return $response;
    }

    /**
     * 
     * @global type $dbDateTimeFormat
     * @param type $userId
     * @param type $conn
     * @return boolean
     */
    protected function createModuleCreatorTable($userId, $conn) {
        global $dbDateTimeFormat;
        $response = false;
        try {
            if ($conn) {
                $sql = "CREATE TABLE sp_module_creator (
                    id VARCHAR(32) PRIMARY KEY, 
                    name varchar(255) NOT NULL,
                    status tinyint(1) NOT NULL,
                    is_deleted tinyint(1) NOT NULL,
                    createdAt varchar(20) NOT NULL,
                    createdBy VARCHAR(32) NOT NULL,
                    updatedAt varchar(20) NOT NULL,
                    updatedBy VARCHAR(32) NOT NULL
                 )";
                $conn->query($sql);
                $existingModule = array('access', 'home', 'install', 'logger', 'login', 'moduleCreator',
                    'noAcces', 'user', 'securityGroup');
                for ($i = 0; $i < count($existingModule); $i++) {
                    $date = getCurrentDateTime($dbDateTimeFormat);
                    $id = getUniqueId();
                    $insert = "INSERT INTO sp_module_creator"
                            . "(id, name, status, is_deleted, createdAt, createdBy, updatedAt, updatedBy)"
                            . " VALUES ('" . $id . "','" . $existingModule[$i] . "',1,0,"
                            . "'" . $date . "','" . $userId . "','" . $date . "','" . $userId . "')";
                    $conn->query($insert);
                    $logger = new DBLogger();
                    $logger->createLog('sp_module_creator', $id, 1, $userId, $conn);
                }

                $response = true;
            }
        } catch (PDOException $e) {
            //$response = $e->getMessage();
        }
        return $response;
    }

}

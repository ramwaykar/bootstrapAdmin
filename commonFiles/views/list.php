<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
global $docRoot;
include_once $docRoot . 'commonFiles/buttons/listButtons.php';

class ListView {

    var $modConf = array();

    /**
     * 
     * @global type $docRoot
     * @param type $module
     */
    function displaySearchForm($module) {
        global $docRoot;
        $file = $docRoot . 'views/' . $module . '/searchView.php';
        if (file_exists($file)) {
            include_once($file);
            $className = ucfirst($module) . 'SearchView';
            $obj = new $className();
            $obj->loadSearchView($module);
        }
    }

    /**
     * 
     * @param type $module
     */
    function displayButtons($module) {
        $buttons = new ListButtons();
        return $buttons->displayButtons($module);
    }

    /**
     * 
     * @global type $docRoot
     * @param type $module
     */
    function getData($module) {
        global $docRoot;
        include_once $docRoot . 'views/' . $module . '/modConf.php';
        $classname = ucfirst($module) . 'ModConf';
        $modConfObj = new $classname();
        $this->modConf = $modConfObj->getModConf();
        echo $this->displaySearchForm($module);
        echo $this->displayButtons($module);
        echo $this->getTable();
    }

    /**
     * 
     * @return string
     */
    protected function getTable() {
        $table = '<div class="col-sm-12"><table id="dataTable" style="width:100%">';
        $table .= $this->getTableHeadings();
        $table .= '</table></div>';
        return $table;
    }

    /**
     * 
     * @return string
     */
    protected function getTableHeadings() {
        $headings = '<thead><tr>';
        foreach ($this->modConf['listHeadins'] as $key => $heading) {
            $headings .= '<th>' . $heading . '</th>';
        }
        $headings .= '</tr></thead>';
        return $headings;
    }

    /**
     * 
     * @return string
     */
    protected function getTableBody() {
        $body = '<tbody>';
        $body .= '</tbody>';
        return $body;
    }

    /**
     * 
     * @global type $siteRoot
     * @global type $dd
     * @global type $displayDateTimeFormat
     * @global type $en
     * @global type $docRoot
     * @param type $module
     * @param type $res
     * @return type
     */
    function getActionButtons($module, $res) {
        global $siteRoot, $dd, $displayDateTimeFormat, $en;
        global $docRoot, $timezone;
        include_once $docRoot . 'views/' . $module . '/modConf.php';
        $temp = array();
        $classname = ucfirst($module) . 'ModConf';
        $modConfObj = new $classname();
        $modConf = $modConfObj->getModConf();
        $viewOnlyModules = array('logger', 'moduleCreator');
        foreach ($res as $key => $row) {
            $buttons = '';
            $buttons .= '<a href="' . $siteRoot . 'views/' . $module . '?action=view&id=' . $row['DT_RowId'] . '">
                            <span class="glyphicon glyphicon-eye-open action_buttons view"></span>
                        </a>';
            if (isset($_SESSION['access'][$module]) && $_SESSION['access'][$module] == 1 && (!in_array($module, $viewOnlyModules))) {
                $buttons .= '<a href="' . $siteRoot . 'views/' . $module . '?action=create&id=' . $row['DT_RowId'] . '">
                            <span class="glyphicon glyphicon-edit action_buttons edit"></span>
                        </a>';
                $buttons .= '<a href="' . $siteRoot . 'views/' . $module . '?action=delete&id=' . $row['DT_RowId'] . '">
                            <span class="glyphicon glyphicon-remove action_buttons delete"></span>
                        </a>
                       ';
            }
            foreach ($modConf['listDisplayFields'] as $key1 => $val) {
                switch ($val) {
                    case 'status': $temp[$key][$key1] = $dd['status'][$row[$val]];
                        break;
                    case 'createdAt':
                    case 'updatedAt':
                        date_default_timezone_set($timezone);
                        $dateArr = date_parse($row[$val]);
                        $temp[$key][$key1] = date($displayDateTimeFormat, mktime($dateArr['hour'], $dateArr['minute'], $dateArr['second'], $dateArr['month']
                                        , $dateArr['day'], $dateArr['year']));
                        break;
                    case 'access':$temp[$key][$key1] = $dd['access'][$row[$val]];
                        break;
                    case 'isAdmin':$temp[$key][$key1] = $dd['yesNo'][$row[$val]];
                        break;
                    case 'operation':$temp[$key][$key1] = $dd['operation'][$row[$val]];
                        break;
                    default :$temp[$key][$key1] = $row[$val];
                }
            }
            $temp[$key][count($modConf['listDisplayFields'])] = $buttons;
            $temp[$key]['DT_RowId'] = $row['DT_RowId'];
        }

        return $temp;
    }

    /**
     * 
     * @global type $docRoot
     * @param type $module
     * @return type
     */
    function getQuery($module) {
        global $docRoot;
        $query = array();
        include_once $docRoot . 'views/' . $module . '/modConf.php';
        $classname = ucfirst($module) . 'ModConf';
        $modConfObj = new $classname();
        $modConf = $modConfObj->getModConf();
        if (isset($modConf['searchFields']) && !empty($modConf['searchFields'])) {
            foreach ($modConf['searchFields'] as $key => $field) {
                if (isset($_REQUEST[$field['fieldName']]) && $_REQUEST[$field['fieldName']] !== '') {
                    $query[$field['fieldName']] = array(
                        'operator' => (isset($field['operator'])) ? $field['operator'] : 'eq',
                        'value' => $_REQUEST[$field['fieldName']],
                    );
                }
            }
        }
        return $query;
    }

}

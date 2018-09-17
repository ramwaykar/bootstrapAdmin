<?php

global $docRoot;
include_once $docRoot . 'commonFiles/views/list.php';

class AccessListView extends ListView {

    var $errors = array();

    /**
     * 
     * @param type $module
     */
    function loadListView($module) {
        parent::getData($module);
    }

}

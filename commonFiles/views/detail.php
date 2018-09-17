<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
global $docRoot;
include_once $docRoot . 'commonFiles/buttons/detailButtons.php';

class DetailView {

    /**
     * 
     * @global type $docRoot
     * @param type $module
     * @return type
     */
    function getData($module) {
        global $docRoot;
        $file = $docRoot . 'controllers/' . $module . 'BO.php';
        if (file_exists($file)) {
            include_once($file);
            $className = ucfirst($module) . 'BO';
            $obj = new $className();
            $query = array('id' => array('operator' => 'eq', 'value' => $_REQUEST['id']));
            $res = $obj->get($query);
            return $res;
        }
        return array();
    }
    
    /**
     * 
     * @param type $module
     * @param type $data
     * @return type
     */
    function getDetails($module, $data) {
        $buttons = new DetailButtons();
        $details = $this->openForm($module);
        $details .= $buttons->displayButtons($module, false, $data[0]['status']);
        return $details;
    }

    /**
     * 
     * @param type $module
     * @return string
     */
    function openForm($module) {
        $form = '<div class="container form_container">
                <div class="container detailsForm">
                    <div class="row">
                        <div class="form-horizontal">';
        return $form;
    }

    /**
     * 
     * @param type $module
     * @param type $data
     * @return string
     */
    function closeForm($module, $data) {
        $buttons = new DetailButtons();
        $form = $buttons->displayButtons($module, true, $data[0]['status']);
        $form .= '</div>
                </div>
            </div>
        </div>';
        return $form;
    }

}

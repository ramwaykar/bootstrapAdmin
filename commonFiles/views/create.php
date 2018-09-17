<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
global $docRoot;
include_once $docRoot . 'commonFiles/buttons/createButtons.php';

class CreateView {

    /**
     * 
     * @global type $docRoot
     * @param type $id
     * @param type $module
     * @return type
     */
    function getData($id, $module) {
        global $docRoot;
        $file = $docRoot . 'controllers/' . $module . 'BO.php';
        if (file_exists($file)) {
            include_once($file);
            $className = ucfirst($module) . 'BO';
            $obj = new $className();
            $query = array('id' => array('operator' => 'eq', 'value' => $id));
            $res = $obj->get($query);
            return $res;
        }
        return array();
    }

    /**
     * 
     * @param type $module
     * @param type $action
     * @return type
     */
    function openForm($module, $action = 'save') {
        $data = '<div class="container form_container">
                <div class="container creationForm">
                    <div class="row">
                        <form method="post" id="edit-form" role="form" data-toggle="validator" class="form-horizontal" action="">
                            <input type="hidden" name="action" value="' . $action . '">
                            <input type="hidden" name="module" value="' . $module . '">
                            <input type="hidden" name="id" value="' . (isset($_REQUEST['id']) ? $_REQUEST['id'] : '') . '">
                            <div class="col-md-12">';
        $buttons = new CreateButtons();
        $data .= $buttons->displayButtons($module);
        return $data;
    }

    /**
     * 
     * @param type $module
     * @return string
     */
    function closeForm($module) {
        $buttons = new CreateButtons();
        $data = $buttons->displayButtons($module);
        $data .= '</div>
            </form>
        </div>
        </div>
        </div>';
        return $data;
    }

}

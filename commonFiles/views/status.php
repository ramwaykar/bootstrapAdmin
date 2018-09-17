<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
global $docRoot;
include_once $docRoot . '/admin/commonFiles/buttons/statusButtons.php';

class StatusView {

    /**
     * 
     * @param type $module
     */
    function loadStatusView($module) {
        $buttons = new StatusButtons();
        $data = $this->openForm($module);
        $data .= $buttons->displayButtons($module);
        $data .= $this->closeForm($module);
        echo $data;
    }

    /**
     * 
     * @global type $en
     * @param type $module
     * @return string
     */
    function openForm($module) {
        global $en;
        $form = '<div class="container form_container">
                <div class="container creationForm">
                    <div class="">
                            <h4>' . $en['notifications']['common']['confirmstatusChange'] . '</h4>
                    </div>
                    <div class="row">
                        <form method="post" id="status-form" role="form" data-toggle="validator" class="form-horizontal" action="">
                            <input type="hidden" name="action" value="updateStatus">
                            <input type="hidden" name="module" value="' . $module . '">
                            <input type="hidden" name="status" value="' . (isset($_REQUEST['status']) ? $_REQUEST['status'] : 1) . '">
                            <input type="hidden" name="id" value="' . (isset($_REQUEST['id']) ? $_REQUEST['id'] : '') . '">
                            <div class="col-md-12">';
        return $form;
    }

    /**
     * 
     * @param type $module
     * @return string
     */
    function closeForm($module) {
        $form = '</div>
            </form>
        </div>
        </div>
        </div>';
        return $form;
    }

}

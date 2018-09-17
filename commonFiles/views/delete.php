<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
global $docRoot;
include_once $docRoot . 'commonFiles/buttons/deleteButtons.php';

class DeleteView {

    /**
     * 
     * @param type $module
     */
    function loadDeleteView($module) {
        $buttons = new DeleteButtons();
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
                            <h4>'.$en['notifications']['common']['confirmDelete'].'</h4>
                    </div>
                    <div class="row">
                        <form method="post" id="delete-form" role="form" data-toggle="validator" class="form-horizontal" action="">
                            <input type="hidden" name="action" value="remove">
                            <input type="hidden" name="module" value="' . $module . '">
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

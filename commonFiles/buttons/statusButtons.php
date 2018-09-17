<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class StatusButtons {

    /**
     * 
     * @global type $siteRoot
     * @global type $en
     * @param type $module
     * @return string
     */
    function displayButtons($module) {
        global $siteRoot, $en;
        $status = isset($_REQUEST['status']) ? $_REQUEST['status'] : 1;
        $statusBtnLabel = ($status == 1) ? $en['labels']['common']['deActivate'] : $en['labels']['common']['activate'];
        $buttons = '<div class="form-group float-right">
                        <input type="button" class="btn btn-default  btn-primary" id="change-status-record" value="' . $statusBtnLabel . '" />
                        <a href="' . $siteRoot . 'views/' . $module . '" class="">
                            <input type="button" class="btn btn-default  btn-primary cancel-submit-form" value="' . $en['labels']['common']['cancel'] . '" />
                        </a>
                    </div>';
        return $buttons;
    }

}

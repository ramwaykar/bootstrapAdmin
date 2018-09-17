<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DeleteButtons {

    /**
     * 
     * @global type $siteRoot
     * @global type $en
     * @param type $module
     * @return string
     */
    function displayButtons($module) {
        global $siteRoot, $en;
        $buttons = '<div class="form-group float-right">
                        <input type="button" class="btn btn-default  btn-primary" id="delete-record" value="' . $en['labels']['common']['delete'] . '" />
                        <a href="' . $siteRoot . 'views/' . $module . '" class="">
                            <input type="button" class="btn btn-default  btn-primary cancel-submit-form" value="' . $en['labels']['common']['cancel'] . '" />
                        </a>
                    </div>';
        return $buttons;
    }

}

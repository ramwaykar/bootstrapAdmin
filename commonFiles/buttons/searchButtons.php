<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SearchButtons {

    /**
     * 
     * @global type $en
     * @param type $module
     * @return string
     */
    function displayButtons($module) {
        global $en;
        $buttons = '<div class="col-sm-12 detail-view-bottom-buttons">
                        <input type="button" class="btn btn-default  btn-primary search-form" value="' . $en['labels']['common']['search'] . '" />                        
                        <input type="button" class="btn btn-default  btn-primary clear-search-form" value="' . $en['labels']['common']['clear'] . '" />                        
                    </div>';
        return $buttons;
    }

}

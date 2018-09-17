<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ListButtons {

    /**
     * 
     * @global type $siteRoot
     * @global type $en
     * @param type $module
     * @return string
     */
    function displayButtons($module) {
        global $siteRoot, $en;
        $buttons = '<div class="col-sm-12">';
        if (isset($_SESSION['access'][$module]) && $_SESSION['access'][$module] == 1 && $module !== 'logger') {
            $buttons .= '<a id="list_top_buttons" class="" href="' . $siteRoot . 'views/' . $module . '?action=create">
                        <input type="button" class="btn btn-default  btn-primary" value="' . $en['labels']['common']['create'] . '" id="create" />
                    </a>';
        }
        $buttons .= '</div>';

        return $buttons;
    }

}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
global $docRoot;
include_once $docRoot . 'commonFiles/buttons/searchButtons.php';

class SearchView {

    /**
     * 
     * @param type $module
     * @return string
     */
    function openForm($module) {
        $data = '<div class="container form_container">
                <div class="searchForm">
                    <div class="row">
                        <form method="post" id="search-form" role="form" data-toggle="validator" class="form-horizontal" action="">                            
                            <input type="hidden" name="module" value="' . $module . '">
                            <input type="hidden" name="action" value="search">
                            <div class="">';
        return $data;
    }

    /**
     * 
     * @param type $module
     * @return string
     */
    function closeForm($module) {
        $buttons = new SearchButtons();
        $data = $buttons->displayButtons($module);
        $data .= '</div>
            </form>
        </div>
        </div>
        </div>';
        return $data;
    }

}

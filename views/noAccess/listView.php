<?php

class NoAccessListView {

    var $errors = array();

    /**
     * 
     * @global type $en
     * @param type $module
     */
    function loadListView($module) {
        global $en;
        echo '<div class="container form_container">
                <div class="container login_form">
                    <div>
                            <h4>'.$en['notifications']['common']['noAccess'].'</h4>
                    </div>
                </div>
             </div>';
    }

}

<?php

global $docRoot;
include_once $docRoot . 'commonFiles/views/search.php';

class ModuleCreatorSearchView extends SearchView {

    var $errors = array();
    var $module = 'moduleCreator';

    /**
     * 
     * @global type $en
     */
    function loadSearchView() {
        global $en;
        $form = parent::openForm($this->module);
        $form .= '	    
                    <div class="col-md-6">
                          <label for="name">' . $en['labels']['common']['name'] . '</label>
                          <input type="text" class="form-control" id="name"  name="name" required />                          
                    </div>
                    <div class="col-md-6">
                          <label for="status">' . $en['labels']['common']['status'] . '</label>
                          <select id="status" name="status" class="form-control">
                          ' . getStaticDropDownOptions('status', '', true, true) . '
                          </select>
                    </div>';
        $form .= parent::closeForm($this->module);
        echo $form;
    }

}

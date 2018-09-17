<?php

global $docRoot;
include_once $docRoot . 'commonFiles/views/search.php';

class AccessSearchView extends SearchView {

    var $errors = array();
    var $module = 'access';

    /**
     * 
     * @global type $en
     */
    function loadSearchView() {
        global $en;
        $form = parent::openForm($this->module);
        $form .= '<div class="col-md-6">
                        <label for="cmodule">' . $en['labels']['common']['module'] . '</label>
                        <input type="text" class="form-control" id="cmodule"  name="cmodule" />                          
                  </div>
                  <div class="col-md-6">
                      <label for="securityGroupId">' . $en['labels']['securityGroup']['securityGroup'] . '</label>
                      <select id="securityGroupId" name="securityGroupId" class="form-control" required>
                      ' . getDropDownOptions('securityGroup') . '
                      </select>
                  </div>';
        $form .= parent::closeForm($this->module);
        echo $form;
    }

}

<?php

global $docRoot;
include_once $docRoot . 'commonFiles/views/search.php';

class LoggerSearchView extends SearchView {

    var $errors = array();
    var $module = 'logger';

    /**
     * 
     * @global type $en
     */
    function loadSearchView() {
        global $en;
        $form = parent::openForm($this->module);
        $form .= '<div class="col-md-6">
                        <label for="tableName">' . $en['labels']['logger']['table'] . '</label>
                        <input type="text" class="form-control" id="tableName"  name="tableName" />                          
                  </div>
                  <div class="col-md-6">
                      <label for="operation">' . $en['labels']['logger']['operation'] . '</label>
                      <select id="operation" name="operation" class="form-control" required>
                      ' . getStaticDropDownOptions('operation') . '
                      </select>
                  </div>';
        $form .= parent::closeForm($this->module);
        echo $form;
    }

}

<?php

global $docRoot;
include_once $docRoot . 'commonFiles/views/create.php';

class SecurityGroupCreateView extends CreateView {

    var $errors = array();
    var $module = 'securityGroup';

    /**
     * 
     * @global type $en
     */
    function loadCreateView() {
        global $en;
        $form = parent::openForm($this->module);
        $data = (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) ? parent::getData($_REQUEST['id'], $this->module) : array();
        $checked = (isset($data[0]['isAdmin']) && $data[0]['isAdmin'] == 1) ? 'checked="checked"' : '';
        $form .= '	    
                    <div class="form-group">
                          <label for="name">' . $en['labels']['common']['name'] . '<sup>*</sup></label>
                          <input type="text" class="form-control" id="name"  name="name" value="' . (isset($data[0]['name']) ? $data[0]['name'] : '') . '" required />                          
                    </div>
                    <div class="form-group">
                          <label for="isAdmin">' . $en['labels']['securityGroup']['isAdmin'] . '</label>
                          <input ' . $checked . ' type="checkbox" class="form-control" id="isAdmin"  name="isAdmin" value="' . (isset($data[0]['isAdmin']) ? $data[0]['isAdmin'] : '') . '" />                          
                    </div>';
        $form .= parent::closeForm($this->module);
        echo $form;
    }

}

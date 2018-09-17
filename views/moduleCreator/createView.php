<?php

global $docRoot;
include_once $docRoot . 'commonFiles/views/create.php';
include_once $docRoot . 'controllers/accessBO.php';

class ModuleCreatorCreateView extends CreateView {

    var $errors = array();
    var $module = 'moduleCreator';

    /**
     * 
     * @global type $en
     */
    function loadCreateView() {
        global $en;
        $form = parent::openForm($this->module);
        $data = (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) ? parent::getData($_REQUEST['id'], $this->module) : array();
        $form .= '	    
                    <div class="form-group">
                          <label for="name">' . $en['labels']['common']['name'] . '<sup>*</sup></label>
                          <input type="text" class="form-control" id="name"  name="name" value="' . (isset($data[0]['name']) ? $data[0]['name'] : '') . '" required />                          
                    </div>';
        $form .= parent::closeForm($this->module);
        echo $form;
    }

}

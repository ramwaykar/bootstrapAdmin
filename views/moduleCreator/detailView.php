<?php

global $docRoot;
include_once $docRoot . 'commonFiles/views/detail.php';

class ModuleCreatorDetailView extends DetailView {

    var $errors = array();

    /**
     * 
     * @param type $module
     */
    function loadDetailView($module) {
        $data = parent::getData($module);
        $details = parent::getDetails($module, $data);
        $details .= $this->getHtml($module, $data);
        $details .= $this->closeForm($module, $data);
        echo $details;
    }

    /**
     * 
     * @global type $en
     * @param type $module
     * @param type $data
     * @return string
     */
    function getHtml($module, $data) {
        global $en;
        $checked = (isset($data[0]['isAdmin']) && $data[0]['isAdmin'] == 1) ? 'checked="checked"' : '';
        $html = '<div class="col-md-6">
                    <label for="name">' . $en['labels']['common']['name'] . '</label>
                    <input disabled type="text" class="form-control" id="name"  name="name" value="' . (isset($data[0]['name']) ? $data[0]['name'] : '') . '" />                          
              </div>
              <div class="col-md-6">
                    <label for="status">' . $en['labels']['common']['status'] . '</label>
                    <select disabled id="status" name="status" class="form-control">
                    ' . getStaticDropDownOptions('status', '' . (isset($data[0]['status']) ? $data[0]['status'] : '') . '', FALSE) . '
                    </select>
              </div>';
        return $html;
    }

}

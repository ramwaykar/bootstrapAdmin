<?php

global $docRoot;
include_once $docRoot . 'commonFiles/views/detail.php';
include_once $docRoot . 'controllers/accessBO.php';

class AccessDetailView extends DetailView {

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
        $html = '<div class="col-md-6">
                    <label for="module">' . $en['labels']['common']['module'] . '</label>
                    <input disabled type="text" class="form-control" id="module"  name="module" value="' . (isset($data[0]['module']) ? $data[0]['module'] : '') . '" />                          
              </div>
              <div class="col-md-6">
                    <label for="securityGroupId">' . $en['labels']['securityGroup']['securityGroup'] . '</label>
                    <select disabled id="securityGroupId" name="securityGroupId" class="form-control">
                    ' . getDropDownOptions('securityGroup', '' . (isset($data[0]['securityGroupId']) ? $data[0]['securityGroupId'] : '') . '') . '
                    </select>
              </div>
              <div class="col-md-6">
                    <label for="access">' . $en['labels']['access']['access'] . '</label>
                    <select disabled id="access" name="access" class="form-control">
                    ' . getStaticDropDownOptions('access', '' . (isset($data[0]['access']) ? $data[0]['access'] : '1') . '', FALSE) . '
                    </select>
              </div>';
        return $html;
    }

}

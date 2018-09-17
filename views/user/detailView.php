<?php

global $docRoot;
include_once $docRoot . 'commonFiles/views/detail.php';

class UserDetailView extends DetailView {

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
                    <label for="fName">' . $en['labels']['user']['firstName'] . '</label>
                    <input disabled type="text" class="form-control" id="fName"  name="fName" value="' . (isset($data[0]['fName']) ? $data[0]['fName'] : '') . '" />                          
              </div>
              <div class="col-md-6">
                    <label for="lName">' . $en['labels']['user']['lastName'] . '</label>
                    <input disabled type="text" class="form-control" id="lName"  name="lName" value="' . (isset($data[0]['lName']) ? $data[0]['lName'] : '') . '" />                          
              </div>
              <div class="col-md-6">
                    <label for="username">' . $en['labels']['user']['username'] . '</label>
                    <input disabled type="text" class="form-control" id="username"  name="username"  value="' . (isset($data[0]['username']) ? $data[0]['username'] : '') . '"/>                          
              </div>
              <div class="col-md-6">
                    <label for="email">' . $en['labels']['user']['email'] . '</label>
                    <input disabled type="email" class="form-control" id="email"  name="email" value="' . (isset($data[0]['email']) ? $data[0]['email'] : '') . '" />
              </div>
              <div class="col-md-6">
                    <label for="phone">' . $en['labels']['user']['phone'] . '</label>
                    <input disabled type="number" class="form-control" id="phone"  name="phone" value="' . (isset($data[0]['phone']) ? $data[0]['phone'] : '') . '" />
              </div>
              <div class="col-md-6">
                    <label for="securityGroupId">' . $en['labels']['securityGroup']['securityGroup'] . '</label>
                    <select disabled id="securityGroupId" name="securityGroupId" class="form-control">
                    ' . getDropDownOptions('securityGroup', '' . (isset($data[0]['securityGroupId']) ? $data[0]['securityGroupId'] : '') . '') . '
                    </select>
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

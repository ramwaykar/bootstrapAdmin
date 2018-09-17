<?php

global $docRoot;
include_once $docRoot . 'commonFiles/views/create.php';

class UserCreateView extends CreateView {

    var $errors = array();
    var $module = 'user';

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
                          <label for="fName">'.$en['labels']['user']['firstName'].'<sup>*</sup></label>
                          <input type="text" class="form-control" id="fName"  name="fName" value="' . (isset($data[0]['fName']) ? $data[0]['fName'] : '') . '" required />                          
                    </div>
                    <div class="form-group">
                          <label for="lName">'.$en['labels']['user']['lastName'].'<sup>*</sup></label>
                          <input type="text" class="form-control" id="lName"  name="lName" value="' . (isset($data[0]['lName']) ? $data[0]['lName'] : '') . '" required />                          
                    </div>              
                    
                    ';
        if (!isset($_REQUEST['id']) || (isset($_REQUEST['id']) && empty($_REQUEST['id']))) {
            $form .= '<div class="form-group">
                          <label for="username">'.$en['labels']['user']['username'].'<sup>*</sup></label>
                          <input type="text" class="form-control" id="username"  name="username" required />                          
                    </div>
                    <div class="form-group">
                          <label for="password">'.$en['labels']['user']['password'].'<sup>*</sup></label>
                          <input type="password" class="form-control" id="password"  name="password" required />
                    </div>
                    <div class="form-group">
                          <label for="cnfpwd">'.$en['labels']['user']['confirmPassword'].'<sup>*</sup></label>
                          <input type="password" class="form-control" id="cnfpwd"  name="cnfpwd" required />
                    </div>';
        }

        $form .= '<div class="form-group">
                        <label for="email">'.$en['labels']['user']['email'].'<sup>*</sup></label>
                        <input type="email" class="form-control" id="email"  name="email" value="' . (isset($data[0]['email']) ? $data[0]['email'] : '') . '" required />
                  </div>
                  <div class="form-group">
                        <label for="phone">'.$en['labels']['user']['phone'].'<sup>*</sup></label>
                        <input type="number" class="form-control" id="phone"  name="phone" value="' . (isset($data[0]['phone']) ? $data[0]['phone'] : '') . '" required />
                  </div>
                  <div class="form-group">
                        <label for="securityGroupId">'.$en['labels']['securityGroup']['securityGroup'].'<sup>*</sup></label>
                        <select id="securityGroupId" name="securityGroupId" class="form-control" required>
                        ' . getDropDownOptions('securityGroup', '' . (isset($data[0]['securityGroupId']) ? $data[0]['securityGroupId'] : '') . '') . '
                        </select>
                  </div>';
        $form .= parent::closeForm($this->module);
        echo $form;
    }

}

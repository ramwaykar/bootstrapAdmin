<?php

global $docRoot;
include_once $docRoot . 'commonFiles/views/search.php';

class UserSearchView extends SearchView {

    var $errors = array();
    var $module = 'user';

    /**
     * 
     * @global type $en
     */
    function loadSearchView() {
        global $en;
        $form = parent::openForm($this->module);
        $form .= '	    
                    <div class="col-md-6">
                          <label for="fName">' . $en['labels']['user']['firstName'] . '</label>
                          <input type="text" class="form-control" id="fName"  name="fName" required />                          
                    </div>
                    <div class="col-md-6">
                          <label for="lName">' . $en['labels']['user']['lastName'] . '</label>
                          <input type="text" class="form-control" id="lName"  name="lName" required />                          
                    </div>  
                    <div class="col-md-6">
                          <label for="username">' . $en['labels']['user']['username'] . '</label>
                          <input type="text" class="form-control" id="username"  name="username" required />                          
                    </div>
                    <div class="col-md-6">
                        <label for="email">' . $en['labels']['user']['email'] . '</label>
                        <input type="email" class="form-control" id="email"  name="email" required />
                    </div>
                    <div class="col-md-6">
                          <label for="phone">' . $en['labels']['user']['phone'] . '</label>
                          <input type="number" class="form-control" id="phone"  name="phone" required />
                    </div>
                    <div class="col-md-6">
                          <label for="securityGroupId">' . $en['labels']['securityGroup']['securityGroup'] . '</label>
                          <select id="securityGroupId" name="securityGroupId" class="form-control" required>
                          ' . getDropDownOptions('securityGroup') . '
                          </select>
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

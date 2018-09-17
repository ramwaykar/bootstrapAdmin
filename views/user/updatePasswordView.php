<?php

global $docRoot;
include_once $docRoot . 'commonFiles/views/create.php';

class UserUpdatePasswordView extends CreateView {

    var $errors = array();
    var $module = 'user';

    /**
     * 
     * @global type $en
     */
    function loadCreateView() {
        global $en;
        $form = parent::openForm($this->module, 'changePassword');
        $form .= '
                    <div class="form-group">
                          <label for="password">' . $en['labels']['user']['password'] . '<sup>*</sup></label>
                          <input type="password" class="form-control" id="password"  name="password" required />
                    </div>
                    <div class="form-group">
                          <label for="cnfpwd">' . $en['labels']['user']['confirmPassword'] . '<sup>*</sup></label>
                          <input type="password" class="form-control" id="cnfpwd"  name="cnfpwd" required />
                    </div>';
        $form .= parent::closeForm($this->module);
        echo $form;
    }

}

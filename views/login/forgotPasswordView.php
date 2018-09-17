<?php

class LoginForgotPasswordView {

    var $errors = array();

    /**
     * 
     * @global type $en
     * @global type $siteRoot
     * @param type $module
     */
    function loadForgotPasswordView($module) {
        global $en, $siteRoot;
        echo '	<div class="container form_container">
                    <div class="container login_form">                        
                        <div class="row">
                            <form method="post" id="edit-form" role="form" data-toggle="validator" class="" action="">
                                <input type="hidden" name="action" value="forgotPwd">
                                <input type="hidden" name="module" value="login">
                                <div class="col-md-12">
                                    <div class="form-group">
                                          <label for="username">' . $en['labels']['user']['username'] . '<sup>*</sup></label>
                                          <input type="text" class="form-control" id="username"  name="username" required />                                      
                                    </div>
                                    <div class="form-group">
                                          <label for="password">' . $en['labels']['user']['password'] . '<sup>*</sup></label>
                                          <input type="password" class="form-control" id="password"  name="password" required />
                                    </div>                                              
                                    <div class="form-group">
                                          <label for="cnfpwd">' . $en['labels']['user']['confirmPassword'] . '<sup>*</sup></label>
                                          <input type="password" class="form-control" id="cnfpwd"  name="cnfpwd" required />
                                    </div>      
                                    <input type="button" class="btn btn-default  btn-primary" value="' . $en['labels']['common']['submit'] . '" id="submit-form" />                                                                          
                                    <a href="' . $siteRoot . 'views/' . $module . '" class="">
                                        <input type="button" class="btn btn-default  btn-primary cancel-submit-form" value="' . $en['labels']['common']['cancel'] . '" />
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
        </div>';
    }

}

?>
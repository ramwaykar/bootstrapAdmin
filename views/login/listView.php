<?php

class LoginListView {

    var $errors = array();

    /**
     * 
     * @global type $en
     * @global type $siteRoot
     * @param type $module
     */
    function loadListView($module) {
        global $en, $siteRoot;
        echo '	<div class="container form_container">
                    <div class="container login_form">
                        <div class="">
                            <h4>' . $en['labels']['login']['welcome'] . '</h4>
                        </div>
                        <div class="row">
                            <form method="post" id="edit-form" role="form" data-toggle="validator" class="" action="">
                                <input type="hidden" name="action" value="save">
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
                                    <input type="button" class="btn btn-default  btn-primary" value="' . $en['labels']['login']['login'] . '" id="submit-form" />                                
                                    <a href="' . $siteRoot . 'views/login?action=forgotPassword">
                                        <input type="button" class="btn btn-default  btn-primary" value="' . $en['labels']['login']['forgotPassword'] . '"  />                                
                                    </a>       
                                </div>
                            </form>
                        </div>
                    </div>
        </div>';
    }

}

?>
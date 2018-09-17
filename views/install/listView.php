<?php

class InstallListView {

    var $errors = array();

    /**
     * 
     * @global type $en
     * @param type $module
     */
    function loadListView($module) {
        global $en;
        echo '	<div class="container form_container">
                    <div class="container installation_form">
                        <div>
                                <h4>'.$en['labels']['install']['welcome'].'</h4>
                        </div>
                        <div class="row">
                            <form method="post" id="edit-form" role="form" data-toggle="validator" class="" action="">
                                <input type="hidden" name="action" value="save">
                                <input type="hidden" name="module" value="install">
                                <div class="col-md-6">
                                    <div class="form-group">
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
                                    </div>
                                    <div class="form-group">
                                          <label for="email">'.$en['labels']['user']['email'].'<sup>*</sup></label>
                                          <input type="email" class="form-control" id="email"  name="email" required />
                                    </div>
                                    <div class="form-group">
                                          <label for="phone">'.$en['labels']['user']['phone'].'<sup>*</sup></label>
                                          <input type="number" class="form-control" id="phone"  name="phone" required />
                                    </div>
                                    <input type="button" class="btn btn-default  btn-primary" value="'.$en['labels']['install']['install'].'" id="submit-form" />
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                          <label for="dbType">'.$en['labels']['install']['database'].'<sup>*</sup></label>
                                          <select id="dbType" name="dbType" class="form-control" required>
                                            <option value="mysql">MySQL</option>
                                          </select>
                                    </div>
                                    <div class="form-group">
                                          <label for="dbHost">'.$en['labels']['install']['host'].'<sup>*</sup></label>
                                          <input type="text" class="form-control" id="dbHost"  name="dbHost" required />
                                    </div>
                                    <div class="form-group">
                                          <label for="dbName">'.$en['labels']['install']['dbName'].'<sup>*</sup></label>
                                          <input type="text" class="form-control" id="dbName"  name="dbName" required />
                                    </div>
                                    <div class="form-group">
                                          <label for="dbUser">'.$en['labels']['install']['dbUsername'].'<sup>*</sup></label>
                                          <input type="text" class="form-control" id="dbUser"  name="dbUser" required />
                                    </div>
                                    <div class="form-group">
                                          <label for="dbPassword">'.$en['labels']['install']['dbPassword'].'<sup>*</sup></label>
                                          <input type="password" class="form-control" id="dbPassword" name="dbPassword" />
                                    </div>									  
                                </div>
                            </form>
                        </div>
                    </div>
        </div>';
    }

}


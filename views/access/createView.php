<?php

global $docRoot;
include_once $docRoot . 'commonFiles/views/create.php';
include_once $docRoot . 'controllers/accessBO.php';

class AccessCreateView extends CreateView {

    var $errors = array();
    var $module = 'access';

    /**
     * 
     * @global type $en
     */
    function loadCreateView() {
        global $en;
        $form = parent::openForm($this->module);
        $data = (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) ? parent::getData($_REQUEST['id'], $this->module) : array();
        $disable = (!empty($_REQUEST['id'])) ? 'disabled' : '';
        $form .= '	    
                    <div class="form-group">
                          <label for="cmodule">' . $en['labels']['common']['module'] . '<sup>*</sup></label>
                          <input '.$disable.' type="text" class="form-control" id="cmodule"  name="cmodule" value="' . (isset($data[0]['module']) ? $data[0]['module'] : '') . '" required />                          
                    </div>
                    <div class="form-group">
                        <label for="securityGroupId">' . $en['labels']['securityGroup']['securityGroup'] . '<sup>*</sup></label>
                        <select '.$disable.'  id="securityGroupId" name="securityGroupId" class="form-control" required>
                        ' . getDropDownOptions('securityGroup', '' . (isset($data[0]['securityGroupId']) ? $data[0]['securityGroupId'] : '') . '') . '
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="access">' . $en['labels']['access']['access'] . '</label>
                        <select id="access" name="access" class="form-control">
                            ' . getStaticDropDownOptions('access', '' . (isset($data[0]['access']) ? $data[0]['access'] : 1) . '', FALSE) . '
                        </select>
                    </div>';
        $form .= parent::closeForm($this->module);
        echo $form;
    }

}

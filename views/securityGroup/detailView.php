<?php

global $docRoot;
include_once $docRoot . 'commonFiles/views/detail.php';
include_once $docRoot . 'controllers/accessBO.php';

class SecurityGroupDetailView extends DetailView {

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
        $details .= $this->getAccessDetails($data[0]['id']);
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
                          <label for="isAdmin">' . $en['labels']['securityGroup']['isAdmin'] . '</label>
                          <input disabled ' . $checked . ' type="checkbox" class="form-control" id="isAdmin"  name="isAdmin" value="' . (isset($data[0]['isAdmin']) ? $data[0]['isAdmin'] : '') . '" />                          
                    </div>
              <div class="col-md-6">
                    <label for="status">' . $en['labels']['common']['status'] . '</label>
                    <select disabled id="status" name="status" class="form-control">
                    ' . getStaticDropDownOptions('status', '' . (isset($data[0]['status']) ? $data[0]['status'] : '') . '', FALSE) . '
                    </select>
              </div>';
        return $html;
    }

    /**
     * 
     * @global type $en
     * @param type $id
     * @return string
     */
    function getAccessDetails($id) {
        global $en;
        $access = new AccessBO();
        $query = array(
            'securityGroupId' => array(
                'operator' => 'eq',
                'value' => $id,
            ),
        );
        $accessData = $access->get($query, array('module', 'access'));
        $details = '<div class="container">                        
                            <div class="container accessDetailsHeading">
                                    <h4>'.$en['labels']['common']['accessDetails'].'</h4>
                            </div>
                            <div class="container detailsForm">
                                <div class="row">';
        foreach ($accessData as $key => $row) {
            $details .= '<div class="col-md-6">
                            <label for="name">' . $en['labels'][$row['module']][$row['module']] . '</label>
                            <select disabled id="access" name="access[]" class="form-control">
                                ' . getStaticDropDownOptions('access', '' . $row['access'] . '', FALSE) . '
                            </select>
                        </div>';
        }
        $details .= '</div></div></div>';
        return $details;
    }

}

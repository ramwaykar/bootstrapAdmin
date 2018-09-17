<?php

global $docRoot;
include_once $docRoot . 'commonFiles/views/detail.php';
include_once $docRoot . 'controllers/accessBO.php';

class LoggerDetailView extends DetailView {

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
                    <label for="tableName">' . $en['labels']['logger']['table'] . '</label>
                    <input disabled type="text" class="form-control" id="tableName"  name="tableName" value="' . (isset($data[0]['tableName']) ? $data[0]['tableName'] : '') . '" />                          
              </div>
              <div class="col-md-6">
                    <label for="recordId">' . $en['labels']['logger']['recordId'] . '</label>
                    <input disabled type="text" class="form-control" id="recordId"  name="recordId" value="' . (isset($data[0]['recordId']) ? $data[0]['recordId'] : '') . '" />                          
              </div>
              <div class="col-md-6">
                    <label for="operation">' . $en['labels']['logger']['operation'] . '</label>
                    <select disabled id="operation" name="operation" class="form-control">
                    ' . getStaticDropDownOptions('operation', '' . (isset($data[0]['operation']) ? $data[0]['operation'] : '1') . '', FALSE) . '
                    </select>
              </div>';
        return $html;
    }

}

<?php

global $docRoot;
include_once($docRoot . 'db/dbUtil.php');

class ModuleCreator extends DBUtil {

    var $table = 'sp_module_creator';

    /**
     * 
     * @return type
     */
    protected function tableDef() {
        return array('id', 'name', 'status');
    }

    /**
     * 
     * @param type $query
     * @param string $fields
     * @param type $rel
     * @return type
     */
    protected function getModuleCreatorMod($query, $fields = array(), $rel = array()) {
        if (empty($fields)) {
            $fields = array($this->table . '.*');
        }
        return parent::getData($this->table, $query, $fields, $rel);
    }

    /**
     * 
     * @global type $en
     * @param type $data
     * @return type
     */
    protected function saveModuleCreatorMod($data) {
        global $en;
        $query['name'] = array('operator' => 'eq', 'value' => $data['name'],);
        if (isset($data['id']) && !empty($data['id'])) {
            $query['id'] = array('operator' => 'ne', 'value' => $data['id'],);
        }
        $secGrp = $this->getModuleCreatorMod($query);
        if (!empty($secGrp)) {
            return array('errors' => array('name' => $en['errors']['moduleCreator']['exist']));
        }

        $res = parent::saveData($this->table, $data);
        if ($res) {            
            $this->createFiles($data['name']);
            parent::createModuleTable($data['name']);
        }
        return true;
    }

    /**
     * 
     * @param type $newModuleName
     */
    private function createFiles($newModuleName) {
        $this->createViewFiles($newModuleName);
        $this->createJsFiles($newModuleName);
        $this->createServerSideValidationFile($newModuleName);
        $this->createModelFile($newModuleName);
        $this->createControlerFile($newModuleName);
    }

    /**
     * 
     * @global type $docRoot
     * @param type $newModuleName
     */
    private function createViewFiles($newModuleName) {
        global $docRoot;
        mkdir($docRoot . "views/" . $newModuleName, 0777) or die("Unable to create directory!");
        $this->createIndexFile($docRoot . "views/" . $newModuleName, $newModuleName);
        $this->createModConfFile($docRoot . "views/" . $newModuleName, $newModuleName);
        $this->createListViewFile($docRoot . "views/" . $newModuleName, $newModuleName);
        $this->createSearchViewFile($docRoot . "views/" . $newModuleName, $newModuleName);
        $this->createCreateViewFile($docRoot . "views/" . $newModuleName, $newModuleName);
        $this->createDetailsViewFile($docRoot . "views/" . $newModuleName, $newModuleName);
    }

    /**
     * 
     * @param type $path
     * @param type $newModuleName
     */
    private function createIndexFile($path, $newModuleName) {
        $myfile = fopen($path . "/index.php", "w") or die("Unable to open file!");
        $txt = "<?php\n\n";
        $txt .= "\tinclude_once('../../commonFiles/conf.php');\n";
        $txt .= "\t".'global $docRoot;'."\n";
        $txt .= "\t".'include_once $docRoot . "commonFiles/superRoute.php";'."\n";
        $txt .= "\t".'$app = new SuperRoute();'."\n";
        $txt .= "\t".'$action = (isset($_REQUEST["action"]) && !empty($_REQUEST["action"])) ? $_REQUEST["action"] : "list";'."\n";
        $txt .= "\t".'$app->startExecution("' . $newModuleName . '", $action);'."\n";
        fwrite($myfile, $txt);
        fclose($myfile);
    }

    /**
     * 
     * @param type $path
     * @param type $newModuleName
     */
    private function createModConfFile($path, $newModuleName) {
        $myfile = fopen($path . "/modConf.php", "w") or die("Unable to open file!");
        $txt = "<?php\n\n";
        $txt .= "\tclass " . ucfirst($newModuleName) . "ModConf {\n";
        $txt .= "\t\tfunction getModConf() {\n";
        $txt .= "\t\t\t".'global $en;'."\n";
        $txt .= "\t\t\t".'return array('."\n";
        $txt .= "\t\t\t\t".'\'listHeadins\' => array('."\n";
        $txt .= "\t\t\t\t\t".'$en["labels"]["common"]["module"],'."\n";
        $txt .= "\t\t\t\t\t".'$en["labels"]["common"]["status"],'."\n";
        $txt .= "\t\t\t\t\t".'$en["labels"]["common"]["createdBy"],'."\n";
        $txt .= "\t\t\t\t\t".'$en["labels"]["common"]["updatedBy"],'."\n";
        $txt .= "\t\t\t\t\t".'$en["labels"]["common"]["createdAt"],'."\n";
        $txt .= "\t\t\t\t\t".'$en["labels"]["common"]["updatedAt"],'."\n";
        $txt .= "\t\t\t\t\t".'\'\''."\n";
        $txt .= "\t\t\t\t),\n";
        $txt .= "\t\t\t\t'listDisplayFields' => array(\n";
        $txt .= "\t\t\t\t\t'name', 'status', 'createdBy', 'updatedBy', 'createdAt', 'updatedAt'\n";
        $txt .= "\t\t\t\t),\n";
        $txt .= "\t\t\t\t'listSelectFields' => array(\n";
        $txt .= "\t\t\t\t\t'id as DT_RowId', 'name', 'status', 'createdBy as CB', 'updatedBy as UB', 'createdAt', 'updatedAt'\n";
        $txt .= "\t\t\t\t),\n";
        $txt .= "\t\t\t\t'searchFields' => array(\n";
        $txt .= "\t\t\t\t\tarray('fieldName' => 'name')\n";
        $txt .= "\t\t\t\t),\n";
        $txt .= "\t\t\t);\n";
        $txt .= "\t\t}\n\n";
        $txt .= "\t}";
        fwrite($myfile, $txt);
        fclose($myfile);
    }

    /**
     * 
     * @param type $path
     * @param type $newModuleName
     */
    private function createListViewFile($path, $newModuleName) {
        $myfile = fopen($path . "/listView.php", "w") or die("Unable to open file!");
        $txt = "<?php\n\n";
        $txt .= "\t".'global $docRoot;'."\n";
        $txt .= "\t".'include_once $docRoot . "commonFiles/views/list.php";'."\n\n";
        $txt .= "\tclass " . ucfirst($newModuleName) . "ListView extends ListView {\n";
        $txt .= "\t\t".'var $errors = array();'."\n";
        $txt .= "\t\t".'function loadListView($module) {'."\n";
        $txt .= "\t\t\t".'parent::getData($module);'."\n";
        $txt .= "\t\t}\n\n";
        $txt .= "\t}";
        fwrite($myfile, $txt);
        fclose($myfile);
    }

    /**
     * 
     * @param type $path
     * @param type $newModuleName
     */
    private function createSearchViewFile($path, $newModuleName) {
        $myfile = fopen($path . "/searchView.php", "w") or die("Unable to open file!");
        $txt = "<?php\n\n";
        $txt .= "\t".'global $docRoot;'."\n";
        $txt .= "\t".'include_once $docRoot . "commonFiles/views/search.php";'."\n\n";
        $txt .= "\tclass " . ucfirst($newModuleName) . "SearchView extends SearchView {\n";
        $txt .= "\t\t".'var $errors = array();'."\n";
        $txt .= "\t\t".'var $module = "' . $newModuleName . '";'."\n";
        $txt .= "\t\t".'function loadSearchView() {'."\n";
        $txt .= "\t\t\t".'global $en;'."\n";
        $txt .= "\t\t\t".'$form = parent::openForm($this->module);'."\n";
        $txt .= "\t\t\t".'$form .= \''."\n";
        $txt .= "\t\t\t\t".'<div class="col-md-6">'."\n";
        $txt .= "\t\t\t\t\t".'<label for="name">\' . $en[\'labels\'][\'common\'][\'name\'] . \'</label>'."\n";
        $txt .= "\t\t\t\t\t".'<input type="text" class="form-control" id="name"  name="name" />'."\n";
        $txt .= "\t\t\t\t".'</div>\';'."\n";
        $txt .= "\t\t\t\t\t".'$form .= parent::closeForm($this->module);'."\n";
        $txt .= "\t\t\t\t\t".'echo $form;'."\n";
        $txt .= "\t\t}\n\n";
        $txt .= "\t}";
        fwrite($myfile, $txt);
        fclose($myfile);
    }

    /**
     * 
     * @param type $path
     * @param type $newModuleName
     */
    private function createCreateViewFile($path, $newModuleName) {
        $myfile = fopen($path . "/createView.php", "w") or die("Unable to open file!");
        $txt = "<?php\n\n";
        $txt .= "\t".'global $docRoot;'."\n";
        $txt .= "\t".'include_once $docRoot . "commonFiles/views/create.php";'."\n\n";
        $txt .= "\tclass " . ucfirst($newModuleName) . "CreateView extends CreateView {\n";
        $txt .= "\t\t".'var $errors = array();'."\n";
        $txt .= "\t\t".'var $module = "' . $newModuleName . '";'."\n";
        $txt .= "\t\t".'function loadCreateView() {'."\n";
        $txt .= "\t\t\t".'global $en;'."\n";
        $txt .= "\t\t\t".'$data = (isset($_REQUEST["id"]) && !empty($_REQUEST["id"])) ? parent::getData($_REQUEST["id"], $this->module) : array();'."\n";
        $txt .= "\t\t\t".'$form = parent::openForm($this->module);'."\n";
        $txt .= "\t\t\t".'$form .= \''."\n";
        $txt .= "\t\t\t\t".'<div class="form-group">'."\n";
        $txt .= "\t\t\t\t\t".'<label for="name">\' . $en[\'labels\'][\'common\'][\'name\'] . \'<sup>*</sup></label>'."\n";
        $txt .= "\t\t\t\t\t".'<input type="text" class="form-control" id="name"  name="name"  value="\' . (isset($data[0][\'name\']) ? $data[0][\'name\'] : \'\') . \'" required />'."\n";
        $txt .= "\t\t\t\t".'</div>\';'."\n";
        $txt .= "\t\t\t\t\t".'$form .= parent::closeForm($this->module);'."\n";
        $txt .= "\t\t\t\t\t".'echo $form;'."\n";
        $txt .= "\t\t}\n\n";
        $txt .= "\t}";
        fwrite($myfile, $txt);
        fclose($myfile);
    }

    /**
     * 
     * @param type $path
     * @param type $newModuleName
     */
    private function createDetailsViewFile($path, $newModuleName) {
        $myfile = fopen($path . "/detailView.php", "w") or die("Unable to open file!");
        $txt = "<?php\n\n";
        $txt .= "\t".'global $docRoot;'."\n";
        $txt .= "\t".'include_once $docRoot . "commonFiles/views/detail.php";'."\n\n";
        $txt .= "\tclass " . ucfirst($newModuleName) . "DetailView extends DetailView {\n";
        $txt .= "\t\t".'var $errors = array();'."\n";
        $txt .= "\t\t".'function loadDetailView($module) {'."\n";
        $txt .= "\t\t\t".'$data = parent::getData($module);'."\n";
        $txt .= "\t\t\t".'$details = parent::getDetails($module, $data);'."\n";
        $txt .= "\t\t\t".'$details .= $this->getHtml($module, $data);'."\n";
        $txt .= "\t\t\t".'$details .= $this->closeForm($module, $data);  '."\n";
        $txt .= "\t\t\t".'echo $details;'."\n";
        $txt .= "\t\t}\n\n";
        $txt .= "\t\t".'function getHtml($module, $data) {'."\n";
        $txt .= "\t\t\t".'global $en;'."\n";
        $txt .= "\t\t\t".'$html = \''."\n";
        $txt .= "\t\t\t\t".'<div class="col-md-6">'."\n";
        $txt .= "\t\t\t\t\t".'<label for="name">\' . $en[\'labels\'][\'common\'][\'name\'] . \'<sup>*</sup></label>'."\n";
        $txt .= "\t\t\t\t\t".'<input disabled type="text" class="form-control" id="name"  name="name"  value="\' . (isset($data[0][\'name\']) ? $data[0][\'name\'] : \'\') . \'" />'."\n";
        $txt .= "\t\t\t\t".'</div>\';'."\n";
        $txt .= "\t\t\t\t\t".'return $html;'."\n";
        $txt .= "\t\t}\n\n";
        $txt .= "\t}";
        fwrite($myfile, $txt);
        fclose($myfile);
    }

    /**
     * 
     * @global type $docRoot
     * @param type $newModuleName
     */
    private function createJsFiles($newModuleName) {
        global $docRoot;
        $myfile = fopen($docRoot . "static/js/" . $newModuleName . ".js", "w") or die("Unable to open file!");
        $txt = "validation = {\n";
        $txt .= "\t".'addValidation: function () {'."\n";
        $txt .= "\t\t".'var fieldsToValidate = {'."\n";
        $txt .= "\t\t\t".'name: {validators: {notEmpty: {}, }},'."\n";
        $txt .= "\t\t".'};'."\n";
        $txt .= "\t\t".'$("#edit-form").bootstrapValidator({'."\n";
        $txt .= "\t\t\t".'fields: fieldsToValidate'."\n";
        $txt .= "\t\t".'});'."\n";
        $txt .= "\t".'}'."\n";
        $txt .= '}'."\n\n";
        $txt .= '$(document).ready(function () {'."\n";
        $txt .= "\t".'var action = $("input[name=\"action\"]").val();'."\n";
        $txt .= "\t".'switch (action) {'."\n";
        $txt .= "\t\t".'case "save": validation.addValidation();'."\n";
        $txt .= "\t\t".'break;'."\n";
        $txt .= "\t\t".'case "remove": break;'."\n";
        $txt .= "\t\t".'default: common.getListviewData();'."\n";
        $txt .= "\t".'}'."\n";
        $txt .= '});'."\n";
        fwrite($myfile, $txt);
        fclose($myfile);
    }

    /**
     * 
     * @global type $docRoot
     * @param type $newModuleName
     */
    private function createServerSideValidationFile($newModuleName) {
        global $docRoot;
        $myfile = fopen($docRoot . "validations/validate" . ucfirst($newModuleName) . ".php", "w") or die("Unable to open file!");
        $txt = "<?php\n\n";
        $txt .= "\tclass Validate" . ucfirst($newModuleName) . " {\n";
        $txt .= "\t\t".'function validate($data) {'."\n";
        $txt .= "\t\t\t".'$errors = array();'."\n";
        $txt .= "\t\t\t".'if (!isset($data["name"]) || empty($data["name"])) {'."\n";
        $txt .= "\t\t\t\t".'$errors["name"] = "";'."\n";
        $txt .= "\t\t\t".'}'."\n";
        $txt .= "\t\t\t".'return $errors;'."\n";
        $txt .= "\t\t}\n\n";
        $txt .= "\t}";
        fwrite($myfile, $txt);
        fclose($myfile);
    }

    /**
     * 
     * @global type $docRoot
     * @param type $newModuleName
     */
    private function createModelFile($newModuleName) {
        global $docRoot;
        $myfile = fopen($docRoot . "models/" . $newModuleName . ".php", "w") or die("Unable to open file!");
        $txt = "<?php\n\n";
        $txt .= "\t".'global $docRoot;'."\n";
        $txt .= "\t".'include_once($docRoot . "db/dbUtil.php");'."\n\n";
        $txt .= "\tclass " . ucfirst($newModuleName) . " extends DBUtil {\n";
        $txt .= "\t\t".'var $table = "sp_' . $newModuleName . '";'."\n";
        $txt .= "\t\t".'protected function tableDef() {'."\n";
        $txt .= "\t\t\t".'return array("id", "name", "status");'."\n";
        $txt .= "\t\t}\n\n";
        $txt .= "\t\t".'protected function get' . ucfirst($newModuleName) . 'Mod($query, $fields = array(), $rel = array()) {'."\n";
        $txt .= "\t\t\t".'if (empty($fields)) {'."\n";
        $txt .= "\t\t\t\t".'$fields = array($this->table . ".*");'."\n";
        $txt .= "\t\t\t".'}'."\n";
        $txt .= "\t\t\t".'return parent::getData($this->table, $query, $fields, $rel);'."\n";
        $txt .= "\t\t}\n\n";
        $txt .= "\t\t".'protected function save' . ucfirst($newModuleName) . 'Mod($data) {'."\n";
        $txt .= "\t\t\t".'return parent::saveData($this->table, $data);'."\n";
        $txt .= "\t\t}\n\n";
        $txt .= "\t\t".'protected function updateStatus' . ucfirst($newModuleName) . 'Mod($data) {'."\n";
        $txt .= "\t\t\t".'return parent::updateStatus($this->table, $data);'."\n";
        $txt .= "\t\t}\n\n";
        $txt .= "\t\t".'protected function remove' . ucfirst($newModuleName) . 'Mod($data) {'."\n";
        $txt .= "\t\t\t".'return parent::removeRecord($this->table, $data);'."\n";
        $txt .= "\t\t}\n\n";
        $txt .= "\t}";
        fwrite($myfile, $txt);
        fclose($myfile);
    }

    /**
     * 
     * @global type $docRoot
     * @param type $newModuleName
     */
    private function createControlerFile($newModuleName) {
        global $docRoot;
        $myfile = fopen($docRoot . "controllers/" . $newModuleName . "BO.php", "w") or die("Unable to open file!");
        $txt = "<?php\n\n";
        $txt .= "\t".'global $docRoot;'."\n";
        $txt .= "\t".'include_once($docRoot . "models/' . $newModuleName . '.php");'."\n";
        $txt .= "\t".'include_once($docRoot . "views/' . $newModuleName . '/modConf.php");'."\n";
        $txt .= "\t".'include_once($docRoot . "validations/validate' . ucfirst($newModuleName) . '.php");'."\n\n";
        $txt .= "\tclass " . ucfirst($newModuleName) . "BO extends " . ucfirst($newModuleName) . " {\n";
        $txt .= "\t\t".'function get($query = array(), $fields = array(), $rel = array()) {'."\n";
        $txt .= "\t\t\t".'if (isset($_REQUEST["action"]) && ($_REQUEST["action"] === "getListData" || $_REQUEST["action"] === "search")) {'."\n";
        $txt .= "\t\t\t\t".'$modConfObj = new ' . ucfirst($newModuleName) . 'ModConf();'."\n";
        $txt .= "\t\t\t\t".'$modConf = $modConfObj->getModConf();'."\n";
        $txt .= "\t\t\t\t".'if (isset($modConf["listSelectFields"]) && !empty($modConf["listSelectFields"])) {'."\n";
        $txt .= "\t\t\t\t\t".'$fields = $modConf["listSelectFields"];'."\n";
        $txt .= "\t\t\t\t".'}'."\n";
        $txt .= "\t\t\t\t".'if (isset($_REQUEST["columns"]) && isset($modConf["listDisplayFields"]) && !empty($modConf["listDisplayFields"])) {'."\n";
        $txt .= "\t\t\t\t\t".'foreach ($modConf["listDisplayFields"] as $key => $val) {'."\n";
        $txt .= "\t\t\t\t\t\t".'$_REQUEST["columns"][$key]["name"] = $val;'."\n";
        $txt .= "\t\t\t\t\t".'}'."\n";
        $txt .= "\t\t\t\t".'}'."\n";
        $txt .= "\t\t\t".'}'."\n";
        $txt .= "\t\t\t".'$res = parent::get' . ucfirst($newModuleName) . 'Mod($query, $fields, $rel);'."\n";
        $txt .= "\t\t\t".'return $res;'."\n";
        $txt .= "\t\t}\n\n";
        $txt .= "\t\tfunction updateStatus() {\n";
        $txt .= "\t\t\t".'$data["status"] = ($_REQUEST["status"] == 1) ? 0 : 1;'."\n";
        $txt .= "\t\t\t".'$$data["id"] = $_REQUEST["id"];'."\n";
        $txt .= "\t\t\t".'return parent::updateStatus' . ucfirst($newModuleName) . 'Mod($data);'."\n";
        $txt .= "\t\t}\n\n";
        $txt .= "\t\tfunction save() {\n";
        $txt .= "\t\t\t".'$data = $this->getData();'."\n";
        $txt .= "\t\t\t".'$errorObj = new Validate' . ucfirst($newModuleName) . '();'."\n";
        $txt .= "\t\t\t".'$errors = $errorObj->validate($data);'."\n";
        $txt .= "\t\t\t".'if (!empty($errors)) {'."\n";
        $txt .= "\t\t\t\t".'return array("errors" => $errors);'."\n";
        $txt .= "\t\t\t".'}'."\n";
        $txt .= "\t\t\t".'return parent::save' . ucfirst($newModuleName) . 'Mod($data);'."\n";
        $txt .= "\t\t}\n\n";
        $txt .= "\t\tfunction remove() {\n";
        $txt .= "\t\t\t".'$data = $this->getData();'."\n";
        $txt .= "\t\t\t".'return parent::remove' . ucfirst($newModuleName) . 'Mod($data);'."\n";
        $txt .= "\t\t}\n\n";
        $txt .= "\t\tfunction getData() {\n";
        $txt .= "\t\t\t".'$tableCols = parent::tableDef();'."\n";
        $txt .= "\t\t\t".'$data = array();'."\n";
        $txt .= "\t\t\t".'foreach ($tableCols as $key => $tableCol) {'."\n";
        $txt .= "\t\t\t\t".'if (isset($_REQUEST[$tableCol])) {'."\n";
        $txt .= "\t\t\t\t\t".'$data[$tableCol] = $_REQUEST[$tableCol];'."\n";
        $txt .= "\t\t\t\t".'}'."\n";
        $txt .= "\t\t\t".'}'."\n";
        $txt .= "\t\t\t".'return $data;'."\n";
        $txt .= "\t\t}\n\n";
        $txt .= "\t}";
        fwrite($myfile, $txt);
        fclose($myfile);
    }

}

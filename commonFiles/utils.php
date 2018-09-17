<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function getCurrentModuleName() {
    $currentURI = $_SERVER['PHP_SELF'];
    $temp = split('/', rtrim($currentURI, '/'));
    return $temp[count($temp) - 2];
}

function getCurrentDateTime($format = 'Ymd') {
    global $timezone;
    date_default_timezone_set($timezone);
    return date($format);
}

function getUniqueId() {
    $rand = "";
    for ($i = 0; $i < 10; $i++) {
        $rand .= chr((mt_rand(1, 36) <= 26) ? mt_rand(97, 122) : mt_rand(48, 57));
    }
    return uniqid() . '' . $rand;
}

/**
 *
 */
function isLoggedIn() {
    if (isset($_SESSION['sp_username']) && !empty($_SESSION['sp_username']) &&
            isset($_COOKIE['PHPSESSID']) && !empty($_COOKIE['PHPSESSID'])) {
        return true;
    }
    return false;
}

function getDropDownOptions($module, $selectedVal = '', $allowEmpty = true, $labelField = 'name') {
    global $docRoot, $en;
    $options = '';
    if ($allowEmpty) {
        $options .= '<option value="">' . $en['labels']['common']['pleaseSelect'] . '</option>';
    }
    $file = $docRoot . 'controllers/' . $module . 'BO.php';
    if (file_exists($file)) {
        include_once($file);
        $className = ucfirst($module) . 'BO';
        $obj = new $className();
        $res = $obj->get(array(), array($labelField, 'id'));
        foreach ($res as $key => $row) {
            $selected = '';
            if ($row['id'] === $selectedVal) {
                $selected = 'selected="selected"';
            }
            $options .= '<option value="' . $row['id'] . '" ' . $selected . '>' . $row[$labelField] . '</option>';
        }
    }
    return $options;
}

function getStaticDropDownOptions($key, $selectedVal = '', $allowEmpty = true, $serchForm = false) {
    global $dd, $en;
    $options = '';
    if ($allowEmpty) {
        $options .= '<option value="">' . $en['labels']['common']['pleaseSelect'] . '</option>';
    }
    if (isset($dd[$key]) && !empty($dd[$key]) && is_array($dd[$key])) {
        foreach ($dd[$key] as $value => $label) {
            $selected = '';
            if ($value == $selectedVal && !$serchForm) {
                $selected = 'selected="selected"';
            }
            $options .= '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
        }
    }

    return $options;
}

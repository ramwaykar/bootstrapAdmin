<?php

include_once('../../commonFiles/conf.php');
global $docRoot;
include_once $docRoot . 'commonFiles/superRoute.php';
$app = new SuperRoute();
$action = (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) ? $_REQUEST['action'] : 'list';
$app->startExecution('user', $action);

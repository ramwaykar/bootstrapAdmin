<?php

include_once('conf.php');
global $docRoot;
include_once $docRoot . 'commonFiles/superRoute.php';
$app = new SuperRoute();
$app->startExecution($_REQUEST['module'], $_REQUEST['action']);

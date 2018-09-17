<?php

include_once('../../commonFiles/conf.php');
global $docRoot;
include_once $docRoot . 'commonFiles/superRoute.php';
$app = new SuperRoute();
$app->startExecution('noAccess');

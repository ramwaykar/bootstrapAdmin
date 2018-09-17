<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
global $en;
$GLOBALS['dd'] = array(
    'status' => array(
        0 => $en['labels']['common']['inActive'],
        1 => $en['labels']['common']['active']
    ),
    'yesNo' => array(
        0 => $en['labels']['common']['no'],
        1 => $en['labels']['common']['yes']
    ),
    'access' => array(
        1 => $en['labels']['common']['allAccess'],
        2 => $en['labels']['common']['viewOnly'],
        3 => $en['labels']['common']['noAccess']
    ),
    'operation' => array(
        1 => $en['labels']['common']['created'],
        2 => $en['labels']['common']['updated'],
        3 => $en['labels']['common']['deleted'],
        4 => $en['labels']['common']['activated'],
        5 => $en['labels']['common']['deActivated'],
    ),
    'mainNav' => array(
        'user' => $en['labels']['user']['user'],
        'securityGroup' => $en['labels']['securityGroup']['securityGroup'],
        'access' => $en['labels']['access']['access'],
        'logger' => $en['labels']['logger']['logger'],
        'moduleCreator' => $en['labels']['moduleCreator']['moduleCreator'],
    ),
);

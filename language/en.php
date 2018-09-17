<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$GLOBALS['en'] = array(
    'labels' => array(
        'common' => array(
            'module' => 'Module',
            'status' => 'Status',
            'name' => 'Name',
            'create' => 'Create',
            'search' => 'Search',
            'clear' => 'Clear',
            'edit' => 'Edit',
            'cancel' => 'Cancel',
            'delete' => 'Delete',
            'save' => 'Save',
            'logout' => 'Logout',
            'welcome' => 'Welcome',
            'copyrights' => 'Copyrights',
            'inActive' => 'In-Active',
            'active' => 'Active',
            'deActivate' => 'De-Activate',
            'activate' => 'Activate',
            'createdBy' => 'Created By',
            'updatedBy' => 'Updated By',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'allAccess' => 'All Access',
            'viewOnly' => 'View Only',
            'noAccess' => 'No Access',
            'accessDetails' => 'Access Details',
            'pleaseSelect' => 'Please Select',
            'no' => 'No',
            'yes' => 'Yes',
            'created' => 'Created',
            'updated' => 'Updated',
            'deleted' => 'Deleted',
            'updatePassword' => 'Update Password',
            'submit' => 'Submit',
            'activated' => 'Activated',
            'deActivated' => 'De-Activated',
        ),
        'install' => array(
            'welcome' => 'Welcome to the Super Admin installation screen',
            'install' => 'Install',
            'database' => 'Databse',
            'host' => 'Host',
            'dbName' => 'DB Name',
            'dbUsername' => 'DB Username',
            'dbPassword' => 'Db Password',
        ),
        'login' => array(
            'welcome' => 'Welcome to the Super Admin Login screen',
            'login' => 'Login',
            'forgotPassword' => 'Forgot Password?',
        ),
        'home' => array(
            'home' => 'Home',
        ),
        'user' => array(
            'username' => 'Username',
            'password' => 'Password',
            'confirmPassword' => 'Confirm Password',
            'email' => 'Email',
            'phone' => 'Phone',
            'firstName' => 'First Name',
            'lastName' => 'Last Name',
            'user' => 'Users',
        ),
        'securityGroup' => array(
            'securityGroup' => 'Security Group',
            'isAdmin' => 'Is Admin?',
        ),
        'access' => array(
            'access' => 'User Access',
        ),
        'logger' => array(
            'logger' => 'Log Details',
            'table' => 'Table Name',
            'recordId' => 'Record Id',
            'operation' => 'Operation',
        ),
        'moduleCreator' => array(
            'moduleCreator' => 'Module Creator',
        ),
    ),
    'errors' => array(
        'install' => array(),
        'login' => array(
            'wrong' => 'Either username or password is incorrect',
            'inactive' => 'This user is not active. Please contact to administrator',
        ),
        'home' => array(),
        'user' => array(
            'exist' => 'user with this username already exists, please try another',
            'wrong' => 'Password not matched',
        ),
        'securityGroup' => array(
            'isAdmin' => 'Record with admin access is already exists'
        ),
        'access' => array(
            'exist' => 'record with this module and security group already exists, please try another',
        ),
        'moduleCreator' => array(
            'exist' => 'module with this is already exists, please try another',
        ),
    ),
    'notifications' => array(
        'common' => array(
            'confirmDelete' => 'Are you sure, you want to delete this record? All the record associated with this will get deleted.',
            'confirmstatusChange' => 'Are you sure, you want to change this status of this record? All the record associated with this will get updated.',
            'noAccess' => 'You dont have rights to access this screen, please contact to Administrator.',
            'welcomeHome' => 'Welcome.',
            'viewNotExist' => 'view not exist.',
        ),
        'install' => array(),
        'login' => array(),
        'home' => array(),
        'user' => array(),
        'securityGroup' => array(),
    ),
);

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
global $en;
echo '<div id="global_links" class="col-md-8"><div id="welcome_user"><ul>';
echo '<li><input type="button" class="btn btn-default  btn-primary" value="' . $en['labels']['common']['logout'] . '" id="logout" /></li>';
echo '<li>' . ((isset($_SESSION['sp_user']) && !empty($_SESSION['sp_user'])) ? ('' . $en['labels']['common']['welcome'] . ' ' . $_SESSION['sp_user']) : '') . '</li>';
echo '</ul></div></div>';

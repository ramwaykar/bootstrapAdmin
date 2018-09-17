<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
global $siteRoot, $en, $dd;
$menus = '';
$currentModule = getCurrentModuleName();
foreach ($dd['mainNav'] as $module => $label) {
    $userActive = ($currentModule === $module) ? 'active' : '';
    $menus .= '<li class="' . $userActive . '">
                   <a href="' . $siteRoot . 'views/' . $module . '">' . $label . '</a>
               </li>';
}
echo '<div id="main-menu" class="col-md-12">';
echo '<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <ul class="nav navbar-nav">
      ' . $menus . '
    </ul>
  </div>
</nav>
';
echo '</div>';

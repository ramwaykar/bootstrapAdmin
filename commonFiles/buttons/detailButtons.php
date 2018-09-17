<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DetailButtons {

    /**
     * 
     * @global type $siteRoot
     * @global type $en
     * @param type $module
     * @param type $bottomButtons
     * @param type $status
     * @return string
     */
    function displayButtons($module, $bottomButtons = false, $status = 1) {
        global $siteRoot, $en;
        $statusBtnLabel = ($status == 1) ? $en['labels']['common']['deActivate'] : $en['labels']['common']['activate'];
        $bottomButtonsClass = $bottomButtons ? 'detail-view-bottom-buttons' : '';
        $buttons = '<div class="col-sm-12 ' . $bottomButtonsClass . '">';
        $viewOnlyModules = array('logger', 'moduleCreator');
        if (isset($_SESSION['access'][$module]) && $_SESSION['access'][$module] == 1 && (!in_array($module, $viewOnlyModules))) {
            $buttons .= '<a class="float-right" href="' . $siteRoot . 'views/' . $module . '?action=create&id=' . $_REQUEST['id'] . '">
                            <input type="button" class="btn btn-default  btn-primary" value="' . $en['labels']['common']['edit'] . '" id="edit" />
                        </a>';
            $buttons .= '<a class="float-right" href="' . $siteRoot . 'views/' . $module . '?action=status&id=' . $_REQUEST['id'] . '&status=' . $status . '">
                            <input type="button" class="btn btn-default  btn-primary" value="' . $statusBtnLabel . '" id="status" />
                        </a>';
            $buttons .= '<a class="float-right" href="' . $siteRoot . 'views/' . $module . '?action=delete&id=' . $_REQUEST['id'] . '">
                            <input type="button" class="btn btn-default  btn-primary" value="' . $en['labels']['common']['delete'] . '" id="delete" />
                        </a>';
            if (isset($_SESSION['sp_isAdmin']) && $_SESSION['sp_isAdmin'] == 1 && $module === 'user') {
                $buttons .= '<a class="float-right" href="' . $siteRoot . 'views/' . $module . '?action=updatePassword&id=' . $_REQUEST['id'] . '">
                                <input type="button" class="btn btn-default  btn-primary" value="' . $en['labels']['common']['updatePassword'] . '" id="updatePassword" />
                            </a>';
            }
        }

        $buttons .= '<a class="float-right" href="' . $siteRoot . 'views/' . $module . '">
                        <input type="button" class="btn btn-default  btn-primary" value="' . $en['labels']['common']['cancel'] . '" id="cancel" />
                    </a>';

        $buttons .= '</div>';
        return $buttons;
    }

}

<?php

//error_reporting(1);
session_start();
include_once('conf.php');
global $docRoot;
include_once($docRoot . 'language/en.php');
include_once($docRoot . 'commonFiles/dd.php');
include_once($docRoot . 'commonFiles/utils.php');
include_once($docRoot . 'db/checkUserAccess.php');

class SuperRoute {

    var $viewWithHeadAndFoot = array('action_list', 'action_create', 'action_delete', 'action_view', 'action_status'
        , 'action_updatePassword', 'action_forgotPassword');

    /**
     * 
     * @global type $docRoot
     * @global type $siteRoot
     * @param string $module
     * @param string $action
     */
    function startExecution($module = 'login', $action = 'list') {
        global $docRoot, $siteRoot;
        $action = 'action_' . $action;
        $installFile = $docRoot . 'db/dbConf.php';
        if (!file_exists($installFile)) {
            session_unset();
            session_destroy();
            if ($module !== 'install') {
                header('Location: ' . $siteRoot . 'views/install');
            } else {
                $module = 'install';
            }
        } else {
            if (isLoggedIn()) {
                if ($this->hasAccess($module)) {
                    if ($module === 'login') {
                        header('Location: ' . $siteRoot . 'views/home/');
                    }
                } else {
                    header('Location: ' . $siteRoot . 'views/noAccess/');
                }
            } else {
                if ($module !== 'login' && $action !== 'action_forgotPassword') {
                    header('Location: ' . $siteRoot . 'views/login/');
                }
            }
        }

        if (in_array($action, $this->viewWithHeadAndFoot)) {
            $this->loadHeader();
        }

        $this->$action($module);

        if (in_array($action, $this->viewWithHeadAndFoot)) {
            $this->loadFooter();
        }
    }

    /**
     * 
     * @param type $module
     */
    private function loadHeader() {
        include_once('header.php');
    }

    /**
     * 
     * @param type $module
     */
    private function loadFooter() {
        include_once('footer.php');
    }

    /**
     * 
     * @global type $docRoot
     * @global type $en
     * @param type $module
     */
    private function action_list($module) {
        global $docRoot, $en;
        $file = $docRoot . 'views/' . $module . '/listView.php';
        if (file_exists($file)) {
            include_once($file);
            $className = ucfirst($module) . 'ListView';
            $obj = new $className();
            $obj->loadListView($module);
        } else {
            echo $en['notifications']['common']['viewNotExist'];
        }
    }

    /**
     * 
     * @global type $docRoot
     * @global type $en
     * @param type $module
     */
    private function action_view($module) {
        global $docRoot, $en;
        $file = $docRoot . 'views/' . $module . '/detailView.php';
        if (file_exists($file)) {
            include_once($file);
            $className = ucfirst($module) . 'DetailView';
            $obj = new $className();
            $obj->loadDetailView($module);
        } else {
            echo $en['notifications']['common']['viewNotExist'];
        }
    }

    /**
     * 
     * @global type $docRoot
     * @global type $en
     * @param type $module
     */
    private function action_delete($module) {
        global $docRoot, $en;
        $file = $docRoot . 'commonFiles/views/delete.php';
        if (file_exists($file)) {
            include_once($file);
            $obj = new DeleteView();
            $obj->loadDeleteView($module);
        } else {
            echo $en['notifications']['common']['viewNotExist'];
        }
    }

    /**
     * 
     * @global type $docRoot
     * @global type $en
     * @param type $module
     */
    private function action_status($module) {
        global $docRoot, $en;
        $file = $docRoot . 'commonFiles/views/status.php';
        if (file_exists($file)) {
            include_once($file);
            $obj = new StatusView();
            $obj->loadStatusView($module);
        } else {
            echo $en['notifications']['common']['viewNotExist'];
        }
    }

    /**
     * 
     * @global type $docRoot
     * @global type $en
     * @param type $module
     */
    private function action_create($module) {
        global $docRoot, $en;
        $file = $docRoot . 'views/' . $module . '/createView.php';
        if (file_exists($file)) {
            include_once($file);
            $className = ucfirst($module) . 'CreateView';
            $obj = new $className();
            $obj->loadCreateView();
        } else {
            echo $en['notifications']['common']['viewNotExist'];
            ;
        }
    }

    /**
     * 
     * @global type $docRoot
     * @global type $en
     * @param type $module
     */
    private function action_updatePassword($module) {
        global $docRoot, $en;
        $file = $docRoot . 'views/' . $module . '/updatePasswordView.php';
        if (file_exists($file)) {
            include_once($file);
            $obj = new UserUpdatePasswordView();
            $obj->loadCreateView();
        } else {
            echo $en['notifications']['common']['viewNotExist'];
            ;
        }
    }

    /**
     * 
     * @global type $docRoot
     * @global type $en
     * @param type $module
     */
    private function action_forgotPassword($module) {
        global $docRoot, $en;
        $file = $docRoot . 'views/' . $module . '/forgotPasswordView.php';
        if (file_exists($file)) {
            include_once($file);
            $obj = new LoginForgotPasswordView();
            $obj->loadForgotPasswordView($module);
        } else {
            echo $en['notifications']['common']['viewNotExist'];
            ;
        }
    }

    /**
     * 
     * @global type $docRoot
     * @global type $en
     * @param type $module
     */
    private function action_save($module) {
        global $docRoot, $en;
        $file = $docRoot . 'controllers/' . $module . 'BO.php';
        if (file_exists($file)) {
            include_once($file);
            $className = ucfirst($module) . 'BO';
            $obj = new $className();
            $res = $obj->save();
            if ($res === true) {
                echo json_encode(true);
            } else {
                echo json_encode($res);
            }
        } else {
            echo $en['notifications']['common']['viewNotExist'];
        }
    }

    /**
     * 
     * @global type $docRoot
     * @global type $en
     * @param type $module
     */
    private function action_changePassword($module) {
        global $docRoot, $en;
        $file = $docRoot . 'controllers/' . $module . 'BO.php';
        if (file_exists($file)) {
            include_once($file);
            $className = ucfirst($module) . 'BO';
            $obj = new $className();
            $res = $obj->changePassword();
            if ($res === true) {
                echo json_encode(true);
            } else {
                echo json_encode($res);
            }
        } else {
            echo $en['notifications']['common']['viewNotExist'];
        }
    }

    /**
     * 
     * @global type $docRoot
     * @global type $en
     * @param type $module
     */
    private function action_forgotPwd($module) {
        global $docRoot, $en;
        $file = $docRoot . 'controllers/' . $module . 'BO.php';
        if (file_exists($file)) {
            include_once($file);
            $className = ucfirst($module) . 'BO';
            $obj = new $className();
            $res = $obj->forgotPwd();
            if ($res === true) {
                echo json_encode(true);
            } else {
                echo json_encode($res);
            }
        } else {
            echo $en['notifications']['common']['viewNotExist'];
        }
    }

    /**
     * 
     * @global type $docRoot
     * @global type $en
     * @param type $module
     */
    private function action_remove($module) {
        global $docRoot, $en;
        $file = $docRoot . 'controllers/' . $module . 'BO.php';
        if (file_exists($file)) {
            include_once($file);
            $className = ucfirst($module) . 'BO';
            $obj = new $className();
            $res = $obj->remove();
            if ($res === true) {
                echo json_encode(true);
            } else {
                echo json_encode($res);
            }
        } else {
            echo $en['notifications']['common']['viewNotExist'];
        }
    }

    /**
     * 
     * @global type $docRoot
     * @global type $en
     * @param type $module
     */
    private function action_updateStatus($module) {
        global $docRoot, $en;
        $file = $docRoot . 'controllers/' . $module . 'BO.php';
        if (file_exists($file)) {
            include_once($file);
            $className = ucfirst($module) . 'BO';
            $obj = new $className();
            $res = $obj->updateStatus();
            if ($res === true) {
                echo json_encode(true);
            } else {
                echo json_encode($res);
            }
        } else {
            echo $en['notifications']['common']['viewNotExist'];
        }
    }

    /**
     * 
     * @global type $docRoot
     * @global type $en
     * @param type $module
     */
    private function action_getListData($module) {
        global $docRoot, $en;
        $file = $docRoot . 'controllers/' . $module . 'BO.php';
        if (file_exists($file)) {
            include_once($file);
            include_once($docRoot . 'commonFiles/views/list.php');
            $className = ucfirst($module) . 'BO';
            $obj = new $className();
            $listView = new ListView();
            $query = $listView->getQuery($module);
            $response = $obj->get($query);
            $res = $listView->getActionButtons($module, $response['records']);
            echo json_encode(
                    array(
                        "recordsTotal" => $response['count'],
                        "recordsFiltered" => $response['count'],
                        "data" => $res,
                    )
            );
        } else {
            echo $en['notifications']['common']['viewNotExist'];
        }
    }

    /**
     * 
     * @param type $module
     */
    private function action_search($module) {
        $this->action_getListData($module);
    }

    /**
     * 
     */
    private function action_logout() {
        if (isLoggedIn()) {
            unset($_COOKIE['PHPSESSID']);
            unset($_SESSION['sp_username']);
            unset($_SESSION['sp_isAdmin']);
            unset($_SESSION['sp_user']);
            unset($_SESSION['sp_user_id']);
            session_unset();
            session_destroy();
        }
    }

    /**
     * 
     * @param type $module
     * @return boolean
     */
    private function hasAccess($module) {
        $checkUserAccess = new CheckUserAccess();
        $access = $checkUserAccess->check($module);
        $_SESSION['access'][$module] = $access;
        if ($access == 3) {
            return false;
        }
        $_SESSION['access'][$module] = $access;
        return true;
    }

}

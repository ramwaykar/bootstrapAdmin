<?php

include_once '../controllers/userBO.php';

class Login {

    /**
     * 
     * @return type
     */
    protected function tableDef() {
        return array('username', 'password');
    }

    /**
     * 
     * @return string
     */
    protected function relations() {
        $rel = array();
        $rel['securityGroupId'] = 'sp_security_group';
        return $rel;
    }

    /**
     * 
     * @global type $en
     * @param type $data
     * @return boolean
     */
    protected function saveLoginMod($data) {
        global $en;
        $user = $this->checkUser($data);
        if (is_array($user) && !empty($user) && (count($user > 0))) {
            if (!empty($user[0]['status'])) {
                $_SESSION['sp_username'] = $user[0]['username'];
                $_SESSION['sp_isAdmin'] = $user[0]['isAdmin'];
                $_SESSION['sp_user'] = $user[0]['fName'] . ' ' . $user[0]['lName'];
                $_SESSION['sp_user_id'] = $user[0]['id'];
                return true;
            } else {
                return array('errors' => array('status' => $en['errors']['login']['inactive']));
            }
        } else {
            return array('errors' => array(
                    'username' => $en['errors']['login']['wrong'],
                    'password' => $en['errors']['login']['wrong'])
            );
        }
    }

    /**
     * 
     * @global type $en
     * @param type $data
     * @return type
     */
    protected function forgotPwdLoginMod($data) {
        global $en;
        $userBO = new UserBO();
        $query = array('username' => array('operator' => 'eq', 'value' => $data['username']));
        $fields = array('sp_user.id');
        $user = $userBO->get($query, $fields);
        if (is_array($user) && !empty($user) && (count($user > 0))) {
            return $userBO->forgotPwd(array(
                        'id' => $user[0]['id'],
                        'password' => $data['password'],
            ));
        } else {
            return array('errors' => array('username' => $en['errors']['login']['wrong']));
        }
    }

    /**
     * 
     * @param type $data
     * @return type
     */
    protected function checkUser($data) {
        $rel = $this->relations();
        $userBO = new UserBO();
        $query = array(
            'username' => array(
                'operator' => 'eq',
                'value' => $data['username'],
            ),
            'password' => array(
                'operator' => 'eq',
                'value' => md5($data['password']),
            ),
        );
        $fields = array('sp_user.id', 'username', 'fName', 'lName', 'sp_user.status', 'sp_security_group.isAdmin');
        return $userBO->get($query, $fields, $rel);
    }

}
<?php

class Admin extends AdminBase {

    public $file_signature;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getHash($word) {
        return sha1($this->username . $word . $this->salt);
    }

    public function checkPassword($password) {
        return $this->password === $this->getHash($password);
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            $this->updated_time = date('Y-m-d H:i:s');

            if ($this->scenario === 'insert' || $this->scenario === 'changePassword') {
                $this->salt = md5(uniqid());
                $this->password = $this->getHash($this->new_password);
            }

            return true;
        }
        else
            return false;
    }

    public function authenticatePassword($attribute, $params) {
        if (!$this->checkPassword($this->$attribute))
            $this->addError($attribute, 'Password is incorrect');
    }

    public function afterFind() {
        parent::afterFind();

        $auth = Yii::app()->authManager;

        $authItems = array_keys($auth->getAuthItems(null, $this->id));
        $this->roles = empty($authItems) ? array() : array_combine($authItems, $authItems);
    }

    public function afterSave() {
        parent::afterSave();

        $auth = Yii::app()->authManager;

        if ($this->scenario === 'insert') {
            foreach ($this->roles as $role) {
                $auth->assign($role, $this->id);
            }
        } else {
            $authItems = array_keys($auth->getAuthItems(null, $this->id));
            $assignedRoles = empty($authItems) ? array() : array_combine($authItems, $authItems);

            foreach ($this->roles as $role) {
                if (!$auth->isAssigned($role, $this->id))
                    $auth->assign($role, $this->id);

                unset($assignedRoles[$role]);
            }

            foreach ($assignedRoles as $role) {
                $auth->revoke($role, $this->id);
            }
        }
    }

}
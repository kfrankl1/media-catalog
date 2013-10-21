<?php

// app/Model/Role.php
class Role extends AppModel {
	var $name = "Role";
	var $displayField = "title";
	public $actsAs = array('Acl' => array('type' => 'requester'));
	
    public $hasMany = array(
        'User' => array(
            'className' => 'User',
			'conditions' => array('User.is_active' => '1'),
			'order' => 'User.username ASC',
            'foreignKey' => 'role_id'
        )
    );
	
	public $validate = array(
		'title' => array(
			'isUnique' => array(
				'rule' => 'isUnique',
				'required' => 'true',
				'message' => 'This role name has already been used'
			)
		)
	);

    public function parentNode() {
        return null;
    }
	
	//public function isAuthorized($user) {
//		// Check the user's role, then check that role's permissions.
//		if (isset($user['role_id'])) {
//			$role = $this->User->Role->find('all', array(
//				'conditions' => array('Role.id' => $user['role_id'])
//				,'recursive' => -1
//			));
//			$role = $role[0]['Role'];
//			echo 'Yep';
//			return $role;
//		} else {
//			$this->Session->setFlash('Role not set');
//			return false;
//		}	
//	}
}

?>
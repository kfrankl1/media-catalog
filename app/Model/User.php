<?php

// app/Model/User.php
App::uses('AuthComponent', 'Controller/Component'); // added for acl
class User extends AppModel {
	var $name = "User";
	public $actsAs = array('Acl' => array('type' => 'requester'));
	
	public $belongsTo = array(
        'Role' => array(
            'className' => 'Role',
			'foreignKey' => 'role_id'
		)
        ,'Show' => array(
            'className' => 'Show',
			'foreignKey' => 'show_id'
		)
	);
	
    public $validate = array(
		'username' => array(
			'email' => array(
				'rule' => 'email',
				'required' => 'true',
				'message' => 'An email address is required'
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'This email address has already been used'
			)
		),
        'first_name' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A first name is required'
            )
        ),
        'last_name' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A last name is required'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required',
				'on' => 'create'
            )
        ),
        'role_id' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A role is required'
            )
        )
		,'show_id' => array(
            'requireShow' => array(
                'rule' => array('notEmpty'),
                'message' => 'A show is required'
            )
        )
    );
	
	public function parentNode() {
        if (!$this->id && empty($this->data)) {
            return null;
        }
        if (isset($this->data['User']['role_id'])) {
            $roleId = $this->data['User']['role_id'];
        } else {
            $roleId = $this->field('role_id');
        }
        if (!$roleId) {
            return null;
        } else {
            return array('Role' => array('id' => $roleId));
        }
    }
	
	public function beforeValidate(){
		if ($this->data['User']['password'] == "") {
			unset($this->data['User']['password']);
		}
	}
	
	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['password'])) {
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
		return true;
	}
}

?>
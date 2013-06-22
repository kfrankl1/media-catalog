<?php

// app/Model/User.php
class User extends AppModel {
	var $name = "User";
	
	public $belongsTo = array(
        'Role' => array(
            'className' => 'Role',
			'foreignKey' => 'role_id'
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
        'role' => array(
            'valid' => array(
                'allowEmpty' => false
            )
        )
    );
	
	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['password'])) {
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
		return true;
	}
}

?>
<?php

// app/Model/Role.php
class Role extends AppModel {
	var $name = "Role";
	var $displayField = "title";
	public $actsAs = array('Acl' => array('type' => 'requester'));
	
    public $hasMany = array(
        'User' => array(
            'className'     => 'User',
			'conditions' => array('User.is_active' => '1'),
			'order' => 'User.username ASC',
            'foreignKey'    => 'role_id'
        )
    );
	
	public $validate = array(
		'role' => array(
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
}

?>
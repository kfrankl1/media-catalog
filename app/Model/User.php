<?php

// app/Model/User.php
App::uses('AuthComponent', 'Controller/Component'); // added for acl
class User extends AppModel {
	public $helper = array('Text');
	var $name = "User";
	var $actsAs = array('Acl' => array('type' => 'requester'), 'HabtmValidatable' => 'Show'); //One field
	//public $actsAs = array();
	
	public $belongsTo = array(
        'Role' => array(
            'className' => 'Role',
			'foreignKey' => 'role_id'
		)
	);
	
    public $hasAndBelongsToMany = array(
        'Show' =>
            array(
                'className' => 'Show',
                'joinTable' => 'shows_users',
                'foreignKey' => 'user_id',
                'associationForeignKey' => 'show_id',
                'unique' => true,
                'fields' => 'id'
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
		,'Show' => array(
			'rule' => array('multiple', array('min' => 1)),
			'message' => 'Please select one or more shows'
			,'required' => 'false'
			,'allowEmpty' => 'true'
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
	
	public function findAssociatedShows($userId) {
		$options = array(
			'joins' => array(
				array('table' => 'shows_users',
					'alias' => 'ShowUsers',
					'type' => 'left',
					'conditions' => array(
						'User.id = ShowUsers.user_id'
					)
				),
				array('table' => 'shows',
					'alias' => 'Show',
					'type' => 'left',
					'conditions' => array(
						'ShowUsers.show_id = Show.id'
					)
				)
			)
			,'conditions' => array(
				'ShowUsers.user_id' => $userId
			)
			,'fields' => array(
				'Show.title'
			)
			,'recursive' => -1
		);
		
		$showsList = $this->find('all', $options);
		$result = array();
		
		foreach ($showsList as $show):
			array_push($result, $show['Show']['title']);
		endforeach;
		
		return $result;
	}	
	
	public function findAuthoredEpisodes($userId) {
		$options = array(
			'joins' => array(
				array('table' => 'shows_users',
					'alias' => 'ShowUsers',
					'type' => 'left',
					'conditions' => array(
						'User.id = ShowUsers.user_id'
					)
				),
				array('table' => 'shows',
					'alias' => 'Show',
					'type' => 'left',
					'conditions' => array(
						'ShowUsers.show_id = Show.id'
					)
				)
			)
			,'conditions' => array(
				'ShowUsers.user_id' => $userId
			)
			,'fields' => array(
				'Show.title'
			)
			,'recursive' => -1
		);
		
		$showsList = $this->find('all', $options);
		$result = array();
		
		foreach ($showsList as $show):
			array_push($result, $show['Show']['title']);
		endforeach;
		
		return $result;
	}
	
	//public function getPermissions($user) {
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
	
	// Kelsy's version
	public function isAuthorized($role, $checks = null) {
		if (isset($checks)) {
			foreach ($checks as $check):
				$result[$check] = $role['Role'][$check];
			endforeach;
			return $result;
		} else {
			$this->Session->setFlash('Role not set');
			return false;
		}
	}
	
	public function canEditEpisode($user, $episode)
	{
		$checks = array( 
			'is_edit_any_episode', 
			'is_edit_authorized_episode',
			'is_edit_authored_episode'
		);
		
		$auth = $this->isAuthorized(
			$this->Role->findById($user['role_id']), $checks);
		
		if ($auth['is_edit_any_episode']) {
			// if you can edit any episode, then always return true
			return true;
		} else if ($auth['is_edit_authorized_episode']) {
			// find all of your authorized shows and see if episode id matches
			$shows = $this->Episode->Show->User->findAssociatedShows($user['id']);
			foreach ($shows as $show):
				if ($show['id'] === $episode['Show']['id']) {
					return true;
				}
			endforeach;
			return false;
		} else if ($auth['is_edit_authored_episode'] & ($episode['Episode']['created_by'] == $user['id'])) {
			// if user can edit their own episodes and they created this episode
			return true;
		} else {
			return false;
		}
	}
}

?>
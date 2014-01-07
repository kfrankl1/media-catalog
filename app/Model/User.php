<?php

// app/Model/User.php
App::uses('AuthComponent', 'Controller/Component'); // added for acl
class User extends AppModel {
	public $helper = array('Text');
	var $name = "User";
	var $actsAs = array('Acl' => array('type' => 'requester'), 'HabtmValidatable' => 'Show');
	
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
	
	// compatibility error with version? Modified declaration
	public function beforeValidate($options = array()){
		if ($this->data['User']['password'] == "") {
			unset($this->data['User']['password']);
		}
	}
	
	// compatibility error with version? Modified declaration
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
	
	public function findAssociatedShowIds($userId) {
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
				'Show.id'
			)
			,'recursive' => -1
		);
		
		$showsList = $this->find('all', $options);
		$result = array();
		
		foreach ($showsList as $show):
			array_push($result, $show['Show']['id']);
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
	


	/**
	 * Checks the user's role to see what permission the user has.
	 * Returns true or false
	 ***********************
	 Example:
		$checks = array(
			'is_add_user', 
			'is_edit_any_user',
			'is_edit_any_user_role', 
			'is_edit_any_role', 
			'is_make_any_user_inactive', 
			'is_add_show', 
			'is_edit_any_show', 
			'is_make_any_show_inactive', 
			'is_add_any_episode', 
			'is_add_authorized_episode', 
			'is_edit_any_episode', 
			'is_edit_authorized_episode', 
			'is_edit_authored_episode', 
			'is_edit_settings'
		);
		
		$this->set('checks', $checks);
		$result = $this->Episode->Show->User->isAuthorized($checks);
		$this->set('result', $result);
		
		if ($result['is_add_user']) {
			echo pr('True');
		} else {
			echo pr('False');
		}
	 */
	
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
	
	/**
	 * Checks to see if the user can edit the episode.
	 * Based on the user's role's permissions and if the user has authored the specific episode.
	 */
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
			//$shows = $this->Episode->Show->User->findAssociatedShows($user['id']);
			$shows = $this->findAssociatedShowIds($user['id']);
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
	
	/**
	 * Checks to see if the user can edit the episodes status (is_active).
	 * Based on user's role's permissions and if the episode falls under the user's authorized shows.
	 */
	public function canEditEpisodeStatus($user, $episode)
	{
		$checks = array( 
			'is_edit_any_episode_status'
			,'is_edit_authorized_episode_status'
		);
		
		$auth = $this->isAuthorized(
			$this->Role->findById($user['role_id']), $checks);
		
		if ($auth['is_edit_any_episode_status']) {
			// if you can change the status of any episode, then always return true
			return true;
		} else if ($auth['is_edit_authorized_episode_status']) {
			// find all of your authorized shows and see if episode id matches
			$shows = $this->Episode->Show->User->findAssociatedShows($user['id']);
			foreach ($shows as $show):
				if ($show['id'] === $episode['Show']['id']) {
					return true;
				}
			endforeach;
			return false;
		} else {
			return false;
		}
	}
}

?>
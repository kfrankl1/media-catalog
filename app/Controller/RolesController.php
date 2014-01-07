<?php

class RolesController extends AppController {
	public $helpers = array('Paginator', 'UI');
	public $name = 'Roles';
	
	public function index() {
		$user = $this->Auth->user();
		$this->set('roles', $this->Paginate());
		$checks = array('is_add_role', 'is_edit_any_role');
		$result = $this->Role->User->isAuthorized($this->Role->User->findById($user['role_id']), $checks);
		$this->set('canAddRole', $result['is_add_role']);
		$this->set('canEditRole', $result['is_edit_any_role']);
	}
	
	public function view($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid role'));
		}

		$role = $this->Role->findById($id);
		if (!$role) {
			throw new NotFoundException(__('Invalid role'));
		}
		$this->set('role', $role);
		
		$user = $this->Auth->user();
		$checks = array('is_edit_any_role');
		$canEditRole = $this->Role->User->isAuthorized($this->Role->User->findById($user['role_id']), $checks);
		$this->set('canEditRole', $canEditRole['is_edit_any_role']);
	}
	
	public function add() {
		$user = $this->Auth->user();
		$checks = array('is_add_role');
		$result = $this->Genre->Show->User->isAuthorized($this->Genre->Show->User->Role->findById($user['role_id']), $checks);
		
		if ($result['is_add_role']) {
			if ($this->request->is('post')) {
					$this->Role->create();
				if ($this->Role->save($this->request->data)) {
						$this->Session->setFlash('Your role has been saved.');
						$this->redirect(array('action' => 'index'));
				} else {
						$this->Session->setFlash('Unable to add your role.');
				}
			}	
		} else {
			$this->Session->setFlash('You do not have permission to add a role.');
			$this->redirect(array('action' => 'index'));
		}
	}
	
	public function edit($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid role'));
		}
	
		$role = $this->Role->findById($id);
		if (!$role) {
			throw new NotFoundException(__('Invalid role'));
		}
	
		if ($this->request->is('post') || $this->request->is('put')) {
				$this->Role->id = $id;
		  if ($this->Role->save($this->request->data)) {
				// START TEST ACL ----------------
				$data = $this->request->data;
				$data = $data['Role'];
				$this->Acl->deny($role, 'controllers');
				$this->Acl->allow($role, 'controllers/Users/login'); // always allow any unauthenticated user to login
				$this->Acl->allow($role, 'controllers/Users/logout'); // always allow user to logout
				$this->Acl->allow($role, 'controllers/Users/edit'); // need to edit self
				
				// everything is already denied, so now we must decide what actions to allow
				// this is a terrible way to do this, but I just want to test it right now
				if ($data['is_add_user'])
				{
					$this->Acl->allow($role, 'controllers/Users/add');
				}
				if ($data['is_edit_any_user'] | $data['is_edit_any_user_role'] | $data['is_edit_any_user_shows'] | $data['is_edit_any_user_status'])
				{
					$this->Acl->allow($role, 'controllers/Users/edit');
				}
				if ($data['is_add_role'])
				{
					$this->Acl->allow($role, 'controllers/Roles/add');
				}
				if ($data['is_edit_any_role'])
				{
					$this->Acl->allow($role, 'controllers/Roles/edit');
				}
				if ($data['is_add_show'])
				{
					$this->Acl->allow($role, 'controllers/Shows/add');
				}
				if ($data['is_edit_any_show'] | $data['is_edit_any_show_status'])
				{
					$this->Acl->allow($role, 'controllers/Shows/edit');
				}
				if ($data['is_add_any_episode'] | $data['is_add_authorized_episode'])
				{
					$this->Acl->allow($role, 'controllers/Episodes/add');
				}
				if ($data['is_edit_any_episode'] | $data['is_edit_authorized_episode'] | $data['is_edit_authored_episode'] |
					$data['is_edit_any_episode_status'] | $data['is_edit_authorized_episode_status'])
				{
					$this->Acl->allow($role, 'controllers/Episodes/edit');
				}
				if ($data['is_add_genre'])
				{
					$this->Acl->allow($role, 'controllers/Genres/add');
				}
				if ($data['is_edit_any_genre'])
				{
					$this->Acl->allow($role, 'controllers/Genres/edit');
				}
				if ($data['is_add_season'])
				{
					$this->Acl->allow($role, 'controllers/Seasons/add');
				}
				if ($data['is_edit_any_season'])
				{
					$this->Acl->allow($role, 'controllers/Seasons/edit');
				}
				// this will be relevant when/if the settings are added
			//	if ($data['is_edit_settings'])
		//		{
		//			$this->Acl->allow($role, 'controllers/Settings/edit');
		//		}

				// END TEST ACL ------------------
				$this->Session->setFlash('Your role has been updated.');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Unable to update your role.');
			}
		}
	
		if (!$this->request->data) {
			$this->request->data = $role;
		}
	}
	
	public function delete($id) {
		if ($this->request->is('get')) {
				throw new MethodNotAllowedException();
		}
	
		if ($this->Role->delete($id)) {
			$this->Session->setFlash('The role with id: ' . $id . ' has been deleted.');
			$this->redirect(array('action' => 'index'));
		}
	}	
}

?>
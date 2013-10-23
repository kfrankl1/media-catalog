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
		if ($this->request->is('post')) {
				$this->Role->create();
			if ($this->Role->save($this->request->data)) {
					$this->Session->setFlash('Your role has been saved.');
					$this->redirect(array('action' => 'index'));
			} else {
					$this->Session->setFlash('Unable to add your role.');
			}
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
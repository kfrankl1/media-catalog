<?php

// app/Controller/UsersController.php
class UsersController extends AppController {
	public $helpers = array('Paginator', 'Js');
	public $components = array('RequestHandler');
	public $name = 'Users';
	
    public function beforeFilter() {
        parent::beforeFilter();
		$this->Auth->allow('login');
		$this->Auth->allow('logout');
		$this->Auth->allow('initDB');
		$this->Auth->allow('test');
    }

    public function index() {
        $this->User->recursive = 1;
        $this->set('users', $this->paginate());
		$this->set('shows', $this->User->Show->find('list', array('recursive' => -1)));
		
		$user = $this->Auth->user();
		$checks = array('is_add_user', 'is_edit_any_user', 'is_edit_any_user_role', 'is_edit_any_user_shows', 'is_edit_any_user_status');
		$result = $this->User->isAuthorized($this->User->Role->findById($user['role_id']), $checks);
		$this->set('canAddUser', $result['is_add_user']);
		if ($result['is_edit_any_user'] | $result['is_edit_any_user_role'] | $result['is_edit_any_user_shows']) {
			$this->set('canEditUser', true);
		} else {
			$this->set('canEditUser', false);
		}
		$this->set('canEditUserStatus', $result['is_edit_any_user_status']);
    }

    public function view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->read(null, $id));
		$this->set('shows', $this->User->findAssociatedShows($id));
		
		$user = $this->Auth->user();
		$checks = array('is_edit_any_user', 'is_edit_any_user_role', 'is_edit_any_user_shows');
		$result = $this->User->isAuthorized($this->User->Role->findById($user['role_id']), $checks);
		if ($result['is_edit_any_user'] | $result['is_edit_any_user_role'] | $result['is_edit_any_user_shows']) {
			$this->set('canEditUser', true);
		} else {
			$this->set('canEditUser', false);
		}
    }

    public function add() {
		$user = $this->Auth->user();
		$checks = array('is_add_user');
		$result = $this->User->isAuthorized($this->User->Role->findById($user['role_id']), $checks);
		
		if ($result['is_add_user']) {			
			$this->set('roles', $this->User->Role->find('list'));
			$this->set('shows', $this->User->Show->find('list'));
						
			if ($this->request->is('post')) {
				$this->User->create();
				if ($this->User->save($this->request->data)) {
					$this->Session->setFlash(__('The user has been saved'));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The user could not be saved. Please try again.'));
				}
			}
		} else {
			$this->Session->setFlash('You do not have permission to add a user.');
			$this->redirect(array('action' => 'index'));
		}
    }

    public function edit($id = null) {
		$user = $this->Auth->user();
		$checks = array('is_edit_any_user');
		$result = $this->User->isAuthorized($this->User->Role->findById($user['role_id']), $checks);
		
		if ($result['is_edit_any_user']) {
			$this->set('roles', $this->User->Role->find('list'));
			$this->set('shows', $this->User->Show->find('list'));
			
			$user = $this->Auth->user();
			$checks = array('is_edit_any_user_role');
			$result = $this->User->isAuthorized($this->User->Role->findById($user['role_id']), $checks);
			$this->set('canEditUserRole', $result['is_edit_any_user_role']);
			
			$this->User->id = $id;
			if (!$this->User->exists()) {
				throw new NotFoundException(__('Invalid user'));
			}
			if ($this->request->is('post') || $this->request->is('put')) {
				if ($this->User->save($this->request->data)) {
					$this->Session->setFlash(__('The user has been saved'));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The user could not be saved. Please try again.'));
				}
			} else {
				$this->request->data = $this->User->read(null, $id);
				unset($this->request->data['User']['password']);
			}
		} else {
			$this->Session->setFlash('You do not have permission to edit this user.');
			$this->redirect(array('action' => 'index'));
		}
    }

    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
		$user = $this->Auth->user();
		$checks = array('is_edit_any_user_status');
		$result = $this->User->isAuthorized($this->User->Role->findById($user['role_id']), $checks);
		
		if ($result['is_edit_any_user_status']) {
			$this->User->id = $id;
			if (!$this->User->exists()) {
				throw new NotFoundException(__('Invalid user'));
			}
			if ($this->User->delete()) {
				$this->Session->setFlash(__('User deleted'));
				$this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('User was not deleted'));
			$this->redirect(array('action' => 'index'));
		} else {
			$this->Session->setFlash('You do not have permission to edit this user\'s status.');
			$this->redirect('/users/index');
		}
    }

	public function login() {
		if ($this->Session->read('Auth.User')) {
			$this->Session->setFlash('You are logged in!');
			$this->redirect('/');
		}
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$this->redirect($this->Auth->redirect());
			} else {
				$this->Session->setFlash(__('Invalid username or password, try again'));
			}
		}
	}
	
	public function logout() {
		$this->Session->setFlash('You have successfully logged out!');
		$this->redirect($this->Auth->logout());
	}
	
	public function getShowsForRole() {
		
		// http://www.verious.com/tutorial/dynamic-select-box-with-cake-php-2-0/
		$role_id = $this->request->data['User']['role_id'];
		$checks = array('is_add_any_episode', 'is_edit_any_episode', 'is_add_authorized_episode', 'is_edit_authorized_episode');
		$auth = isAuthorized($role_id, $checks);
		if ($checks['is_add_any_episode'] | $checks['is_edit_any_episode'] | $checks['is_edit_authorized_episode'] | $checks['is_edit_authorized_episode']) {
			$shows = $this->Show->find('list');
		} else {
			$shows = null;
		}

		//$shows = $this->Show->find('list', array('recursive' => -1));
		$this->set('shows', $shows); 
		$this->layout = 'ajax';
	}
}

?>
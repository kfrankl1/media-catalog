<?php

// app/Controller/UsersController.php
class UsersController extends AppController {
	public $helpers = array('Paginator');
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
    }

    public function edit($id = null) {
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
    }

    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
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
		
	public function initDB() {
		$role = $this->User->Role;
		
		// Allow admins to everything
		$role->id = 1;
		$this->Acl->allow($role, 'controllers');
	
		// allow support to add and edit episodes, genres, seasons, shows
		// allow support to add users
		$role->id = 2;
		$this->Acl->deny($role, 'controllers');
		$this->Acl->allow($role, 'controllers/Episodes');
		$this->Acl->allow($role, 'controllers/Genres');
		$this->Acl->allow($role, 'controllers/Seasons');
		$this->Acl->allow($role, 'controllers/Shows');
		$this->Acl->allow($role, 'controllers/Users/login');
		$this->Acl->allow($role, 'controllers/Users/add');
		$this->Acl->allow($role, 'controllers/Users/index');
		$this->Acl->allow($role, 'controllers/Users/view');
		$this->Acl->allow($role, 'controllers/Users/edit'); // need to edit self
	
		// allow producers to only add and edit assigned episodes and show
		$role->id = 3;
		$this->Acl->deny($role, 'controllers');
		$this->Acl->allow($role, 'controllers/Episodes/add');
		$this->Acl->allow($role, 'controllers/Episodes/edit');
		$this->Acl->allow($role, 'controllers/Episodes/index');
		$this->Acl->allow($role, 'controllers/Episodes/view');
		$this->Acl->allow($role, 'controllers/Shows/index');
		$this->Acl->allow($role, 'controllers/Shows/view');
		$this->Acl->allow($role, 'controllers/Users/login');
		$this->Acl->allow($role, 'controllers/Users/edit'); // need to edit self
	
		// allow crew to only add and edit assigned episodes
		$role->id = 4;
		$this->Acl->deny($role, 'controllers');
		$this->Acl->allow($role, 'controllers/Genres/index');
		$this->Acl->allow($role, 'controllers/Genres/view');
		$this->Acl->allow($role, 'controllers/Seasons/index');
		$this->Acl->allow($role, 'controllers/Seasons/view');
		$this->Acl->allow($role, 'controllers/Shows/index');
		$this->Acl->allow($role, 'controllers/Shows/view');
		$this->Acl->allow($role, 'controllers/Episodes/add');
		$this->Acl->allow($role, 'controllers/Episodes/edit');
		$this->Acl->allow($role, 'controllers/Episodes/index');
		$this->Acl->allow($role, 'controllers/Episodes/view');
		$this->Acl->allow($role, 'controllers/Users/login');
		$this->Acl->allow($role, 'controllers/Users/edit'); // need to edit self
		
		// we add an exit to avoid an ugly "missing views" error message
		echo "all done";
		exit;
	}
	
	public function test() {
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
			'is_edit_authored_episode', 
			'is_edit_settings'
		);
		
		$this->set('checks', $checks);
		$result = $this->isAuthorized($checks);
		$this->set('result', $result);
		
		if ($result['is_add_user']) {
			echo pr('True');
		} else {
			echo pr('False');
		}
	}
}

?>
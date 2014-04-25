<?php

class ShowsController extends AppController {
	public $helpers = array('Text', 'Paginator');
	public $name = 'Shows';
	
	public function index() {
		$this->set('shows', $this->paginate());
		
		$user = $this->Auth->user();
		$checks = array('is_add_show', 'is_edit_any_show', 'is_edit_any_show_status');
		$result = $this->Show->User->isAuthorized($this->Show->User->Role->findById($user['role_id']), $checks);
		$this->set('canAddShow', $result['is_add_show']);
		$this->set('canEditShow', $result['is_edit_any_show']);
		$this->set('canEditShowStatus', $result['is_edit_any_show_status']);
	}

	public function view($id = null) {
		$this->set('genres', $this->Show->findAssociatedGenres($id));
		
		if (!$id) {
			throw new NotFoundException(__('Invalid show'));
		}
		
		$show = $this->Show->findById($id);
		if (!$show) {
			throw new NotFoundException(__('Invalid show'));
		}
		$this->set('show', $show);
		
		$user = $this->Auth->user();
		$checks = array('is_edit_any_show');
		$result = $this->Show->User->isAuthorized($this->Show->User->Role->findById($user['role_id']), $checks);
		$this->set('canEditShow', $result['is_edit_any_show']);
	}
	
	public function add() {
		$user = $this->Auth->user();
		$checks = array('is_add_show');
		$auth = $this->Show->User->isAuthorized($this->Show->User->Role->findById($user['role_id']), $checks);
	
		if ($auth['is_add_show']) {			
			$this->set('genres', $this->Show->Genre->find('list'));
			if ($this->request->is('post')) {
					$this->Show->create();
				if ($this->Show->save($this->request->data)) {
					$this->Session->setFlash('Your show has been saved.');
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash('Unable to add your show.');
				}
			}
		} else {
			$this->Session->setFlash('You do not have permission to add a show.');
			$this->redirect(array('action' => 'index'));
		}
	}
	
	public function edit($id = null) {
		$this->set('genres', $this->Show->Genre->find('list'));
	
		if (!$id) {
			throw new NotFoundException(__('Invalid show'));
		}
	
		$show = $this->Show->findById($id);
		if (!$show) {
			throw new NotFoundException(__('Invalid show'));
		}
	
		$user = $this->Auth->user();
		$checks = array('is_edit_any_show');
		$auth = $this->Show->User->isAuthorized($this->Show->User->Role->findById($user['role_id']), $checks);
	
		if ($auth['is_edit_any_show']) {	
			if ($this->request->is('post') || $this->request->is('put')) {
					$this->Show->id = $id;
			  if ($this->Show->save($this->request->data)) {
					$this->Session->setFlash('Your show has been updated.');
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash('Unable to update your show.');
				}
			}
		} else {
			$this->Session->setFlash('You do not have permission to edit this show.');
			$this->redirect(array('action' => 'index'));
		}
	
		if (!$this->request->data) {
			$this->request->data = $show;
		}
	}
	
	public function delete($id) {
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		
		$user = $this->Auth->user();
		$checks = array('is_edit_any_show');
		$auth = $this->Show->User->isAuthorized($this->Show->User->Role->findById($user['role_id']), $checks);
	
		if ($auth['is_edit_any_show']) {
			if ($this->Show->delete($id)) {
				$this->Session->setFlash('The show with id: ' . $id . ' has been deleted.');
				$this->redirect(array('action' => 'index'));
			}
		} else {
			$this->Session->setFlash('You do not have permission to edit this show\'s status.');
			$this->redirect(array('action' => 'index'));
		}
	}
	
	public function getByRole() {
		$roleId = $this->request->data['User']['role_id'];
		$checks = array('is_add_authorized_episode', 'is_edit_authorized_episode');
		$auth = $this->Show->User->isAuthorized($this->Show->User->Role->findById($roleId), $checks);
		
		if ($auth['is_add_authorized_episode'] | $auth['is_edit_authorized_episode']) {
			$shows = $this->Role->User->Show->find('list'); //, array( 'conditions' => array('Subcategory.category_id' => $category_id), 'recursive' => -1 )
			$this->set('shows',$shows);
			$this->layout = 'ajax';
		} else {
			$this->set('shows', array());
			$this->layout = 'ajax';
		}
		
		
		
		
		
		
		
		
		
	//	// http://www.verious.com/tutorial/dynamic-select-box-with-cake-php-2-0/
//		$role_id = $this->request->data['User']['role_id'];
//		$checks = array('is_add_any_episode', 'is_edit_any_episode', 'is_add_authorized_episode', 'is_edit_authorized_episode');
//		$auth = isAuthorized($role_id, $checks);
//		if ($checks['is_add_any_episode'] | $checks['is_edit_any_episode'] | $checks['is_edit_authorized_episode'] | $checks['is_edit_authorized_episode']) {
//			$shows = $this->Show->find('list');
//		} else {
//			$shows = null;
//		}
//
//		//$shows = $this->Show->find('list', array('recursive' => -1));
//		$this->set('shows', $shows); 
//		$this->layout = 'ajax';
	}
}

?>
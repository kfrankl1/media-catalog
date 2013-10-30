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
	
		if ($this->request->is('post') || $this->request->is('put')) {
				$this->Show->id = $id;
		  if ($this->Show->save($this->request->data)) {
				$this->Session->setFlash('Your show has been updated.');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Unable to update your show.');
			}
		}
	
		if (!$this->request->data) {
			$this->request->data = $show;
		}
	}
	
	public function delete($id) {
		if ($this->request->is('get')) {
				throw new MethodNotAllowedException();
		}
	
		if ($this->Show->delete($id)) {
			$this->Session->setFlash('The show with id: ' . $id . ' has been deleted.');
			$this->redirect(array('action' => 'index'));
		}
	}
	
}

?>
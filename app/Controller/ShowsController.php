<?php

class ShowsController extends AppController {
	public $helpers = array('Html', 'Form', 'Session');
	public $components = array('Session');
	
	public function index() {
		$this->set('shows', $this->Show->find('all'));
	}

	public function view($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid show'));
		}

		$show = $this->Show->findById($id);
		if (!$show) {
			throw new NotFoundException(__('Invalid show'));
		}
		$this->set('show', $show);
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
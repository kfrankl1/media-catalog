<?php

class GenresController extends AppController {
	public $helpers = array('Html', 'Form', 'Session');
	public $components = array('Session');
	
	public function index() {
		$this->set('genres', $this->Genre->find('all'));
	}
	
	public function view($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid genre'));
		}

		$genre = $this->Genre->findById($id);
		if (!$genre) {
			throw new NotFoundException(__('Invalid genre'));
		}
		$this->set('genre', $genre);
	}
	
	public function add() {
		if ($this->request->is('post')) {
				$this->Genre->create();
			if ($this->Genre->save($this->request->data)) {
					$this->Session->setFlash('Your genre has been saved.');
					$this->redirect(array('action' => 'index'));
			} else {
					$this->Session->setFlash('Unable to add your genre.');
			}
		}
	}
	
	public function edit($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid genre'));
		}
	
		$genre = $this->Genre->findById($id);
		if (!$genre) {
			throw new NotFoundException(__('Invalid genre'));
		}
	
		if ($this->request->is('post') || $this->request->is('put')) {
				$this->Genre->id = $id;
		  if ($this->Genre->save($this->request->data)) {
				$this->Session->setFlash('Your genre has been updated.');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Unable to update your genre.');
			}
		}
	
		if (!$this->request->data) {
			$this->request->data = $genre;
		}
	}
	
	public function delete($id) {
		if ($this->request->is('get')) {
				throw new MethodNotAllowedException();
		}
	
		if ($this->Genre->delete($id)) {
			$this->Session->setFlash('The genre with id: ' . $id . ' has been deleted.');
			$this->redirect(array('action' => 'index'));
		}
	}
	
}

?>
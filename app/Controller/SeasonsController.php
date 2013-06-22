<?php

class SeasonsController extends AppController {
	public $helpers = array('Html', 'Form', 'Session');
	public $components = array('Session');
	
	public function index() {
		$this->set('seasons', $this->Season->find('all'));
	}
	
	public function view($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid season'));
		}

		$season = $this->Season->findById($id);
		if (!$season) {
			throw new NotFoundException(__('Invalid season'));
		}
		$this->set('season', $season);
	}
	
	public function add() {
		if ($this->request->is('post')) {
				$this->Season->create();
			if ($this->Season->save($this->request->data)) {
					$this->Session->setFlash('Your season has been saved.');
					$this->redirect(array('action' => 'index'));
			} else {
					$this->Session->setFlash('Unable to add your season.');
			}
		}
	}
	
	public function edit($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid season'));
		}
	
		$season = $this->Season->findById($id);
		if (!$season) {
			throw new NotFoundException(__('Invalid season'));
		}
	
		if ($this->request->is('post') || $this->request->is('put')) {
				$this->Season->id = $id;
		  if ($this->Season->save($this->request->data)) {
				$this->Session->setFlash('Your season has been updated.');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Unable to update your season.');
			}
		}
	
		if (!$this->request->data) {
			$this->request->data = $season;
		}
	}
	
	public function delete($id) {
		if ($this->request->is('get')) {
				throw new MethodNotAllowedException();
		}
	
		if ($this->Season->delete($id)) {
			$this->Session->setFlash('The season with id: ' . $id . ' has been deleted.');
			$this->redirect(array('action' => 'index'));
		}
	}
	
}

?>
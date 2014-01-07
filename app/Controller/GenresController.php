<?php

class GenresController extends AppController {	
	public $helpers = array('Paginator');
	
	public function index() {
		$user = $this->Auth->user();
		$this->set('genres', $this->Paginate());
		$checks = array('is_add_genre', 'is_edit_any_genre');
		$result = $this->Genre->Show->User->isAuthorized($this->Genre->Show->User->Role->findById($user['role_id']), $checks);
		$this->set('canAddGenre', $result['is_add_genre']);
		$this->set('canEditGenre', $result['is_edit_any_genre']);
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
		
		$user = $this->Auth->user;		
		$checks = array('is_edit_any_genre');
		$canEditGenre = $this->Genre->Show->User->isAuthorized($user['Role']['id'], $checks);
		$this->set('canEditGenre', $canEditGenre['is_edit_any_genre']);
	}
	
	public function add() {
		$user = $this->Auth->user();
		$checks = array('is_add_genre');
		$result = $this->Genre->Show->User->isAuthorized($this->Genre->Show->User->Role->findById($user['role_id']), $checks);
		
		if ($result['is_add_genre']) {
			if ($this->request->is('post')) {
					$this->Genre->create();
				if ($this->Genre->save($this->request->data)) {
						$this->Session->setFlash('Your genre has been saved.');
						$this->redirect(array('action' => 'index'));
				} else {
						$this->Session->setFlash('Unable to add your genre.');
				}
			}			
		} else {
			$this->Session->setFlash('You do not have permission to add a genre.');
			$this->redirect(array('action' => 'index'));
		}
	}
	
	public function edit($id = null) {
		$user = $this->Auth->user();
		$checks = array('is_edit_any_genre');
		$result = $this->Genre->Show->User->isAuthorized($this->Genre->Show->User->Role->findById($user['role_id']), $checks);
		
		if ($result['is_edit_any_genre']) {
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
		} else {
			$this->Session->setFlash('You do not have permission to edit this genre.');
			$this->redirect(array('action' => 'index'));
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
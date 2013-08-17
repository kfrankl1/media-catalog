<?php

class EpisodesController extends AppController {
	public $helpers = array('Paginator');
	
	public function index() {
		$this->set('episodes', $this->Paginate());
	}

	public function view($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid episode'));
		}

		$episode = $this->Episode->findById($id);
		if (!$episode) {
			throw new NotFoundException(__('Invalid episode'));
		}
		$this->set('episode', $episode);
	}
	
	public function add() {
		// find a list of shows that belong to the logged in user
		$user = $this->Auth->user();
		$shows = $this->Episode->Show->User->findAssociatedShows($user['id']);
		$this->set('shows', $shows);		
		$this->set('seasons', $this->Episode->Season->find('list'));
		
		if ($this->request->is('post')) {
				$this->Episode->create();
			if ($this->Episode->save($this->request->data)) {
					$this->Session->setFlash('Your episode has been saved.');
					$this->redirect(array('action' => 'index'));
			} else {
					$this->Session->setFlash('Unable to add your episode.');
			}
		}
	}
	
	public function edit($id = null) {
		$user = $this->Auth->user();
		if ($this->isAuthorized($user)) {
			$this->set('shows', $this->Episode->Show->find('list'));
			$this->set('seasons', $this->Episode->Season->find('list'));
			
			if (!$id) {
				throw new NotFoundException(__('Invalid episode'));
			}
		
			$episode = $this->Episode->findById($id);
			if (!$episode) {
				throw new NotFoundException(__('Invalid episode'));
			}
			
			if ($this->request->is('post') || $this->request->is('put')) {
					$this->Episode->id = $id;
			  if ($this->Episode->save($this->request->data)) {
					$this->Session->setFlash('Your episode has been updated.');
					$this->redirect(array('action' => 'view', $id));
				} else {
					$this->Session->setFlash('Unable to update your episode.');
				}
			}
		
			if (!$this->request->data) {
				$this->request->data = $episode;
			}
			
		} else {
			$this->Session->setFlash('You do not have permission to edit this episode.');
			$this->redirect(array('action' => 'index'));
		}
	}
	
	public function delete($id) {
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
	
		if ($this->Episode->delete($id)) {
			$this->Session->setFlash('The episode with id: ' . $id . ' has been deleted.');
			$this->redirect(array('action' => 'index'));
		}
	}
	
	public function isAuthorized($user) {
		// The owner of an episode can edit it
		if (in_array($this->action, array('edit'))) {
			$episodeId = $this->request->params['pass'][0];
			if ($this->Episode->isOwnedBy($episodeId, $user['id'])) {
				return true;
			}
		}
		
		return parent::isAuthorized($user);
	}
}

?>
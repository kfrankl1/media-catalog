<?php

class EpisodesController extends AppController {
	public $helpers = array('Paginator');
	
	public function index() {
		$user = $this->Auth->user();
		$episodes = $this->Paginate();
		$this->set('episodes', $episodes);
		
		$canEditEpisode = array();
		$canEditStatus = array();
		foreach ($episodes as $episode):
			if ($this->Episode->Show->User->canEditEpisode($user, $episode)) {
				$canEditEpisode[$episode['Episode']['id']] = true;
			} else {
				$canEditEpisode[$episode['Episode']['id']] = false;
			}
			
			if ($this->Episode->Show->User->canEditEpisodeStatus($user, $episode)) {
				$canEditStatus[$episode['Episode']['id']] = true;
			} else {
				$canEditStatus[$episode['Episode']['id']] = false;
			}	
		endforeach;
		$this->set('canEditEpisode', $canEditEpisode);
		$this->set('canEditStatus', $canEditStatus);
	}

	public function view($id = null) {
		$user = $this->Auth->user();
		if (!$id) {
			throw new NotFoundException(__('Invalid episode'));
		}

		$episode = $this->Episode->findById($id);
		if (!$episode) {
			throw new NotFoundException(__('Invalid episode'));
		}
		$this->set('episode', $episode);
		
	
		if ($this->Episode->Show->User->canEditEpisode($user, $episode)) {
			$canEditEpisode = true;
		} else {
			$canEditEpisode = false;
		}
			
		if ($this->Episode->Show->User->canEditEpisodeStatus($user, $episode)) {
			$canEditStatus = true;
		} else {
			$canEditStatus = false;
		}
		$this->set('canEditEpisode', $canEditEpisode);
		$this->set('canEditStatus', $canEditStatus);
	}
	
	public function add() {
		// find a list of shows that belong to the logged in user
		$user = $this->Auth->user();

		$checks = array( 
			'is_add_any_episode', 
			'is_add_authorized_episode',
		);
		
		$auth = $this->Episode->Show->User->isAuthorized($this->Episode->Show->User->Role->findById($user['role_id']), $checks);
		
		if ($auth['is_add_any_episode']) {
			$shows = $this->Episode->Show->find('list');
		} else if ($auth['is_add_authorized_episode']) {
			$shows = $this->Episode->Show->User->findAssociatedShows($user['id']);
		}
		
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
		echo pr($user);

		$checks = array( 
			'is_edit_any_episode', 
			'is_edit_authorized_episode',
		);
		
		$auth = $this->Episode->Show->User->isAuthorized($this->Episode->Show->User->Role->findById($user['role_id']), $checks);
		
		if ($auth['is_edit_any_episode']) {
			$shows = $this->Episode->Show->find('list');
		} else if ($auth['is_edit_authorized_episode']) {
			$shows = $this->Episode->Show->User->findAssociatedShows($user['id']);
		}
		
		
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
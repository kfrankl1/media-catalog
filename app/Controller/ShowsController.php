<?php

class ShowsController extends AppController {
	public $helpers = array('Html', 'Form', 'Session', 'Text');
	public $components = array('Session');
	public $name = 'Shows';
	
	public function index() {
		$this->set('shows', $this->Show->find('all'));
	}

	public function view($id = null) {
		$options = array(
			'joins' => array(
				array('table' => 'genres_shows',
					'alias' => 'GenresShow',
					'type' => 'left',
					'conditions' => array(
						'Show.id = GenresShow.show_id'
					)
				),
				array('table' => 'genres',
					'alias' => 'Genre',
					'type' => 'left',
					'conditions' => array(
						'GenresShow.genre_id = Genre.id'
					)
				)
			)
			,'conditions' => array(
				'GenresShow.show_id' => $id
			)
			,'fields' => array(
				'Genre.title'
			)
			,'recursive' => -1
		);
		
		$genresList = $this->Show->find('all', $options);	
		
		$result = array();
		
		foreach ($genresList as $genre):
			array_push($result, $genre['Genre']['title']);
		endforeach;
		
		$this->set('genres', $result);
		
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
		  if ($this->Show->save($this->request->data)) { //if ($this->Show->save($this->request->data)) {
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
<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	var $uses = array('User');
	public $components = array(
		'Session'
		,'Acl'
		,'Auth' => array(
			'loginRedirect' => array('controller' => 'episodes', 'action' => 'index') // 'action' => 'display', 'home')
			,'logoutRedirect' => array('controller' => 'users', 'action' => 'login')
			,'authorize' => array('Actions' => array('actionPath' => 'controllers')) // added for acl, this one works!
			//,'authorize' => array('Controller') // <- here
			//,'authorize' => 'actions'
		)
	);

    public $helpers = array('Html', 'Form', 'Session', 'Time');
	public $userCan;
		
	/**
	* beforeFilter - added 6/16/13 - KF
	**/
	function beforeFilter() {
		//$user = $this->Auth->user('id');
//		$checks = array(
//			'is_add_user', 
//			'is_edit_any_user',
//			'is_edit_any_user_role', 
//			'is_edit_any_user_shows', 
//			'is_add_role', 
//			'is_edit_any_role', 
//			'is_make_any_user_status', 
//			'is_add_show', 
//			'is_edit_any_show', 
//			'is_edit_any_show_status', 
//			'is_add_any_episode', 
//			'is_add_authorized_episode', 
//			'is_edit_any_episode', 
//			'is_edit_authorized_episode', 
//			'is_edit_authored_episode', 
//			'is_edit_any_episode_status', 
//			'is_edit_authorized_episode_status', 
//			'is_add_genre', 
//			'is_edit_any_genre', 
//			'is_add_season', 
//			'is_edit_any_season', 
//			'is_edit_settings'
//		);
//		$userCan = $this->User->isAuthorized($this->User->Role->findById($user['role_id']), $checks);
		
		//Configure AuthComponent
        //$this->Auth->authorize = 'actions'; // commented out for acl
		// added four lines for acl
		$this->Auth->allow('index', 'view'); //'display');
        $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
        $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
        $this->Auth->loginRedirect = array('controller' => 'episodes', 'action' => 'index');

		
		/**
		* If logged in, set the model property userId to logged in user's ID
		**/
		if ($userId = $this->Auth->user('id')) {
			$this->{$this->modelClass}->userId = $userId;
		}
		
		// Set common variables
		//$timeFormat = '%Y-%m-%d';
		$timeFormat = '%m-%d-%Y';
		$this->set('timeFormat', $timeFormat);
	}
}

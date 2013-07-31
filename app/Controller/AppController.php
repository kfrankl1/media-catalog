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
	
	public $components = array(
		'Session'
		,'Acl'
		,'Auth' => array(
			'loginRedirect' => array('controller' => 'shows', 'action' => 'index')
			,'logoutRedirect' => array('controller' => 'shows', 'action' => 'display', 'home')
			,'authorize' => array('Actions' => array('actionPath' => 'controllers')) // added for acl
			//,'authorize' => array('Controller') // added for Auth tutorial
		)
	);
    public $helpers = array('Html', 'Form', 'Session');
	
	/* Commented out 6/16/13 - KF
	public function beforeFilter() {
		$this->Auth->allow('index', 'view');
	}
	*/
	
	/**
	* beforeFilter - added 6/16/13 - KF
	**/
	function beforeFilter() {
		//Configure AuthComponent
        //$this->Auth->authorize = 'actions'; // commented out for acl
		// added four lines for acl
		$this->Auth->allow('index', 'view'); //'display');
        $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
        $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
        //$this->Auth->loginRedirect = array('controller' => 'posts', 'action' => 'add');
		
		/**
		* If logged in, set the model property userId to logged in user's ID
		**/
		if ($userId = $this->Auth->user('id')) {
			$this->{$this->modelClass}->userId = $userId;
		}
	}
	
	public function isAuthorized($user) {
		// Admin can access every action
		if (isset($user['role_id']) && $user['role_id'] === 1) {
			return true;
		}
	
		// Default deny
		return false;
	}
}

<?php
App::uses('AppController', 'Controller');
App::uses('CakeEvent', 'Event');

/**
 * Users Controller
 *
 */
class UsersController extends AppController {

	public function index() {
		$this->Crud->on('beforePaginate', function() {
			$this->User->switchToElastic();
		});
		return $this->Crud->executeAction();
	}

	public function login() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$event = new CakeEvent('Users.afterLogin', $this, ['user' => $this->Auth->user()]);
				$this->getEventManager()->dispatch($event);
			}
			$this->autoRender = false;
		}
	}

}

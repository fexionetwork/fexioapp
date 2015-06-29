<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity())
		{
			$this->view->identity = $auth->getIdentity();
			
		}
    }

    public function registerAction()
    {
        // action body
		$userForm = new Application_Form_Register();
		$users = new Application_Model_DbTable_Users();
		if ($this->_request->isPost())
		{
			if($userForm->isValid($_POST))
			{
				$data = $_POST;
				if ($users->getSingleWithEmail($data['email']) != null) {
                	// if the email already exists in the database
                	$this->view->error = 'Email already taken';
            	} else if ($users->getSingleWithUsername($data['username']) != null) {
                	// if the username already exists in the database
                	$this->view->error = 'Username already taken';
            	} else if ($data['email'] != $data['emailAgain']) {
                	// if both emails do not match
                	$this->view->error = 'Both emails must be same';
           	 	} else if ($data['password'] != $data['passwordAgain']) {
                	// if both passwords do not match
                	$this->view->error = 'Both passwords must be same';
            	} else {
					$users->add(
							$userForm->getValue('username'),
							$userForm->getValue('password'),
							$userForm->getValue('first_name'),
							$userForm->getValue('last_name'),
							$userForm->getValue('email'),
							$userForm->getValue('role')
							);
                    
				}
				$this->_forward('list');
			}
		}
		$userForm->setAction('/user/register');
		$this->view->form = $userForm;
    }

    public function listAction()
    {
        // action body
		$currentUsers = Application_Model_DbTable_Users::getUsers();
		if ($currentUsers->count() > 0)
		{
			$this->view->users = $currentUsers;
		}else{
			$this->view->users = null;
		}
    }

    public function updateAction()
    {
        // action body
		$userForm = new Application_Form_Register();
		$userForm->setAction('/user/update');
		$userForm->removeElement('password');
		$userForm->removeElement('passwordAgain');
		$userModel = new Application_Model_DbTable_Users();
		if ($this->_request->isPost())
		{
			if ($userForm->isValid($_POST))
			{
				$userModel->updateUser(
							$userForm->getValue('id'),
							$userForm->getValue('username'),
							$userForm->getValue('first_name'),
							$userForm->getValue('last_name'),
							$userForm->getValue('role')
							);
				return $this->_forward('list');
			}
		}else{
			
				
		
		$id = $this->_request->getParam('id');
		
		$currentUser = $userModel->find($id)->current();
		$userForm->populate($currentUser->toArray());
		}
		$this->view->form = $userForm;
    }

    public function passwordAction()
    {
        // action body
		$passwordForm = new Application_Form_Register();
		$passwordForm->setAction('/user/password');
		$passwordForm->removeElement('first_name');
		$passwordForm->removeElement('last_name');
		$passwordForm->removeElement('role');
		$userModel = new Application_Model_DbTable_Users();
		if ($this->_request->isPost())
		{
			if ($passwordForm->isValid($_POST))
			{
				$userModel->updatePassword(
						$passwordForm->getValue('id'),
						$passwordForm->getValue('password')
						);
				return $this->_forward('list');
				
			}
		}else{
			$id = $this->_request->getParam('id');
			$currentUser = $userModel->find($id)->current();
			$passwordForm->populate($currentUser->toArray());
		}
		$this->view->form = $passwordForm;
    }

    public function deleteAction()
    {
		$id = $this->_request->getParam('id');
		$userModel = new Application_Model_DbTable_Users();
		$userModel->deleteUser($id);
		return $this->_forward('list');
		
    }

    public function loginAction()
    {
        // action body
		$userForm = new Application_Form_Register();
		$userForm->setAction('/user/login');
		$userForm->removeElement('first_name');
		$userForm->removeElement('last_name');
		$userForm->removeElement('passwordAgain');
		$userForm->removeElement('emailAgain');
		$userForm->removeElement('email');
		$userForm->removeElement('role');
		if ($this->_request->isPost() && $userForm->isValid($_POST))
		{
			$data = $userForm->getValues();
			//set up the auth adapter
			//get the default db adapter
			$db = Zend_Db_Table::getDefaultAdapter();
			// create the auth adapter
			$authAdapter = new Zend_Auth_Adapter_DbTable($db, 'users', 'username', 'password');
			//set the username and password
			$authAdapter->setIdentity($data['username']);
			$authAdapter->setCredential(md5($data['password']));
			//authenticate
			$result = $authAdapter->authenticate();
			if ($result->isValid())
			{
				//store the username, first and last names of the user 
				$auth = Zend_Auth::getInstance();
				$storage = $auth->getStorage();
				$storage->write($authAdapter->getResultRowObject(array('username', 'first_name', 'last_name', 'role')));
				return $this->_forward('index');
			} else {
				$this->view->loginMessage = "Sorry, your username or password was incurrect";
			}
			
			
		}
		$this->view->form = $userForm;
    }

    public function logoutAction()
    {
        // action body
		$authAdapter = Zend_Auth::getInstance();
		$authAdapter->clearIdentity();
		$this->_redirect('/user/index');
    }


}














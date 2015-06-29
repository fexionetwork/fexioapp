<?php

class RegisterController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
		
    }

    public function indexAction()
    {
        // action body
		
		$form = new Application_Form_Register;
		
		
		$this->view->form = $form;
		
		
    }

    public function registerAction()
    {
        // action body
		$request = $this->getRequest();
		$users = new Application_Model_DbTable_Users;
		$form = new Application_Form_Register;
		//var_dump ($form);
		// if POST data has been submitted
    	if ($request->isPost()) {
        	// if the Register form has been submitted and the submitted data is valid
        	if (isset($_POST['register']) && $form->isValid($_POST)) {
 				$data = $_POST;
				//var_dump ($data);
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
						/*$data['password_hash'] = $data['password'];
					unset($data['emailAgain'], $data['passwordAgain'],
                          $data['register'], $data['password']);
						  
                    $data['role'] = 'user';
                    $data['status'] = 'pending';
                    $users->add($data);*/
					$users->add(
							$form->getValue('username'),
							$form->getValue('password'),
							$form->getValue('first_name'),
							$form->getValue('last_name'),
							$form->getValue('email'),
							$form->getValue('role')
							);
                    $this->_redirect('/user/index');
				}
             }
		}
		$this->view->form = $form;
		
    }

    public function successAction()
    {
        // action body
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


}








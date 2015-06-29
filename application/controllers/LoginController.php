<?php

class LoginController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
		// If we're already logged in, just redirect  
        if(Zend_Auth::getInstance()->hasIdentity())  
        {  
            $this->_redirect('register/success');  
        }  
  
        $request = $this->getRequest();  
        $loginForm = $this->getformAction();  
  
        $errorMessage = "";
		if($request->isPost())  
		{  
    		if($loginForm->isValid($request->getPost()))  
    		{  
        		// get the username and password from the form  
        		$username = $loginForm->getValue('username');  
        		$password = $loginForm->getValue('password');   
				
				$dbAdapter = new Zend_Db_Adapter_Pdo_Mysql(array(
															'host' => 'fexioapp.dev',
															'username' => 'root',
															'password' => '',
															'dbname' => 'test'
															));  
				$authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);  
  
				$authAdapter->setTableName('users')  
            				->setIdentityColumn('username')  
            				->setCredentialColumn('password_hash');  
            				
				// pass to the adapter the submitted username and password  
				$authAdapter->setIdentity($username)  
            				->setCredential($password);
				
				$auth = Zend_Auth::getInstance();  
				$result = $auth->authenticate($authAdapter);
				// is the user a valid one?  
				if($result->isValid())  
				{  
    				// get all info about this user from the login table  
    				// ommit only the password, we don't need that  
    				$userInfo = $authAdapter->getResultRowObject(null, 'password_hash');  
  
    				// the default storage is a session with namespace Zend_Auth  
    				$authStorage = $auth->getStorage();  
    				$authStorage->write($userInfo);  
  
    				$this->_redirect('login/success');  
				}else  
				{  
    				$errorMessage = "Wrong username or password provided. Please try again.";  
				}  
			}
		}
		$this->view->errorMessage = $errorMessage;  
		$this->view->loginForm = $loginForm;
    }

    public function getformAction()
    {
        // action body
		
		$username = new Zend_Form_Element_Text('username');  
    	$username->setLabel('Username:')  
            	->setRequired(true);  
  
    	$password = new Zend_Form_Element_Password('password');  
    	$password->setLabel('Password:')  
            	->setRequired(true);  
  
    	$submit = new Zend_Form_Element_Submit('login');  
    	$submit->setLabel('Login');  
  
    	$loginForm = new Zend_Form();  
    	$loginForm->setAction('login/index/')  
            	->setMethod('post')  
            	->addElement($username)  
            	->addElement($password)  
            	->addElement($submit);  
  
    	return $loginForm;  
    }

    public function successAction()
    {
        // action body
    }

    public function logoutAction()
    {
        // action body
		
    	// clear everything - session is cleared also!  
    	Zend_Auth::getInstance()->clearIdentity();  
    	$this->_redirect('login/index');  

    }


}








<?php

class Application_Form_Register extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
		$this->setMethod('post');
		//$this->setAction('/user/register');
 
        $firstName = new Zend_Form_Element_Text('first_name', array(
            								           		'label' => 'First name',
            												'required' => true,
            												'filters' => array('StringTrim'),     											
            												'validators' => array(
               											array('StringLength', false, array(2, 50))
            																),
            							        		));
   
   		$lastName = new Zend_Form_Element_Text('last_name', array(
                        									'label' => 'Last name',
            												'required' => true,
            												'filters' => array('StringTrim'),
            												'validators' => array(
                										array('StringLength', false, array(2, 50))
            													),
            									        ));
   
   
   		$email = new Zend_Form_Element_Text('email', array(
            								         	'label' => 'Email',
            											'required' => true,
            											'filters' => array('StringTrim'),
            											'validators' => array('EmailAddress'),
                   										));
   
   		$emailAgain = new Zend_Form_Element_Text('emailAgain', array(
            												'label' => 'Email again',
            												'required' => true,
            												'filters' => array('StringTrim'),
            												'validators' => array('EmailAddress'),
            											));
   
   
   
   		$username = new Zend_Form_Element_Text('username', array(
            												'label' => 'Username',
            												'required' => true,
            												'filters' => array('StringTrim'),
            												'validators' => array(
                										array('StringLength', false, array(3, 50))
            																),
           												));
   	
		$password = new Zend_Form_Element_Password('password', array(
            													'label' => 'Password',
            													'required' => true,
            													'filters' => array('StringTrim'),
            													'validators' => array(
                										array('StringLength', false, array(6, 50))
            																),
            											));
														
		$passwordAgain = new Zend_Form_Element_Password('passwordAgain', array(
            													'label' => 'Password again',
            													'required' => true,
            													'filters' => array('StringTrim'),
            													'validators' => array(
               							 				array('StringLength', false, array(6, 50))
            																),
            											));
		$role = $this->createElement('select', 'role');
		$role->setLabel("Select a role: ");
		$role->addMultiOption('User', 'user');
		$role->addMultiOption('Administrator', 'administrator');
		
		$submit = new Zend_Form_Element_Submit('register', array('label' => 'Register'));
   
   		$this->addElements(array(
								$username,
            					$firstName,
            					$lastName,
            					$email,
            					$emailAgain,
            					$password,
            					$passwordAgain,
								$role,
            					$submit
								
        						));
   
    }


}


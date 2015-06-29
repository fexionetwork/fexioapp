<?php

class Application_Form_FormMenu extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
		$this->setMethod ('post');
		//create new Element
		$id = $this->createElement('hidden', 'id');
		//element options
		$id->setDecorators(array('ViewHelper'));
		//add the element to the form
		$this->addElement($id);
		
		//create new element
		$name = $this->createElement('text', 'name');
		//element options
		$name->setLabel('Name: ');
		$name->setRequired(TRUE);
		$name->setAttrib('size', 40);
		//strip all tags from the menu name for security purposes
		$name->addFilter('StripTags');
		//add the element to the form 
		$this->addElement($name);
		
		$submit = $this->addElement('submit', 'submit', array('label' => 'Submit' ));
		
    }


}


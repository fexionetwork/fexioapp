<?php

class Application_Form_SearchForm extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
		// create new DOMElement
		$query = $this->createElement('text', 'query');
		// element options
		//$query->setLabel('Keywords');
		$query->setRequired(true);
		$query->setAttrib('size', 20);
		//adding the element decorators
		$query->addDecorators(array(
				array('ViewHelper'),
				array('Errors'),
				array('Description', array('tag' => 'p', 'class' => 'description')),
				array('HtmlTag', array('tag' => 'dd')),
				array('Label', array('tag' => 'dt')),
		));
		// add the element to the form
		$this->addElement($query);
		
		$submit = $this->createElement('submit', 'search');
		$submit->setLabel('Search Jobs');
		$submit->setDecorators(array('ViewHelper'));
		/*$query->addDecorators(array(
				array('ViewHelper'),
				array('Errors'),
				array('Description', array('tag' => 'p', 'class' => 'description')),
				array('HtmlTag', array('tag' => 'subm')),
				array('Label', array('tag' => 'dt')),
				));*/
				
		$this->addElement($submit);
    }


}


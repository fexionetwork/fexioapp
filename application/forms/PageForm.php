<?php

class Application_Form_PageForm extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
		$this ->setAttrib('enctype', 'multipart/form-data');
		//create new element
		$id = $this->createElement('Hidden', 'id');
		//element options
		//$id->setDecorators(array('VeiwHelper'));
		//add the element to the form
		$this->addElement($id);
		
		//create a hidden form element to store userid
		$userid = $this->createElement('Hidden', 'userid');
		$this->addElement($userid);
		
		//create new element
		$name = $this->createElement('text', 'name');
		//element options
		$name->setLabel('Page Name: ' );
		$name->setRequired(TRUE);
		$name->setAttrib('size', 40);
		
		//add the element to the form
		$this->addElement($name);
		
		//create new element
		$headline = $this->createElement('text', 'headline');
		//element options
		$headline->setLabel('Headline: ' );
		$headline->setRequired(TRUE);
		$headline->setAttrib('size', 50);
		
		//add the element to the form
		$this->addElement($headline);
		
		//create new element
		$image = $this->createElement('file', 'image');
		//element options
		$image->setLabel('Image: ' );
		$image->setRequired(FALSE);
		
		$image->setDestination(APPLICATION_PATH . '/../public/images/upload/');
		$image->addValidator('Size', false, 102400);
		$image->addvalidator('Extension', false, 'jpg,png,gif');
		
		//add the element to the form
		$this->addElement($image);
		
		//create new element
		$description = $this->createElement('textarea', 'description');
		//element options
		$description->setLabel('Description: ' );
		$description->setRequired(TRUE);
		$description->setAttrib('cols', 40);
		$description->setAttrib('rows', 4);
		
		//add the element to the form
		$this->addElement($description);
		
		//create new element
		$content = $this->createElement('textarea', 'content');
		//element options
		$content->setLabel('Content: ' );
		$content->setRequired(TRUE);
		$content->setAttrib('cols', 50);
		$content->setAttrib('rows', 12);
		
		//add the element to the form
		$this->addElement($content);
		
		$submit = $this->addElement('submit', 'submit', array('label' => 'Submit'));
		
    }


}


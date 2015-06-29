<?php
//include 'C:\wamp\www\fexioapp\library\CMS\Content\Item';
Zend_Loader::loadClass('CMS_Content_Item_Page');

class PageController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
		$pageModel = new Application_Model_DbTable_Page();
		$recentPages = $pageModel->getRecentPages();
        // action body
		if(is_array($recentPages))
		{
			// the 3 most recent items are the featured items
			for($i = 1; $i <= 3; $i++)
			{
				if(count($recentPages) > 0)
				{
					$featuredItems[] = array_shift($recentPages) ;
				}
			}
			$this->view->featuredItems = $featuredItems;
			//var_dump ($featuredItems);
			if(count($recentPages) > 0 )
			{
				$this->view->recentPages = $recentPages;
			}else{
				$this->view->recentPages = null ;
			}
		}
    }

    public function createAction()
    {
        // action body
		$pageForm = new Application_Form_PageForm();
		$request = $this->getRequest();
		if ($request->isPost() && $pageForm->isValid($_POST))
		{
				
				
					//create a new page item
					$itemPage = new CMS_Content_Item_Page();
					$itemsall[] = $pageForm->getValues();
					$items = $itemsall[0];
					//var_dump ($items);
					$itemPage->name = $items['name'];
					$itemPage->headline = $items['headline'];
					$itemPage->description = $items['description'];
					$itemPage->content = $items['content'];
					//upload the image
				
					if ($pageForm->image->isUploaded())
					{
						$pageForm->image->receive();
						$itemPage->image = '/images/upload/' .
						basename($pageForm->image->getFileName());
					}
					//save the content item
					$itemPage->save();
					return $this->_forward('list');
				
		}
				
				
		$pageForm->setAction('/page/create');
		$this->view->form = $pageForm;
    }

    public function listAction()
    {
        // action body
		$pageModel = new Application_Model_DbTable_Page();
		$select = $pageModel->select();
		$select->order('name');
		$currentPages = $pageModel->fetchAll($select);
		if ($currentPages->count() > 0 )
		{
			$this->view->pages = $currentPages ;
		}else{
			
			$this->view->pages = null ;
		}
    }

    public function editAction()
    {
        // action body
		$id = $this->_request->getParam('id');
		$itemPage = new CMS_Content_Item_page($id);
		$pageForm = new Application_Form_PageForm();
		$request = $this->getRequest();
		$pageForm->setAction('/page/edit');
		if ($request->isPost() && $pageForm->isValid($_POST))
		{
			$itemPage->name = $pageForm->getValue('name');
			$itemPage->headline = $pageForm->getValue('headline');
			$itemPage->description = $pageForm->getValue('description');
			$itemPage->content = $pageForm->getValue('content');
			if ($pageForm->image->isUploaded())
			{
					$pageForm->image->receive();
					$itemPage->image = '/images/upload/' . basename($pageForm->image->getFileName());
			}
			//save the content item
			$itemPage->save();
			return $this->_forward('list');
			
		}
		//create the image preview
		$imagePreview = $pageForm->createElement('image', 'image_preview'); 
		//element options
		$imagePreview->setLabel('Preview Image: ');
		$imagePreview->setAttrib('style', 'width:200px;height:auto;');
		//add the element to the form
		$imagePreview->setOrder(4);
		$imagePreview->setImage($itemPage->image);
		$pageForm->addElement($imagePreview);
		
		$this->view->form = $pageForm;
					
    }

    public function deleteAction()
    {
        // action body
		$id = $this->_request->getParam('id');
		$itemPage = new CMS_Content_Item_Page($id);
		$itemPage->delete();
		return $this->_forward('list');
    }

    public function openAction()
    {
        // action body
		//$title = $this->_request->getParam('title');
		$id = $this->_request->getParam('id');
		//first confirm the page exists
		$pageModel = new Application_Model_DbTable_Page();
		if(!$pageModel->find($id)->current())
		{
		//$select = $mdlpage->select();
		//$select->where('name = ?', $title);
		//$row = $mdlpage->fetchRow($select);
			//the error handler will catch this exception
			throw new Zend_Controller_Action_Exception(" The page you requested was not found", 404);
			
		
		}else {
			$this->view->page = new CMS_Content_Item_Page($id);
			
			
		}
		
    }


}














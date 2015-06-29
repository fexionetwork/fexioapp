<?php

class MenuitemController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
		$menu = $this->_request->getParam('menu');
		$mdlMenu = new Application_Model_DbTable_Menus();
		$mdlMenuItem = new Application_Model_DbTable_MenuItem();
		$this->view->menu = $mdlMenu->find($menu)->current();
		$this->view->items = $mdlMenuItem->getItemsByMenu($menu);
    }

    public function addAction()
    {
        // action body
		$menu = $this->_request->getParam('menu');
		$mdlMenu = new Application_Model_DbTable_Menus();
		$this->view->menu = $mdlMenu->find($menu)->current();
		$frmMenuItem = new Application_Form_MenuItem();
		if ($this->_request->isPost())
		{
			if ($frmMenuItem->isValid($_POST))
			{
				$data = $frmMenuItem->getValues();
				//var_dump ($data);
				$mdlMenuItem = new Application_Model_DbTable_MenuItem();
				$mdlMenuItem->addItem($data['menu_id'], $data['label'], $data['page_id'], $data['link']);
				$this->_request->setParam('menu', $data['menu_id']);
				$this->_forward('index');
			}
		}
		$frmMenuItem->populate(array('menu_id' => $menu));
		$this->view->form = $frmMenuItem;
    }

    public function moveAction()
    {
        // action body
		$id = $this->_request->getParam('id');
		$direction = $this->_request->getParam('direction');
		$mdlMenuItem = new Application_Model_DbTable_MenuItem();
		$menuItem = $mdlMenuItem->find($id)->current();
		if ($direction == 'up')
		{
			$mdlMenuItem->moveUp($id);
		}elseif($direction == 'down')
		{
			$mdlMenuItem->moveDown ($id);
		}
		$this->_request->setParam('menu', $menuItem->menu_id);
		$this->_forward('index');
    }

    public function updateAction()
    {
        // action body
		$id = $this->_request->getParam('id');
		//fetch the current item
		$mdlMenuItem = new Application_Model_DbTable_MenuItem();
		$currentMenuItem = $mdlMenuItem->find($id)->current();
		//fetch its menu
		$mdlMenu = new Application_Model_DbTable_Menus();
		$this->view->menu = $mdlMenu->find($currentMenuItem->menu_id)->current();
		//create and populate the form instance
		$frmMenuItem = new Application_Form_MenuItem();
		$frmMenuItem->setAction('/menuitem/update');
		//process the postback
		if ($this->_request->isPost())
		{
			if ($frmMenuItem->isValid($_POST))
			{
				$data = $frmMenuItem->getValues();
				$mdlMenuItem->updateItem($data['id'], $data['label'], $data['page_id'], $data['link']);
				$this->_request->setParam('menu', $data['menu_id']);
				return $this->_forward('index');
			}
		}else {
			$frmMenuItem->populate($currentMenuItem->toArray());
		}
		$this->view->form = $frmMenuItem;
    }

    public function deleteAction()
    {
        // action body
		$id = $this->_request->getParam('id');
		$mdlMenuItem = new Application_Model_DbTable_MenuItem();
		$currentMenuItem = $mdlMenuItem->find($id)->current();
		$mdlMenuItem->deleteItem($id);
		$this->_request->setParam('menu', $currentMenuItem->menu_id);
		$this->_forward('index');
    }


}










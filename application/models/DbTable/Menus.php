<?php

class Application_Model_DbTable_Menus extends Zend_Db_Table_Abstract
{

    protected $_name = 'menus';
	
	protected $dependentTables = array('Application_Model_DbTable_MenuItem');
	protected $_referenceMap = array( 'menu' => array ( 
												'columns' => array ('parent_id'), 
												'refTableClass' => 'Application_Model_DbTable_Menus', 			  												'refColumns' => array('id'), 
												'onDelete' => self::CASCADE, 
												'onUpdate' => self::RESTRICT 
												)
											);
											
	public function createMenu($name)
	{
		$row = $this->createRow();
		$row->name = $name;
		return $row->save();
		
	}
	
	public function getMenus()
	{
		$select = $this->select();
		$select->order('name');
		$menus = $this->fetchAll($select);
		if ($menus->count() > 0)
		{
			return $menus;
		}else{
			return null;
		}
	}

	public function updateMenu ($id, $name)
	{
		$currentMenu = $this->find($id)->current();
		if ($currentMenu)
		{
			$currentMenu->name = $name;
			return $currentMenu->save();
		}else {
			return false;
		}
		
	}
	
	public function deleteMenu ($menuId)
	{
		$row = $this->find($menuId)->current();
		if ($row)
		{
			return $row->delete();
		}else{
			throw new Zend_Exception("Error Loading Menu");
		}
	}

}


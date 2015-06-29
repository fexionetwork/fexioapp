<?php

class Application_Model_DbTable_Page extends Zend_Db_Table_Abstract
{

    protected $_name = 'pages';
	protected $_dependentTables =array('Application_Model_DbTable_ContentNode');
	protected $_referenceMap = array(
		'Page' => array(
			'columns'	=> array('parent_id'),
			'refTableClass' => 'Application_Model_DbTable_Page',
			'refColumns'	=>	array('id'),
			'onDelete'		=> 	self::CASCADE,
			'onUpdate'		=>	self::RESTRICT
			)
		);
	
	public function createPage($name, $namespace, $parentId, $userid)
	{
		//create the new page 
		$row['name'] = $name;
		$row['namespace'] = $namespace;
		$row['parent_id'] = $parentId;
		$row['date_created'] = time();
		$row['user_id'] = $userid;
		$this->insert($row);
		$id = $this->_db->lastInsertid();
		//$row = $this->createRow();
		//$row->name = $name;
		//$row->namespace = $namespace;
		//$row->parent_id = $parentId;
		//$row->date_created = time();
		//unset( $row->id);
		//
		//$row->id = ++$id ;
		//$row->save();
		//now fetch the id of the row you just created
		return $id;
	}

	public function updatePage($id, $data)
	{
		//find the page
		$row = $this ->find($id)->current();
		if ($row) 
		{
			//update each of the colums that are stored in the pages table
			$row->name = $data['name'];
			$row->parent_id = $data['parent_id'];
			$row->save();
			//unset each of the fields that are set in the pages table
			unset($data['id']);
			unset($data['name']);
			unset($data['parent_id']);
			// set each of the other fields in the content_nodes table
			if (count($data) > 0) 
			{
				$mdlContentNode = new Application_Model_DbTable_ContentNode();
				foreach ($data as $key => $value)
				{
					$mdlContentNode->setNode($id, $key, $value);
				}
			}
		} else 
		{
		throw new Zend_Exception("Could not open page to update !");
		}
	}
	public function deletePage($id)
	{
		//find the row that matches the
		$row = $this->find($id)->current();
		if($row)
		{
				$row->delete();
				return true;
		}else
		{
			throw new Zend_Exception("Delect funtion failed could not find file");
			
		}
	}
	public function getRecentPages($count = 10, $namespace = 'page')
    {
        // action body
		$select = $this->select();
		$select->order = 'date_created DESC';
		$select->where('namespace = ?', $namespace);
		$select->limit($count);
		$results = $this->fetchAll($select);
		
		if ($results->count() > 0)
		{
			//cycle through the results, opening each page
			//$pages = array();
			foreach ($results as $result)
			{
				$pages[$result->id] = new CMS_Content_Item_Page($result->id);
			}
			return $pages;
		}else {
			return null;
		}
		//var_dump ($pages);
	}
}
	
	
		



<?php
Zend_Loader::loadClass('CMS_Content_Item_Abstract');

class CMS_Content_Item_Page extends CMS_Content_Item_Abstract
{
	public $id;
	public $name;
	public $headline;
	public $image;
	public $description;
	public $content;
}
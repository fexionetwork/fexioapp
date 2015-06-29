<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initView()
	{
	//initialize view
		$view = new Zend_View();
		$view->doctype('XHTML1_STRICT');
		$view->headTitle('DUPLEX, BUNGALOW, FILLING STATION RENT, BUY SELL ...');
		$view->skin = 'blues';
		
		// Add it to the ViewRenderer
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
		$viewRenderer->setView($view);
		//Return it , so that it can be stored by the bootstrap
		return $view;
	}
	
	protected function _initMenus()
	{
		$view = $this->getResource('view');
		$view->mainMenuId = 1;
		$view->adminMenuId = 2;
		
	}
	
	protected function _initPlugins()
	{
		$dirs = (realpath(dirname(__FILE__) . '/../library/CMS/Controller/Plugin'));
		$filename = 'Acl.php';
		Zend_Loader::loadFile($filename, $dirs, $once=false);
		
	}
	
	protected function _initAutoload()
	{
		$autoloader = Zend_Loader_Autoloader::getInstance();
		$resourceLoader = new Zend_Loader_Autoloader_Resource(array(
					'basePath' => realpath(APPLICATION_PATH . '/../library/CMS'),
					'namespace' => 'CMS_',
		));
		$resourceLoader->addResourceType('model', 'Content/Item', 'Content_Item');
	}
	

}


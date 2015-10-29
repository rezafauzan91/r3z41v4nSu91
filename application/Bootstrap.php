<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	public function _initSession(){
		$session = new Zend_Session_Namespace('session_user');
		Zend_Registry::set('session_user', $session);
	}
	
	 public function  _initRegistry(){
		$this->bootstrap('multidb');
		$docDb = $this->getResource('multidb');
		Zend_Registry::set('db_doc', $docDb->getDb('doc'));
	} 
	
	protected function _initPlugin()
	{
		$this->bootstrap('frontcontroller');
		$frontController = $this->getResource('frontcontroller');
		/* @var $frontController Zend_Controller_Front */
	
		$frontController->registerPlugin(new Application_Plugin_Adminauth());
	}
	
	
}


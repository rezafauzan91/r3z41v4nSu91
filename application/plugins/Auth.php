<?php
class Application_Plugin_Auth extends Zend_Controller_Plugin_Abstract
{
    function preDispatch()
    {
        //$authNamespace = new Zend_Session_Namespace('kuis');
        $authNamespace = Zend_Registry::get('session_doc');
        $a = $this->_request->getControllerName();
         
        
	        if( $this->_request->getControllerName() != 'index'
		    && !isset($authNamespace->user)
		    && $this->_request->getControllerName() != 'register'
		    && $this->_request->getControllerName() != 'api'
		    && $this->_request->getControllerName() != 'veritrans'
	        && $this->_request->getModuleName() != 'admin')
		{
		        if(!isset($authNamespace->user) && $this->_request->getControllerName() != 'login')
		        {
		            $this->_request->setControllerName('login');
		            $this->_request->setActionName('index');
		        }
	        } 
        	
    }
}
<?php
class Application_Plugin_AccessCheck extends Zend_Controller_Plugin_Abstract {
	
	private $_acl = null;
	private $_auth = null;
	
	public function __construct(Zend_acl $acl, Zend_auth $auth){
	
		$this->_acl = $acl;
		$this->_auth = $auth;
	
	}
	
	Public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
    	 
		  $module = $request->getModuleName();
    	  $controller = $request->getControllerName();
    	  $action = $request->getActionName();
		  $session_editor=new Zend_Session_Namespace('session_admin');
		  $role = $session_editor->roles; 
		  $roles=null;
		  if($module!='admin'){
		  	$model_config= new Admin_Model_EditorModel();
		  	$config = $model_config->getMaintain();
		  	if($config[0]['wc_status']=='inactive') {
		  		$session_editor->maintenis = 'maintenis';
		  		$roles = $session_editor->maintenis;
		  		//Zend_Debug::dump($roles);
		  	} else {
		  		unset($session_editor->maintenis);
		  		$roles=null;
		  	}
		  	 
		  }
		
		  //roless
		  if(($role)&&($module=='admin'))
		  {
		  	if(!$this->_acl->isAllowed($role, $controller, $action)){
			  		if($role=='merchant')
					{
						$request->setControllerName('managevoc')
							->setActionName('index');
					}else{
			  		$request->setControllerName('admin')
							->setActionName('index');
					}  
			}
		  }
		  else if(($roles!=null)&&($module!='admin'))
		  {
		  	//if(!$this->_acl->isAllowed($role, $controller, $action)){
		  		if($roles=='maintenis')
		  		{
		  			$request->setControllerName('index')
		  			->setActionName('down');
		  		} 
		  	//}
		  } 
    }
}
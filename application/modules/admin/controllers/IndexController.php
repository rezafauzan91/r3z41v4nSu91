<?php
class Admin_IndexController extends Zend_Controller_Action {
	public function indexAction() {
		$this->_helper->layout->disableLayout();
		$this->view->title = "Login Admin";
		
		if ($this->_request->isPost()) {
			$dataform = $this->_request->getPost();
			$user = $dataform['username'];
			$pwd = $dataform['password'];
			//$model = new Admin_Model_EditorModel();
			//$data = $model->getAccount($user);
			if(!empty($user)){
				//$passencrypt = md5($user.$pwd);
				
				//$password = $data[0]['ua_password'];
			
				if($pwd!= null) {
					$sessionadmin = Zend_Registry::get('session_admin');
					$sessionadmin->user_id = $user;
					$sessionadmin->noreg = $user;
					//$sessionadmin->roles = $;
					//roles merchant store
					$this->_helper->redirector('index','dashboard','admin');
				} else {
					$this->view->message = 'Wrong Password or Email, Please Try Again..';
				}
			}else{
				$this->view->message = 'Wrong Password or Email, Please Try Again..';
			}
			
		}
	}
	
	public function logoutAction() {
	  Zend_Session::destroy(true);
      $this->_helper->redirector('index','index','admin');	
	}
}

<?php
class Admin_DashboardController extends Zend_Controller_Action {
	
	public function indexAction() {
		$this->_helper->layout->setLayout('layoutadmin');
	}
	
	/* public function maintainAction() {
		$model = new Admin_Model_EditorModel();
		$session_editor=new Zend_Session_Namespace('session_admin');
		$roles = $session_editor->roles;
	
		$this->view->roles =  $session_editor->roles;
		if ($this->_request->isPost()) {
			$Dataform = $this->_request->getPost();
			//Zend_Debug::dump($Dataform);die();
			$user = $session_editor->user_id;
			if(!empty($Dataform['akses']))
			{
				$update = $model->updatemain($Dataform, $user);
					
				if($update===true) {
					$this->view->msg = 'Update Success';
				} else {
					$this->view->message = 'Update Failed';
				}
			}elseif($Dataform['key_vt']!=''){
				$update = $model->updatekeyver($Dataform);
					
				if($update===true) {
					$this->view->msg = 'Update Success';
				} else {
					$this->view->message = 'Update Failed';
				}
			}
			
		}
		$data = $model->getMaintain();
		$this->view->detail = $data;
	} */
}
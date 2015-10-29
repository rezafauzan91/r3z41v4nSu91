<?php
class Admin_UseradminController extends Zend_Controller_Action {
	
	public function init() {
	  //This will catch any messege set in any action in this controller and send
	  //it to the view on the next request.
	  	if ($this->_helper->FlashMessenger->hasMessages()) {
	   		$this->view->messages = $this->_helper->FlashMessenger->getMessages();
		}
	}

	public function indexAction() {
		$this->_helper->layout->setLayout('layoutadmin');
		$model = new Admin_Model_UseradminModel();
		$data = $model->getAdminlist();
		$this->view->data = $data;
	}

	public function addAction() {
		$this->_helper->layout->setLayout('layoutadmin');
		if ($this->_request->isPost()) {
			$model = new Admin_Model_UseradminModel();
			$Dataform = $this->_request->getPost();
			//Zend_Debug::dump($Dataform);die();	
			if($Dataform['firstname']==null || $Dataform['email']==null || $Dataform['password']==null || $Dataform['confirm_password']==null) {
				$this->view->message = 'Please Fill out The Form First!';
			} else if (!filter_var($Dataform['email'], FILTER_VALIDATE_EMAIL)) {
				$this->view->message = "Invalid email format"; 
			} else if($Dataform['password']!=$Dataform['confirm_password']) {
				$this->view->message = "Password not match";
			} else {
				$time = new Zend_Date();
				$tgl = $time->get('YYYY-MM-dd HH:mm:ss');
				$cekemail = $model->cekAdmin($Dataform['email']);
				//Zend_Debug::dump(count($cekemail));die();
				if(count($cekemail)==0) {	
					$password = md5($Dataform['email'].$Dataform['password']);
					$insert = $model->insertAdmin($Dataform, $password);

					if($insert===true) {
						//zend_debug::dump($insert);die();
						$this->view->msg = '<div class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						Insert Success!</div>';
					} else {
						$this->view->message = '<div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						Insert Failed!
						</div>';
					}
				} else {
					$this->view->message = '<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					Email is Already Use!
					</div>';
				}
			}		
		}
	}

	public function editAction() {
		$this->_helper->layout->setLayout('layoutadmin');
		$model = new Admin_Model_UseradminModel();
		$req = $this->getRequest();
		$id = $req->getParam('p');
		
		$det = $model->getAdmindet($id);
		$this->view->det = $det;
		if ($this->_request->isPost()) {
			$Dataform = $this->_request->getPost();
			/* Zend_Debug::dump($Dataform);die(); */
			if($Dataform['firstname']==null) {
				$this->view->message = '<div class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				Please Fill out The Form First!
				</div>';
			} else if($Dataform['password']!=''|| $Dataform['password']!=null) {
				if($Dataform['password']!=$Dataform['confirm_password']) {
					$this->view->message = '<div class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				Password not match!
				</div>';
				} else {
					$time = new Zend_Date();
					$tgl = $time->get('YYYY-MM-dd HH:mm:ss');
					$password = md5($Dataform['email'].$Dataform['password']);
					//Zend_Debug::dump($Dataform);die();
					$insert = $model->updateAdminPass($Dataform, $password, $tgl);
				}
			}
			else
			{
				$time = new Zend_Date();
				$tgl = $time->get('YYYY-MM-dd HH:mm:ss');
				//Zend_Debug::dump($Dataform);die();
				$insert = $model->updateAdmin($Dataform, $tgl);
				/* Zend_Debug::dump($insert);die(); */
			}
		
			if($insert===true) {
				$this->view->msg = '<div class="alert alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				Edit Success!
				</div>';
			} else {
				$this->view->message = '<div class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				Edit Failed!
				</div>';
			}
		
		}
		
		$id = $req->getParam('p');
		if($id!='') {
			$det = $model->getAdmindet($id);
			$this->view->det = $det;
		}
	}
	
	public function deleteAction() {
		$model = new Admin_Model_UseradminModel();
		$req = $this->getRequest();
		$id = $req->getParam('key');
		$delete = $model->delAdmin($id);
		
		// return $this->_helper->json(
		// 	array(
		// 		'edit' => $delete,
		// 	)
		// );
		

		if($delete===true){
			$this->_helper->flashMessenger->addMessage('Delete Success!');
			return $this->_helper->redirector('index','useradmin','admin');
		}else{
			$this->_helper->flashMessenger->addMessage('Delete Failed!');
			return $this->_helper->redirector('index','useradmin','admin');

		}
	}	
}
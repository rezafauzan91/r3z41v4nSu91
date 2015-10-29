<?php
class Admin_Model_DbTables_UseradminModel extends Zend_Db_Table_Abstract {

	public function getAccount($email) {
		try {
			$select="SELECT * FROM  useradmin
					 WHERE  ua_email='".$email."' and status = '0'";
			$rows=$this->_db->fetchAll($select);
			return $rows;
		} catch (Zend_Exception $e) {
			return $e->getMessage();
		}
	}
	
	/* public function getAdminlist($roles) {
		try {
			if($roles == 'administrator'){
				$select="SELECT * FROM useradmin";
			}else{
				$select="SELECT * FROM useradmin where status = '0'";
			}
			$rows=$this->_db->fetchAll($select);
			return $rows;
		} catch (Zend_Exception $e) {
			return $e->getMessage();
		}
	} */
	
	public function getAdminlist() {
		try {
				$select="SELECT * FROM useradmin";
				$rows=$this->_db->fetchAll($select);
				return $rows;
		} catch (Zend_Exception $e) {
			return $e->getMessage();
		}
	}
	
	public function getAdmindet($id) {
		try {
			$select="SELECT * FROM useradmin where ua_admin_id='".$id."'";
			$rows=$this->_db->fetchAll($select);
			return $rows;
		} catch (Zend_Exception $e) {
			return $e->getMessage();
		}
	}
	
	public function updateAdmin($data,$time) {
		try {
			$stmt=$this->_db->prepare("UPDATE useradmin SET
										ua_firstname=:title,
										ua_email=:email,
										ua_modified=:modified,
										ua_akses=:akses
									   WHERE ua_admin_id=:id" );
	
			$stmt->bindParam(':id', $data['id']);
			$stmt->bindParam(':title', $data['firstname']);
			$stmt->bindParam(':email', $data['email']);
			$stmt->bindParam(':modified', $time);
			$stmt->bindParam(':akses', $data['akses']);
			$a = $stmt->execute();
	
			return true;
		} catch (Zend_Exception $e) {
			return array("sts"=>false,"msg"=>$e->getMessage());
		}
	}
	
	public function updateAdminPass($data,$password,$time) {
		try {
			$stmt=$this->_db->prepare("UPDATE useradmin SET
										ua_firstname=:title,
										ua_email=:email,
										ua_password=:password,
										ua_modified=:modified,
										ua_akses=:akses
									   WHERE ua_admin_id=:id" );
	
			$stmt->bindParam(':id', $data['id']);
			$stmt->bindParam(':title', $data['firstname']);
			$stmt->bindParam(':email', $data['email']);
			$stmt->bindParam(':password', $password);
			$stmt->bindParam(':modified', $time);
			$stmt->bindParam(':akses', $data['akses']);
			$a = $stmt->execute();
	
			return true;
		} catch (Zend_Exception $e) {
			return array("sts"=>false,"msg"=>$e->getMessage());
		}
	}
	
	public function delAdmin($id) {
		//Zend_Debug::dump($id);die();
		try{
			$stmt1 = $this->_db->prepare("DELETE FROM useradmin where ua_admin_id=:id");
			$stmt1->bindParam(':id', $id);
			$a = $stmt1->execute();
				
			return $a;
		}catch(Zend_Db_Exception $e){
	
			return array("sts"=>false,"msg"=>$e->getMessage());
	
		}
	}
	
	public function updstatAdmin($id,$stat) {
		try {
			$stmt=$this->_db->prepare("UPDATE useradmin SET
										status=:stat
									   WHERE ua_admin_id=:id" );
				
			$stmt->bindParam(':id', $id);
			$stmt->bindParam(':stat', $stat);
			
			$a = $stmt->execute();
	
			return true;
		} catch (Zend_Exception $e) {
			return array("sts"=>false,"msg"=>$e->getMessage());
		}
	}
	
	public function insertAdmin($data, $password) {
		try {
		
			$stmt=$this->_db->prepare("INSERT INTO useradmin
													(
														ua_firstname,
														ua_email,
														ua_password,
														ua_akses
													)
													VALUES
													(
														:title,
														:email,
														:password,
														:akses
													)
													"
			);
			$stmt->bindParam(':title', $data['firstname']);
			$stmt->bindParam(':email', $data['email']);
			$stmt->bindParam(':password', $password);
			$stmt->bindParam(':akses', $roles='administrator');
			
			$a = $stmt->execute();
			
			return true;
		} catch (Zend_Exception $e) {
			return $e->getMessage();
		}
	}
	
	public function cekAdmin($id) {
		try {
			$select="SELECT * FROM useradmin where ua_email='".$id."'";
			$rows=$this->_db->fetchAll($select);
			return $rows;
		} catch (Zend_Exception $e) {
			return $e->getMessage();
		}
	}
	
	public function search($kategori, $kunci) {
		try {
			if($kategori=='all'){
				$select="SELECT * FROM useradmin order by ua_created desc";
				$rows=$this->_db->fetchAll($select);
				return $rows;
			} else if($kategori=='firstname') {
				$select="SELECT * FROM useradmin where ua_firstname like'%".$kunci."%'";
				$rows=$this->_db->fetchAll($select);
				return $rows;
	 
			} else if($kategori=='lastname') {
				$select="SELECT * FROM useradmin where ua_lastname like'%".$kunci."%'";
				$rows=$this->_db->fetchAll($select);
				return $rows;
	
			} else if($kategori=='email') {
				$select="SELECT * FROM useradmin where ua_email like'%".$kunci."%'";
				$rows=$this->_db->fetchAll($select);
				return $rows;
	
			} else if($kategori=='akses') {
				$select="SELECT * FROM useradmin where ua_akses like'%".$kunci."%'";
				$rows=$this->_db->fetchAll($select);
				return $rows;
	
			}
				
		} catch (Zend_Exception $e) {
			return $e->getMessage();
		}
	}
	
	public function getMaintain() {
		try {
			$select="SELECT * FROM webconfig";
			$rows=$this->_db->fetchAll($select);
			return $rows;
		} catch (Zend_Exception $e) {
			return $e->getMessage();
		}
	}
	
	public function updatemain($data,$user) {
		try {
			$stmt=$this->_db->prepare("UPDATE webconfig SET
										wc_status=:title,
										wc_post_by=:user
									   WHERE wc_id='1'" );
	
			$stmt->bindParam(':title', $data['akses']);
			$stmt->bindParam(':user', $user);
			$a = $stmt->execute();
	
			return true;
		} catch (Zend_Exception $e) {
			return array("sts"=>false,"msg"=>$e->getMessage());
		}
	}
	
	public function updatekeyver($data) {
		try {
			$stmt=$this->_db->prepare("UPDATE webconfig SET
										wc_status=:title,
										wc_post_by=:key
									   WHERE wc_id='2'" );
	
			
			$stmt->bindParam(':title', $data['akses_prod']);
			$stmt->bindParam(':key', $data['key_vt']);
			$a = $stmt->execute();
	
			return true;
		} catch (Zend_Exception $e) {
			return array("sts"=>false,"msg"=>$e->getMessage());
		}
	}
}
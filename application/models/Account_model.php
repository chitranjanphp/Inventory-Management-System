<?php
class Account_model extends CI_Model{
	
	private $table1="users";
	private $table2="addressbook";
	
	function __construct(){
		parent::__construct(); 
	}
	
	public function checkUser($data){
		$this->db->where($data);
		$this->db->from("inv_users");
		return $this->db->count_all_results();
	}	
	
	public function register($data){
		$salt=random_string('alnum', 16);
		$password=md5($data['password'].SITE_SALT.$salt);
		$otp=random_string('numeric',6);
		$encotp=md5($otp.SITE_SALT.$salt);
		$data['password']=$password;
		$data['salt']=$salt;
		$data['otp']=$encotp;
		$data['created_on']=date('Y-m-d H:i:s');
		$data['updated_on']=date('Y-m-d H:i:s');
		$data['status']=0;
		if($this->db->insert("inv_users",$data)){
			return array("status"=>true,"otp"=>$otp);
		}
	}
	
	public function login($data){
		$username=$data['username'];		
		$password=$data['password'];
		$this->db->where('username', $username);
		$this->db->or_where('mobile', $username); 
		$query = $this->db->get_where("inv_users");
		$result=$query->row_array();
		if(!empty($result)){
			$salt=$result['salt'];
			$password=md5($password.SITE_SALT.$salt);
			$hashpassword=$result['password'];
			if($password==$hashpassword){
				$result['verify']=true;
			}
		}
		if(!isset($result['verify'])){ $result=array('verify'=>"Wrong Password!"); }
		return $result;
	}
	
	
	public function signup($data){
		$salt=random_string('alnum', 16);
		$password=md5($data['password'].SITE_SALT.$salt);
		$otp=random_string('numeric',6);
		$encotp=md5($otp.SITE_SALT.$salt);
		$data['password']=$password;
		$data['salt']=$salt;
		$data['otp']=$encotp;
		$data['created_on']=date('Y-m-d H:i:s');
		$data['updated_on']=date('Y-m-d H:i:s');
		$data['status']=0;
		if($this->db->insert("inv_users",$data)){
			return array("status"=>true,"otp"=>$otp);
		}
	}
	
	public function sendotp($mobile){
		$where['mobile']=$mobile;
		$query = $this->db->get_where("inv_users",$where);
		$result=$query->row_array();
		$otp=random_string('numeric',6);
		$encotp=md5($otp.SITE_SALT.$result['salt']);
		$data['otp']=$encotp;
		$data['updated_on']=date('Y-m-d H:i:s');
		$this->db->where($where);
		if($this->db->update("inv_users",$data)){
			if($result['status']==1){ $type="login"; }
			else{ $type="activate"; }
			return array("status"=>true,"otp"=>$otp, "type"=>$type);
		}
	}
	
	public function verifyotp($data){
		$mobile=$data['mobile'];		
		$otp=$data['otp'];
		$where['mobile']=$mobile;
		$query = $this->db->get_where("inv_users",$where);
		$result=$query->row_array();
		if(!empty($result)){
			if(time()-strtotime($result['updated_on'])<900){
				$salt=$result['salt'];
				$otp=md5($otp.SITE_SALT.$salt);
				$hashotp=$result['otp'];
				if($otp==$hashotp){
					$this->db->where($where);
					$this->db->update("inv_users",array("status"=>1));
					$result['verify']=true;
				}
			}
			else{
				$result['verify']="OTP Expired!";
			}
		}
		if(!isset($result['verify'])){ $result['verify']="Invalid OTP!"; }
		return $result;
	}
	
	public function getuser($user){
		$where="md5(id)='$user'";
		$query = $this->db->get_where("inv_users",$where);
		$result=$query->row_array();
		return $result;
	}
	
	public function updatepassword($data){
		$oldpass=$data['oldpass'];
		$password=$data['password'];
		$user=$data['user'];
		$where="md5(id)='$user'";
		$query = $this->db->get_where("inv_users",$where);
		$result=$query->row_array();
		$checkpass=false;
		if(!empty($result)){
			$salt=$result['salt'];
			$oldpass=md5($oldpass.SITE_SALT.$salt);
			$hashpassword=$result['password'];
			if($oldpass==$hashpassword){
				$checkpass=true;
				$password=md5($password.SITE_SALT.$salt);
				$this->db->where($where);
				$this->db->update("inv_users",array("password"=>$password));
			}
		}
		return $checkpass;
	}
	
	public function addAddress($data){
		$where="md5(id)='$data[user_id]'";
		$query = $this->db->get_where("inv_users",$where);
		$user=$query->row_array();
		$data['user_id']=$user['id'];
		unset($data['address_id']);
		if($this->db->insert($this->table2,$data)){
			return true;
		}
	}
	
	public function updateAddress($data){
		$where['id']=$data['address_id'];
		unset($data['address_id']);
		unset($data['user_id']);
		$this->db->where($where);
		if($this->db->update($this->table2,$data)){
			return true;
		}
	}
	
	public function deleteaddress($id){
		$this->db->delete($this->table2, array('id' => $id)); 
	}
	
	public function getaddressbook($user){
		$where="md5(user_id)='$user'";
		$query = $this->db->get_where($this->table2,$where);
		$result=$query->result_array();
		return $result;
	}
	public function getaddress($id){
		$where="id='$id'";
		$query = $this->db->get_where($this->table2,$where);
		$result=$query->row_array();
		return $result;
	}
	
	
}
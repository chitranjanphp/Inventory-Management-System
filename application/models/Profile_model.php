<?php
class Profile_model extends CI_Model{
	
	function __construct(){
		parent::__construct(); 
	}
	
	public function get_user_profile($loguser){
		$query = $this->db->get_where("inv_users",array('id'=>$loguser));
		$result=$query->row_array();
		return $result;
	}	
	public function update_profile_data($id,$userdata){
	   $query=$this->db->get_where("inv_users",array("id"=>$id));
	   $getuser=$query->row_array();
	   if($getuser['password']!=$userdata['password']){
		 $salt=random_string('alnum', 16);
		 $password=md5($userdata['password'].SITE_SALT.$salt); 
		 $userdata['salt']=$salt;  
		 $userdata['password']=$password;
	   }
	   $userdata['updated_on']=date('Y-m-d H:i:s');
	   $this->db->where('id',$id);
	   $status=$this->db->update("inv_users",$userdata);	
	   if($status===true){
		   return true;   
	   }else{
		   return $this->db->error();
	   }
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
	
	
}
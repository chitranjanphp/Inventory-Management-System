<?php
class User_model extends CI_Model{
	
	private $table1="users";
	private $table2="addressbook";
	
	function __construct(){
		parent::__construct(); 
		$this->db->db_debug=false;
	}
	
	public function adduserdata($userdata){
		$salt=random_string('alnum', 16);
		$password=md5($userdata['password'].SITE_SALT.$salt);
		$otp=random_string('numeric',6);
		$encotp=md5($otp.SITE_SALT.$salt);
		$userdata['password']=$password;
		$userdata['salt']=$salt;
		$userdata['otp']=$encotp;
		$userdata['created_on']=date('Y-m-d H:i:s');
		$userdata['updated_on']=date('Y-m-d H:i:s');
		$userdata['status']=1;
	   $status=$this->db->insert("inv_users",$userdata);	
	   if($status===true){
		   return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	public function userlist(){
		$sql="SELECT t1.*,t2.shop_name
			  FROM inv_users as t1
			  LEFT JOIN inv_shops as t2 ON t1.shop=t2.id";
		$query=$this->db->query($sql);
		//echo $this->db->last_query();
		$array=$query->result_array();
		return $array;
	}
	public function getsingleuser($id){
	   $query=$this->db->get_where("inv_users",array("id"=>$id));	
	   $array=$query->row_array();
	   if(is_array($array)){
	     return $array;
	   }else{
		  return false;   
	   }
	}
	public function updateuserdata($id,$userdata){
	   $query=$this->db->get_where("inv_users",array("id"=>$id));
	   $getuser=$query->row_array();
	   if($getuser['password']!=$userdata['password']){
		 $salt=random_string('alnum', 16);
		 $password=md5($userdata['password'].SITE_SALT.$salt); 
		 $userdata['salt']=$salt;  
		 $userdata['password']=$password;
	   }
	   $this->db->where('id',$id);
	   $status=$this->db->update("inv_users",$userdata);	
	   if($status===true){
		   return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	public function deleteuser($id){
	   $this->db->where('id',$id);
	   $status=$this->db->delete("inv_users");	
	   if($status===true){
		   return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	
}
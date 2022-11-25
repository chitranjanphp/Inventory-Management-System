<?php
class Enquiry_model extends CI_Model{
	
	function __construct(){
		parent::__construct(); 
		$this->db->db_debug=false;
	}
	public function add_enquiry_data($enquirydata){
	   $status=$this->db->insert("inv_enquiry",$enquirydata);	
	   if($status===true){
		   return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	public function fetchmobile($mobile){
	  $status=$this->db->get_where("inv_enquiry",array("mobile"=>$mobile));	

	  //echo $this->db->last_query();
	  
	  if($status->num_rows()>0){
		return true;  
	  }else{
		return false;  
	  }
	  
	}
	
}
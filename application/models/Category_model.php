<?php
class Category_model extends CI_Model{
	
	function __construct(){
		parent::__construct(); 
		$this->db->db_debug=false;
	}
	public function allcategory($where=array()){
		$query=$this->db->get_where("product_categories",$where);
		//echo $this->db->last_query();
		$array=$query->result_array();
		return $array;
	}
	public function addcategorydata($categorydata){
	   $status=$this->db->insert("product_categories",$categorydata);	
	   if($status===true){
		   return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	
	public function getsinglecategory($id){
	   $query=$this->db->get_where("product_categories",array("id"=>$id));	
	   $array=$query->row_array();
	   return $array;
	}
	public function updatecategory($id,$categorydata){
	   $this->db->where('id',$id);
	   $status=$this->db->update("product_categories",$categorydata);	
	   if($status===true){
		   return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	public function deletecategory($id){
	   $this->db->where('id',$id);
	   $status=$this->db->delete("product_categories");	
	   if($status===true){
		   return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	
}
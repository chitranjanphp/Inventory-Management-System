<?php
class SubCategory_model extends CI_Model{
	
	function __construct(){
		parent::__construct(); 
		$this->db->db_debug=false;
	}
	public function allsubcategory($where=array()){
		$this->db->select('t1.id,t1.subcategory,t2.category');
		$this->db->from('product_subcategories as t1');
		$this->db->join('product_categories as t2','t1.category_id=t2.id','left');
		$query=$this->db->get();
		//echo $this->db->last_query();
		$array=$query->result_array();
		return $array;
	}
	public function addsubcategorydata($subcategorydata){
	   $status=$this->db->insert("product_subcategories",$subcategorydata);	
	   if($status===true){
		   return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	
	public function getsinglesubcategory($id){
	   $query=$this->db->get_where("product_subcategories",array("id"=>$id));	
	   $array=$query->row_array();
	   return $array;
	}
	public function updatesubcategory($id,$subcategorydata){
	   $this->db->where('id',$id);
	   $status=$this->db->update("product_subcategories",$subcategorydata);	
	   if($status===true){
		   return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	public function deletesubcategory($id){
	   $this->db->where('id',$id);
	   $status=$this->db->delete("product_subcategories");	
	   if($status===true){
		   return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	public function subcatbycategory($category_id){
		$query=$this->db->query("SELECT psc.id, psc.subcategory
								FROM product_subcategories AS psc
								WHERE psc.category_id = $category_id 
								ORDER BY psc.id DESC;");
		 //echo $this->db->last_query();
		$array=$query->result_array();
		return $array;
	}
	
}
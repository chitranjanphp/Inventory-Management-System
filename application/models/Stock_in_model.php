<?php
class Stock_in_model extends CI_Model{
	
	function __construct(){
		parent::__construct(); 
		$this->db->db_debug=false;
	}
	public function productlist(){
		$sql="SELECT t1.*,t2.product_name,t2.hsn_code,t3.category,t4.subcategory,t5.unit_name
			  FROM stock_in AS t1
			  LEFT JOIN inv_products AS t2 ON t1.product_id=t2.id
			  LEFT JOIN product_categories AS t3 ON t2.category_id=t3.id
			  LEFT JOIN product_subcategories AS t4 ON t2.subcategory_id=t4.id
			  LEFT JOIN product_units AS t5 ON t2.unit_id=t5.unit_id"; 
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	public function get_product_sprice($id){
	  $query=$this->db->get_where("stock_in",array("id"=>$id));	
	  return $query->row_array();
	}
	public function updateprice($id,$pricedata){
		$this->db->where("id",$id);
		$status=$this->db->update("stock_in",$pricedata);
		if($status===true){
		  return true;	
		}else{
		   return $this->db->error();	
		}
	}
	public function my_products(){
		$sql="SELECT t1.barcode,t2.product_name
			  FROM stock_in AS t1
			  LEFT JOIN inv_products AS t2 ON t1.product_id=t2.id"; 
	    $query=$this->db->query($sql);
		return $query->result_array();	
	}
}
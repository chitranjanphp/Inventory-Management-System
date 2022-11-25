<?php
class Products_model extends CI_Model{
	
	function __construct(){
		parent::__construct(); 
		$this->db->db_debug=false;
	}
	public function productlist(){
		$sql="SELECT t1.id,t1.product_name,t1.hsn_code,t1.barcode,t1.cgst,t1.sgst,t2.category,t3.subcategory,t4.unit_name
								 FROM inv_products AS t1
								 LEFT JOIN product_categories AS t2 ON t1.category_id=t2.id
								 LEFT JOIN product_subcategories AS t3 ON t1.subcategory_id=t3.id
								 LEFT JOIN product_units AS t4 ON t1.unit_id=t4.unit_id";
		//if($keyword!=''){$sql.=" WHERE t1.product_name LIKE '%".$keyword."%'";}					 
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	public function saveproduct($productdata){
	   $status=$this->db->insert("inv_products",$productdata);	
	   if($status===true){
		   return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	
	public function getsingleproduct($id){
	   $query=$this->db->get_where("inv_products",array("id"=>$id));	
	   $array=$query->row_array();
	   return $array;
	}
	public function updateproduct($id,$productdata){
	   $this->db->where('id',$id);
	   $status=$this->db->update("inv_products",$productdata);	
	   if($status===true){
		   return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	public function deleteproduct($id){
	   $this->db->where('id',$id);
	   $status=$this->db->delete("inv_products");	
	   if($status===true){
		   return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	public function UOM($barcode){
	  $query=$this->db->query("SELECT t1.id,t2.unit_name
								 FROM inv_products AS t1
								 LEFT JOIN product_units AS t2 ON t1.unit_id=t2.unit_id
								 WHERE t1.barcode=$barcode;");
		return $query->row_array();	
	}
	public function getProductIdByBarcode($barcode){
		$query = $this->db->query("SELECT id as product_id
                                   FROM inv_products
                                   WHERE barcode = '$barcode';");
		return $query->row_array();
	}
}
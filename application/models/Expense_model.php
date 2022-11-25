<?php
class Expense_model extends CI_Model{
	
	function __construct(){
		parent::__construct(); 
		$this->db->db_debug=false;
	}
	public function addexpense($expensedata){
	   $status=$this->db->insert("expenses",$expensedata);	
	   if($status===true){
		   return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	public function expenselist($from="",$to=""){
		$user=$this->session->userdata('user');
		$role=$this->session->userdata('role');
		$sql="SELECT * FROM expenses WHERE 1";
		if($role!='Admin'){
		    $sql.=" AND user=$user";
		 }
		if($from!='' && $to==''){ $from=$to=$from;$sql.=" AND date BETWEEN '$from' AND '$to'";}
		elseif($from=='' && $to!=''){ $from=$to=$to;$sql.=" AND date BETWEEN '$from' AND '$to'";}
		elseif($from!='' && $to!=''){ $from=$from;$to=$to;$sql.=" AND date BETWEEN '$from' AND '$to'";}
		$sql.=" ORDER BY date desc";
		$query=$this->db->query($sql);
		$array=$query->result_array();
		return $array;
	}
	public function getsingleexpense($id){
	   $query=$this->db->get_where("expenses",array("id"=>$id));	
	   $array=$query->row_array();
	   return $array;
	}
	public function updateexpense($id,$expensedata){
	   $this->db->where('id',$id);
	   $status=$this->db->update("expenses",$expensedata);	
	   if($status===true){
		   return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	public function deleteexpense($id){
	   $this->db->where('id',$id);
	   $status=$this->db->delete("expenses");	
	   if($status===true){
		   return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	public function activeshops($where=array('status'=>1)){
		$query=$this->db->get_where("inv_shops",$where);
		//echo $this->db->last_query();
		$array=$query->result_array();
		return $array;
	}
		
}
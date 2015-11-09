<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class ProductFlow_model extends CI_Model {
public $table='pro_flow'; 
/***
table:pro_flow
flow_id, flow_object, flow_location, flow_count, flow_type, flow_user, flow_date
***/ 
 function detail($id,$field='flow_id'){
	$sql="select flow_id, flow_object, flow_location, flow_count, flow_type, flow_user, flow_date
	from {$this->table} where $field=$id";	 
	$data=dbFetchOne($sql); 
	if($data==false)return false;
	$clean_data=dbCleanField($data,'flow_'); 
	return $clean_data ;	
 }
 
function total($group=0){
	 
	$sql="select count(flow_id) total from {$this->table} ";
	$data=dbFetchOne($sql);
	return isset($data['total'])?$data['total']:false;
	
}
 function totalInLocation($id,$location){
	$sql="select sum(flow_count) total from {$this->table} where flow_object=$id and flow_location=$location";	 
	$data=dbFetchOne($sql);
	return $data['total'];
}
 public function __construct()
 {
    $this->load->database();
	$this->load->helper('date_helper');
 }

}
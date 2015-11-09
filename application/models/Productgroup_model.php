<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class ProductGroup_model extends CI_Model {
public $table='pro_groups'; 
/***
table:pro_groups
group_id, group_name, group_detail, group_created, group_modified
***/
function total($group=0){
	 
	$sql="select count(group_id) total from {$this->table} ";
	$data=dbFetchOne($sql);
	return isset($data['total'])?$data['total']:false;
	
}
 
 function detail($id,$field='group_id'){
	$sql="select group_id, group_name, group_detail, group_created, group_modified from {$this->table} where $field=$id";
	 
	$data=dbFetchOne($sql); 
	if($data==false)return false;
	$clean_data=dbCleanField($data,'group_'); 
	return $clean_data ;
 }
 
 public function __construct()
 {
    $this->load->database();
	$this->load->helper('date_helper');
 }

}
<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class ProductCategory_model extends CI_Model {
public $table='pro_category';
/***
table:category
cat_id, cat_name, cat_detail, cat_group, cat_modified
***/
function detail($id,$field='cat_id'){
	$sql="select cat_id, cat_name, cat_detail, cat_group, cat_modified
	from {$this->table} where $field=$id";	 
	$data=dbFetchOne($sql); 
	if($data==false)return false;
	$clean_data=dbCleanField($data,'cat_'); 
	return $clean_data ;	
 }
 
function listAll($group){
	if(!is_array($group)){ $group=array($group); }
	$val="'".implode("','", $group)."'";
	$sql="select cat_id id,cat_group `group` from {$this->table} where `cat_group` in($val) order by cat_name asc";
	
	$res=dbFetch($sql);
	$data=array();
	foreach($res as $row0){
		$group=$this->group->detail($row0['group']);
		$row=$this->detail($row0['id']);
		$data[$row['group'].".$group[name]"][$row['id']]=$row['name']." (".$row['detail'].")";
	}
 
	return $data;
}

function total($group=0){
	if($group==0){
		$group=62;
	}else{}
	if(!is_array($group)){ $group=array($group); }
	//SELECT * FROM `pro_category` WHERE  `cat_group` in( 62,34)
	$val="'".implode("','", $group)."'";
	$sql="select count(cat_id) total from {$this->table} where `cat_group` in($val)";
	$data=dbFetchOne($sql);
	return isset($data['total'])?$data['total']:false;
	
}


 public function __construct()
 {
    $this->load->database();
	$this->load->helper('date_helper');
 }

}
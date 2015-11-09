<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class ProductObject_model extends CI_Model {
public $table='pro_object';
/***
table:pro_object
obj_id, obj_name0, obj_name, obj_outmax, obj_warnmin, obj_detail, obj_tag, obj_entity, obj_status, obj_group, obj_created, obj_edited, obj_category
***/
  function detail($id,$field='obj_id'){
	$sql="select d.*
	from {$this->table} d where $field=$id";	 
	$data=dbFetchOne($sql); 
	if($data==false)return false;
	$clean_data=dbCleanField($data,'obj_'); 
	if($clean_data['code']==''){
		$clean_data['code']=sprintf("%07X",dbId('', 100,3) );
		$data=array('obj_code'=>$clean_data['code']);
		$where="obj_id=$clean_data[id]";
		$str = $this->db->update_string($this->table, $data, $where);
		dbQuery($str,1);
		 
	}else{}
	return $clean_data ;
 } 
 
function total($group=0){
	if($group==0){
		$group=62;
	}else{}
	if(!is_array($group)){ $group=array($group); }
	//SELECT * FROM `pro_category` WHERE  `cat_group` in( 62,34)
	$val="'".implode("','", $group)."'";
	$sql="select count(obj_id) total from {$this->table} where `obj_group` in($val)";
	$data=dbFetchOne($sql);
	return isset($data['total'])?$data['total']:false;
	
}

function totalSearch($group=0,$search=''){
	if($group==0){
		$group=62;
	}else{}
	if(!is_array($group)){ $group=array($group); }
	if($search!=''){
		$search=addslashes($search);
		$whereSearch="obj_name like '%$search%' or obj_name0 like '%$search%' or obj_detail like '%$search%' or  obj_tag like '%$search%' ";		
	}else{ 
		$whereSearch="";
	}
	$val="'".implode("','", $group)."'";
	$sql="select count(obj_id) total from {$this->table} where `obj_group` in($val) and ($whereSearch)";
	$data=dbFetchOne($sql);
	return isset($data['total'])?$data['total']:false;
	
}
 
function listAll($group=0){
	if(!is_array($group)){ $group=array($group); }
	$val="'".implode("','", $group)."'";
	$sql="select obj_id id,obj_name0 name,obj_detail detail, obj_group `group` 
	from {$this->table} where `obj_group` in($val) order by obj_name asc";
	$res=dbFetch($sql);
	$data=array();
	foreach($res as $row){
		$group=$this->group->detail($row['group']);
		$data[$row['group'].".$group[name]"][$row['id']]=$row['name'];
	}
	return $data;
}

 public function __construct()
 {
    $this->load->database();
	$this->load->helper('date_helper');
 }

}
<?php  
class ProductLocation_model extends CI_Model {
public $table='pro_location';
/***
table:pro_location
loc_id, loc_name, loc_map, loc_detail, loc_group, loc_modified
***/
 function detail($id,$field='loc_id'){
	$sql="select loc_id, loc_name, loc_map, loc_detail, loc_group, loc_modified
	from {$this->table} where $field=$id";	 
	$data=dbFetchOne($sql); 
	if($data==false)return false;
	$clean_data=dbCleanField($data,'loc_'); 
	return $clean_data ;
 }
 
function total($group=0){
	if($group==0){
		$group=62;
	}else{}
	if(!is_array($group)){ $group=array($group); }
	//SELECT * FROM `pro_category` WHERE  `cat_group` in( 62,34)
	$val="'".implode("','", $group)."'";
	$sql="select count(loc_id) total from {$this->table} where `loc_group` in($val)";
	$data=dbFetchOne($sql);
	return isset($data['total'])?$data['total']:false;
	
}

function listAll($group,$nameOnly=false){
	if(!is_array($group)){ $group=array($group); }
	$val="'".implode("','", $group)."'";
	$sql="select loc_id id,loc_name name,loc_detail detail,loc_group `group` from {$this->table} where `loc_group` in($val) order by loc_group asc, loc_name asc";
	$res=dbFetch($sql);
	$data=array();
	foreach($res as $row){
		$group=$this->group->detail($row['group']);
		$data[$row['group'].".$group[name]"][$row['id']]=$nameOnly?$row['name']:$row['name']." (".$row['detail'].")";
	}
	return $data;
}

 public function __construct()
 {
    $this->load->database();
	$this->load->helper('date_helper');
 }

}
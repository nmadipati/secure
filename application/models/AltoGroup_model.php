<?php  
class AltoGroup_model extends CI_Model {
public $table='gun_groups';

function detail($id,$field='group_id'){
	$sql="select *
	from {$this->table} where $field=$id";	 
	$data=dbFetchOne($sql);  
	if($data==false)return false;
	$clean_data=dbCleanField($data,'group_'); 
	return $clean_data ;
 }
 
 
function total( ){ 
	$sql="select count(group_id) total from {$this->table}";
	$data=dbFetchOne($sql);
	return isset($data['total'])?$data['total']:false;
	
}

 public function __construct()
 {
    $this->load->database();
	$this->load->helper('date_helper');
 }

}
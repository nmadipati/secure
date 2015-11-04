<?php  
defined('BASEPATH') OR exit('No direct script access allowed');
class ProductType_model extends CI_Model {
public $table='pro_types';
/***
table:pro_types
type_id, type_name, type_inc
***/
function detail($id,$field='type_id'){
	$sql="select d.*
	from {$this->table} d where $field=$id";	 
	$data=dbFetchOne($sql); 
	if($data==false)return false;
	$clean_data=dbCleanField($data,'type_'); 
	return $clean_data ;
 }
 
function total($group=0){
	if($group==0){
		$group=62;
	}else{}
	 
	$sql="select count(type_id) total from {$this->table} ";
	$data=dbFetchOne($sql);
	return isset($data['total'])?$data['total']:false;
	
}

function listAll( ){ 
	$sql="select type_id id,type_name name, type_inc inc  from {$this->table}  order by type_name asc";
	$res=dbFetch($sql);
	$data=array();
	foreach($res as $row){
		$inc= ($row['inc']==1)? "(+)":"(-)";
		$data[$row['id']]=$row['name'].$inc ;
	}
	return $data;
}

 public function __construct()
 {
    $this->load->database();
	$this->load->helper('date_helper');
 }

}
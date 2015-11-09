<?php  
class AltoUser_model extends CI_Model {
public $table='gun_users';
public $tableUserGroup='gun_usergroup';
//user_id,user_name,user_pass,user_type,user_status
function detail($id,$field='user_id'){
	$sql="select user_id,user_name,user_pass,user_type,user_status
	from {$this->table} where $field=$id";	 
	$data=dbFetchOne($sql);  
	if($data==false)return false;
	$clean_data=dbCleanField($data,'user_'); 
	return $clean_data ;
 }
 
 
function total( ){ 
	$sql="select count(user_id) total from {$this->table}";
	$data=dbFetchOne($sql);
	return isset($data['total'])?$data['total']:false;
	
}

function totalListGroup($id){
	$sql="select ugroup_users id
		from  {$this->tableUserGroup} ug, {$this->table} u 
		where ugroup_groups=$id and ugroup_users=user_id";
		logConfig('altoDriver_groupUserS|sql:'.$sql,'logAlto');
	$data=dbFetchOne($sql);
	return isset($data['total'])?$data['total']:false;
}

function listAll($order='user_name', $orderType='asc'){
	$sql="select user_id,user_name,user_pass,user_type,user_status 
		from {$this->table} order by {$order} {$orderType}";
		logConfig('altoDriver_userS|sql:'.$sql,'logAlto');
		$data0=dbFetch($sql);		
//====clean		
		$users=array();
		foreach($data0 as $arr){
			$users[]=dbCleanField($arr,'user_');	
		}	
	return $users;
}

function listGroup($id,$order='user_name', $orderType='asc'){
	$sql="select ugroup_users id
		from  {$this->tableUserGroup} ug, {$this->table} u 
		where ugroup_groups=$id and ugroup_users=user_id
		order by {$order} {$orderType}";
		logConfig('altoDriver_groupUserS|sql:'.$sql,'logAlto');
		$data0=dbFetch($sql);		
//====clean		
		$users=array();
		foreach($data0 as $aData){
			$arr=$this->detail($aData['id']);
			$users[]=dbCleanField($arr,'user_');	
		}	
	return $users;
}


 public function __construct()
 {
    $this->load->database();
	$this->load->helper('date_helper');
 }

}
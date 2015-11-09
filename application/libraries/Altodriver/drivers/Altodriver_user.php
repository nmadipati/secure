<?php 
class Altodriver_user extends CI_Driver {
public $CI;
	public function userDetail($params=array()){
		$CI =& get_instance();
		extract($params);
		$id= !isset($post['idUser'])?3:$post['idUser'];
		$data=array(			
			'user'=>$CI->user->detail($id) 
		);
		if(count($data['user'])>1 ){
			return array('code'=>9,'data'=> $data);
		}
		return array('code'=>16,'message'=>'user id not valid');
	}
	
	public function userlist($params=array()){
		$CI =& get_instance();
		extract($params);
		logConfig('altoDriver_user|action:list','logAlto');
		$users=$CI->user->listAll();
		$data=array(
			'total'=>$CI->user->total(),
			'user'=>$users
		);
		return array('code'=>9,'data'=> $data);
	}

	public function userListgroup($params=array()){
		$CI =& get_instance();
		extract($params);
		$id= !isset($post['idGroup'])?0:$post['idGroup'];
		if($id==0){ return array('code'=>16,'message'=>'group id not valid');}
		if($CI->group->detail($id) == false) { return array('code'=>16,'message'=>'group id not avaiable');}
		logConfig('altoDriver_user|action:listGroup','logAlto');
		$users=$CI->user->listGroup($id);
		$data=array(
			'total'=>$CI->user->totalListGroup($id),
			'user'=>$users,
			'group'=>$CI->group->detail($id) 
		);
		return array('code'=>9,'data'=> $data);
	}
	
	public function __construct( )
    { 
		$this->CI =& get_instance();  		
		logConfig('altoDriver|type:user','logAlto','info');
    }
}
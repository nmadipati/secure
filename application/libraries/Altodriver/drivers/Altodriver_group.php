<?php 
class Altodriver_group extends CI_Driver {
public $CI;
	public function groupDetail($params=array()){
		$CI =& get_instance();
		extract($params);
		$id= !isset($post['idGroup'])?3:$post['idGroup'];
		$data=array(			
			'group'=>$CI->group->detail($id) 
		);
		if(count($data['group'])>1 ){
			return array('code'=>9,'data'=> $data);
		}
		return array('code'=>14,'message'=>'group id not valid');
	}

	public function groupList($params=array()){
		$CI =& get_instance();
		extract($params);
		logConfig('altoDriver_group|action:list','logAlto');
		$sql="select group_id, group_name, group_type, group_detail from gun_groups order by group_name asc";
		logConfig('altoDriver_group|sql:'.$sql,'logAlto');
		$data0=dbFetch($sql);		
//====clean		
		$groups=array();
		foreach($data0 as $arr){
			$groups[]=dbCleanField($arr,'group_');	
		}
		$data=array(
			'total'=>$CI->group->total(),
			'group'=>$groups
		);
		return array('code'=>9,'data'=> $data);
	}
	
	public function __construct( )
    { 
		$this->CI =& get_instance();  
		
		logConfig('altoDriver|type:group','logAlto','info');
    }
}	
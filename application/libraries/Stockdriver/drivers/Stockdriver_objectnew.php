<?php 
class Stockdriver_objectnew extends CI_Driver {
public $CI; 
//====CREATED NEW
	function run($params){
		$CI = $this->CI;
		extract($params);
		$newId=dbId( );
		if(strlen($post['name1'])<5) return false;
		$data=array( 
			'obj_code'=>$post['code'],
			'obj_name0'=>$post['name1'],
			'obj_name'=>$post['name2'],
			'obj_detail'=>$post['note'],
			'obj_entity'=>$post['entity'],
			'obj_category'=>(int)$post['category'],
			'obj_group'=>(int)$post['group'],
			'obj_id'=>$newId
		);
		$where="obj_id=$post[id]";
		$str = $CI->db->insert_string($CI->objProduct->table, $data, $where);
		dbQuery($str,1);
		$responce['result']='id:'.$newId.' created ';
		return $responce;
	}

	public function __construct( )
    { 
		$this->CI =& get_instance();  
    }
}	

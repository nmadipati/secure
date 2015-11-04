<?php 
class Stocks_object extends CI_Driver {
public $CI;
//====UPDATE
	function editData($params){
		$CI = $this->CI;
//---
		extract($params);
		ob_start();
		$responce=array();  
			$data=array( 
				'obj_code'=>$post['code'],
				'obj_name0'=>$post['name1'],
				'obj_name'=>$post['name2'],
				'obj_detail'=>$post['note'],
				'obj_entity'=>$post['entity'],
				'obj_category'=>(int)$post['category'],
				
			);
			$where="obj_id=$post[id]";
			$str = $CI->db->update_string($CI->objProduct->table, $data, $where);
			dbQuery($str,1);
			$responce['result']='id:'.$post['id'].' updated '; 

		$error = ob_get_contents();
		ob_end_clean();
		if($error!='')
			$responce['error']=$error;
//---
		return $responce;
	}

//====CREATED NEW
	function newData($params){
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
		$responce['result']='id:'.$newID.' created ';
		return $responce;
	}

	public function __construct( )
    { 
		$this->CI =& get_instance();  
    }
}	

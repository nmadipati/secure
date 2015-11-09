<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stockdriver extends CI_Driver_Library {
private $CI;
public $params;
	public function categoryDetail($params){
		return $this->category->detail($params);
	}

//==========OBJECT 
	function objectDetail($params){
		return $this->objectdetail->run($params);
	}
	
	function objectStock($params){
		return $this->objectstock->run($params);
	}

	public function objectEdit($params){
		return $this->objectedit->run($params);
		//$this->object->editData($params);
	}
	
	public function objectData($params){
		$data= $this->objectedit->data($params);
		logCreate('driver:'.json_encode($data));
		return $data;
		//$this->object->editData($params);
	}
	
	public function objectNew($params){
		return $this->objectnew->run($params);
		//object->newData($params);
	}
	
 
		
	public function __construct($params=array() )
    {
		$this->params=$params;
		$this->CI =& get_instance();
		$this->valid_drivers = array('category','object','objectnew','objectstock','objectedit','objectdetail'); 
		//$this->CI->config->load('Stocks', TRUE);
                // Do something with $params
    }
}
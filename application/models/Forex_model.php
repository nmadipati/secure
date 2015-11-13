<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Forex_model extends CI_Model {
public $table='mujur_register'; 
        public function __construct()
        {
            $this->load->database();
        }
	function saveData($data){
		if(isset($data['agent'])){
			$agent=trim($data['agent']);
			unset($data['agent']);
		}
		unset($data['type']);
		$dt=array(
			'reg_status'=>1,
			'reg_detail'=>json_encode($data),
			'reg_agent'=>$agent,
			'reg_created'=>date("Y-m-d H:i:s")
		);
		$this->db->insert($this->table, $dt);
		return true;
	}
		
}
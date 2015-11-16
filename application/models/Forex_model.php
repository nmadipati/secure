<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Forex_model extends CI_Model {
public $table='mujur_register'; 
        public function __construct()
        {
            $this->load->database();
        }
	function saveData($data, &$message){
		if(isset($data['agent'])){
			$agent=trim($data['agent']);
			unset($data['agent']);
		}
		if(isset($data['email'])){
			$email=$data['email'];
		}else{
			$message='No email';
			return false;
		}
		
		$sql="select count(reg_id) c from {$this->table} where
		reg_email='$email'";
		$res=$this->db->query($sql)->row_array();
		if($res['c']!==0){
			$message='Email already register';
			return false;
		}
		unset($data['type']);
		$dt=array(
			'reg_status'=>1,
			'reg_detail'=>json_encode($data),
			'reg_agent'=>$agent,
			'reg_created'=>date("Y-m-d H:i:s"),
			'reg_email'=>$email,
		);
		$this->db->insert($this->table, $dt);
		return true;
	}
		
}
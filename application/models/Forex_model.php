<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Forex_model extends CI_Model {
public $tableRegis='mujur_register'; 
public $tableWorld='mujur_register'; 
        public function __construct()
        {
            $this->load->database();
        }
		
	function regisDetail($id)
	{
		$sql="select reg_username username, reg_password password, reg_detail detail from {$this->tableRegis} where reg_id=$id";
		$res=$this->db->query($sql)->row_array();
		if($res['username']==''){
			$res['username']=9578990+$id;
			$password=substr(md5($res['username']),3,7);
			$res['password']=$password;
			$sql="update {$this->tableRegis} set reg_username='$res[username]', 
			  reg_password='$res[password]' where reg_id=$id";
			$this->db->query($sql);
		}
		
		unset($res['reg_id']);
		$dt2=json_decode($res['detail'],1);
		ksort($dt2);
		foreach($dt2 as $nm=>$val){
			if($nm=='citizen'){
				$dt=$this->country->getData($val);
				$val=$dt['name'];
			}
			$res[$nm]=$val;
		}
		unset($res['detail']);
		return $res;
	}
		
	function saveData($data, &$message)
	{
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
		
		$sql="select count(reg_id) c from {$this->tableRegis} where
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
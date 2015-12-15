<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Forex_model extends CI_Model {
public $tableRegis='mujur_register'; 
public $tableWorld='mujur_country'; 
public $tableAccount='mujur_account';
public $url="http://localhost/forex/fake";
public $demo=1;
        public function __construct()
        {
            $this->load->database();
        }
	function forexUrl($name='default'){
		$url=$aAppcode=$this->config->item('urlForex');
		return isset($url[$name])?$url[$name]:false;
	}
	function accountCreate($id){
		$detail=$this->regisDetail($id);
		$dt=array(
			'id'=>$id,
			'username'=>$detail['username'],
			'date'=>date("Y-m-d")
		);
		$sql=$this->db->insert_string($this->tableAccount,$dt);
		dbQuery($sql,1);
		$data = array('reg_status' => 0);
		$where = "reg_id=$id";
		$sql = $this->db->update_string($this->tableRegis, $data, $where);
		dbQuery($sql,1);
	}
	
	function regisAll($limit=10){
		$sql="select reg_id id from {$this->tableRegis} order by reg_id desc limit $limit";
		return  dbFetch($sql);//$this->db->query($sql)->result_array();
	}
	
	function regisDetail($id,$stat=false)
	{
		$sql="select reg_username username, reg_password password, reg_detail detail from {$this->tableRegis} where reg_id=$id";
		$res=dbFetchOne($sql);//$this->db->query($sql)->row_array();
		if($res['username']==''&&$stat==false){
			$res['username']=9578990+$id;
			$password=substr(md5($res['username']),3,7);
			$res['password']=$password;
			$sql="update {$this->tableRegis} set reg_username='$res[username]', 
			  reg_password='$res[password]' where reg_id=$id";
			$data=array(
				'reg_username'=>$res['username'],
				'reg_password'=>$res['password']
			);
			$where="reg_id=$id";
			$sql = $this->db->update_string($this->tableRegis, $data, $where);
			dbQuery($sql,1);
			//$this->db->query($sql);
		}
		
		unset($res['reg_id']);
		$dt2=json_decode($res['detail'],1);
		ksort($dt2);
		foreach($dt2 as $nm=>$val){
			if($nm=='citizen'){
				$dt=$this->country->getData($val);
				$val=$dt['name'];
				$res['country']=$dt;
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
		$res= $this->db->query($sql)->row_array();
		if($res['c']!=0){
			$message='Email already register';//.json_encode($res);
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
		$sql=$this->db->insert_string($this->tableRegis, $dt);
		dbQuery($sql);
		$message='Your account successfull registered';
		return true;
	}
		
}
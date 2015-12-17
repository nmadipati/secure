<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Forex_model extends CI_Model {
public $tableRegis='mujur_register'; 
public $tableWorld='mujur_country'; 
public $tableAccount='mujur_account';
public $tableActivation='mujur_activation';
public $url="http://localhost/forex/fake";
public $demo=0;
        public function __construct()
        {
            $this->load->database();
        }
	function forexUrl($name='default'){
		$url=$aAppcode=$this->config->item('urlForex');
		
		return isset($url[$name])?$url[$name]:false;
	}
/***
ACCOUNT

***/	 
	function accountCreate($id,$raw=''){
		$detail=$this->regisDetail($id);
		if(defined('LOCAL')){
			$sql="select count(id) c from {$this->tableAccount} where id=$id";
			$row=dbFetchOne($sql);
			if($row['c']!=0){
				$sql="delete from {$this->tableAccount} where id=$id";
				dbQuery($sql,1);
			}
		}
		$dt=array(
			'id'=>$id,
			'username'=>$detail['username'],
			//'raw'=>$raw,
			//'activation'=>base64_encode($raw),
			'created'=>date("Y-m-d")
		);
		$sql=$this->db->insert_string($this->tableAccount,$dt);
		dbQuery($sql,1);
		$data = array('reg_status' => 0);
		$where = "reg_id=$id";
		$sql = $this->db->update_string($this->tableRegis, $data, $where);
		dbQuery($sql,1);
	}

/***
ACTIVATION

***/	
	function accountActivation($id,$raw0){
		$sql="select reg_id id from {$this->tableRegis} where reg_id like '$id'";
		$row= $this->db->query($sql)->row_array();
		$idActive=sprintf("%s%05s",dbId('activation', 200005),$row['id']);
		$ar=array('date'=>date("Y-m-d H:i:s"), 'id'=>$id, 'raw'=>$raw0);
		$raw=json_encode($ar);
		$dt=array( 
			'id'=>$idActive,
			'code'=>base64_encode($raw),
			'userid'=>$id,
			'expired'=>date("Y-m-d H:i:s",strtotime("+4 hours")),
			'created'=>date("Y-m-d H:i:s",strtotime("now"))
			
		);
		$sql=$this->db->insert_string($this->tableActivation,$dt);
		dbQuery($sql,1);
		$data = array('reg_status' => 2);
		$where = "reg_id=$id";
		$sql = $this->db->update_string($this->tableRegis, $data, $where);
		dbQuery($sql,1);
		return $idActive;
	}
	
	function activationDetail($id,$field='id'){
		$sql="select * from {$this->tableActivation} where $field='".addslashes($id)."'";
		$res=dbFetchOne($sql);
		return $res;
	}
	
	function activationUpdate($id, $status){
		$data = array('status' => $status);
		$where = "id=$id";
		$sql = $this->db->update_string($this->tableActivation, $data, $where);
		dbQuery($sql,1);
		
	}
	
	function activationUpdateUser($id, $status){
		$data = array('status' => $status);
		$where = "userid=$id";
		$sql = $this->db->update_string($this->tableActivation, $data, $where);
		dbQuery($sql,1);
		
	}
	

/***
REGISTER

***/	
	function regisAll($limit=10)
	{
		$sql="select reg_id id from {$this->tableRegis} order by reg_id desc limit $limit";
		return  dbFetch($sql);//$this->db->query($sql)->result_array();
	}
	
	function regisDetail($id,$stat=false)
	{
		$sql="select reg_username username, reg_password password, reg_detail detail, reg_status status from {$this->tableRegis} where reg_id=$id";
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
			if(defined('LOCAL')){
				echo $sql;
			}
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
		//INSERT INTO `mujur_forex`.`mujur_activation` (`id`, `code`, `expired`, `status`) VALUES ('900', 'MTsxMTAwMTcyNA==', '2015-12-17 11:28:00', '0');
		
		$message='Your account successfull registered';
		return true;
	}
		
}
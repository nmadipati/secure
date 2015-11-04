<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alto extends CI_Controller {
public $param;
private $libs;
	function index(){ 
		//$this->error('unknown metodh'); 
		//$this->success();
		redirect(base_url(). "altotest", "refresh");
	}

	function data($module='none', $action='none'){	 
		if($module=='none')	$this->error('unknown module', 14); 
		if($action=='none')	$this->error('unknown action', 15); 
		$valid = $this->libs->valid($module,$action);
		if(isset($valid['error'])){
			if( $valid['error']==14)
			  $this->error('unknown function', 14); 
		    if( $valid['error']==24)
			  $this->error('module not register', 24); 

/*
Altodriver : tambahkan di function validAction() lib/altodriver/altodriver
altodriver/altodriver.php >> tambahkan nama modulenya di $this->valid_drivers 
Altodriver_{module} : tambahkan fungsi {module}{action}
model/.... : masukkan yang berhubungan dengan query disini
*/
		}else{} 
		
		logConfig('altoController|module:'.$module.'|action:'.$action,'logAlto');
		$result = $this->libs->run($module,$action, $this->param);
		if($result['code']==9){	
			$function=strtolower($module).ucfirst(strtolower($action));		
			if(!isset($result['data']))
				$this->success($function.' success');
			
			$this->success($function.' success',$result['data']);
		}
		else{
			if(isset($result['data'])){
				$this->error($result['message'], $result['code'],$result['data']);
			}
			else{
				$this->error($result['message'], $result['code']);
			}
			
		}
		 
	}
	
  function __CONSTRUCT(){
	parent::__construct();
	$this->param['get']=$this->input->get(NULL,true);
	$this->param['post']=$post=$this->input->post(NULL,true);
	$this->load->library('alto_libs');
	$this->libs = $this->alto_libs;
	
	$this->load->database('alto');
	$this->load->model('altoGroup_model','group');
	$this->load->model('altoUser_model','user');
	/*
	if(!isset($_POST['user'])){
		$this->error('User Not Valid');
	}else{}	
	*/
	
	
  }
  
  private function success($message='', $data=array()){
	$message=$message==''?'SUCCESS':$message;
	logConfig('code:9|success|'.$message,'logAlto','info');
	$res=array(
		'code'=>9,
		'message'=>(string)$message 
	);
	if(count($data)!=0){
		$res['data']=$data;
		logConfig('data:'.json_encode($data),'logCoreAlto','debug');
	}else{}
	echo json_encode($res);
	exit();
  }
  
  private function error(  $message='',$code=13,$detail=array()){ 
	logConfig('code:'.$code.'|message:'.json_encode($message),'logErrorAlto','error');
		$res=array(
			'code'=>$code,
			'message'=>(string)$message 
		);
	if(count($detail)!=0){
		$res['detail']=$detail;
		logConfig('message:'.json_encode($detail),'logErrorAlto','error');
	}else{}
	
	echo json_encode($res);
	exit();
  }
  
}
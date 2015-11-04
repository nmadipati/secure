<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Forex extends CI_Controller {
	public $param;	
	public function data()
	{
		$url=$this->config->item('api_url');
		$this->load->helper('api');
		$respon=array(		
			'html'=>print_r($_REQUEST,1),
			//'post'=>$this->input->post()
		);
		$type=$this->input->post('type','unknown');
		if($type=='request'){
			$respon['title']='NEW LIVE ACCOUNT (CREATED)';
			$param['data']=$this->convertData();
			$param['module']='liveuser';
			$param['task']='create';
			logCreate( 'param:'.print_r($param,1));
			$param['app_code']='9912310';
			$result=_runApi($url, $param);
			$this->param['result']=$result['data'];
			logCreate( 'param:'.print_r($result,1));
			//$respon['result']=$result;
			$respon['html']=$this->load->view($this->param['folder'].'liveTable_view',$this->param,true);
			$ok=1;
		}
		
		if(!isset($ok)){
			$this->errorMessage('266','unknown data type');
		}
		
		$this->succesMessage($respon);
	}
	
	private function convertData(){
	$post=array();
		foreach($this->input->post('data') as $data){
			$post[$data['name']]=$data['value'];
		}
		return $post;
	}
	public function api(){
		
		$module=$this->input->post('module');
		$task=$this->input->post('task');
		$appcode=$this->input->post('app_code');
		$aAppcode=$this->config->item('app_code');
		if(array_search($appcode, $aAppcode)!==false){
			$this->load->model('forex_model','modelku');
			$param=$this->input->post('data');
			$function= strtolower($module ).ucfirst(strtolower($task ));
				$respon=$this->modelku->$function($param );
		}else{ 
			$this->errorMessage('276','unknown app code');
		}
		
		//$respon['post']=$param;
		$this->succesMessage($respon);
	}
	private function succesMessage($respon){
		echo json_encode(
		  array(
			'status'=>true,
			'code'=>9, 
			'data'=>$respon,
			'message'=>'succes'
		  )
		);
		exit();	
	}
	private function errorMessage($code, $message,$data=array()){
		$json=array(
			'status'=>false,
			'code'=>$code, 
			'message'=>$message 
		  );
		if(count($data)!=0) $json['data']=$data;
		echo json_encode($json);
		exit();
	}
	
	public function index()
	{
		$this->param['title']='OPEN LIVE ACCOUNT';
		//$this->param['fileJs'][]='js/core/anonim.js'; 
		$this->param['content']=array(
			'form', 
			'modal'
		);
		$this->showView(); 
		
	}
	
	private function showView(){
		$name=$this->uri->segment(2,'');
		
		if($name!=''){
			$jsScript=$this->param['folder'].$this->uri->segment(2).".js";
			$this->param['dataUrl']=  $this->uri->segment(1). "_".$name;
			$this->param['script']=$this->param['type']=$name;
			
			$this->param['openScript']=$jsScript;
			logCreate('open script:'.$jsScript.'|data:'. $this->uri->segment(1)."_".$name  );
			
			if(isset($this->param['content'])&&!is_array($this->param['content'])){
				$this->param['load_view']= 
					$this->param['folder'].$this->param['content'].'_view';
				
			}else{}
			//$this->checkView( $this->param['load_view'] );
			
		}else{ 
			$controller=$this->uri->segment(1);
			if($controller=='')$controller='forex';
			redirect(base_url().$controller."/index","refresh");	
		}
		//logCreate($this->param);
		$this->load->view('base_view', $this->param);
	
	}
	
	function __CONSTRUCT(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('formBootsrap');
		
		date_default_timezone_set('Asia/Jakarta');
		$this->param['today']=date('Y-m-d');
		$this->param['folder']='forex/';
		 
		$this->param['fileCss']=array(			
			'css/cupertino/jquery-ui-1.10.3.custom.min.css', 
			'css/bootstrap.css',
			'css/font-awesome.css',
			'css/style.css'
		);
		$this->param['fileJs']=array(
			'js/jquery-1.9.min.js',	
			'js/bootstrap.js',
		);
		
		$this->param['footerJS']=array(			
			'js/jquery-ui-1.9.2.min.js',			
			'js/forex.js' 
		);
		if($this->input->post())
			logCreate($this->input->post(),'post');
	}
	
}
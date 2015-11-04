<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Js extends CI_Controller {
public $param;

function data($type=''){
	logConfig('type:'.$type,'logCore','info');
	logCreate('type:'.$type, 'info');
	$this->param['get']=$this->input->get(NULL,true);
	$this->param['post']=$this->input->post(NULL,true);
	$this->load->model('invoice_model','invoice');
	
	if($type=='jqgrid1_script1_1'|| 
	$type=='jqgrid2_script1_1'|| $type=='jqgrid2_script2_1'|| $type=='jqgrid2_script3_1'){
		$view='jqgrid/script1';
	}
	
	if($type=='jqgrid2_script3_2'){
		$view='jqgrid/script2';
	}
//========edit
	if($type=='jqgrid5_script1_1' || $type=='jqgrid5_script11_1'|| $type=='jqgrid5_script14_1' 
	){
		$view='jqgrid/script1';
	}
	if($type=='jqgrid5_script12_1'){
		$view='jqgrid/script5c'; //isi sama dengan script 1 tetapi ada tambahan buat action 
		 
	}
	
	if($type=='example1'){
		$view='jqgrid/example1';
	}
	
	if(isset($view)){		
		logConfig('body:'.$view.'_body','logCore','info'); 
		$this->load->view($view.'_body',$this->param);
	}else{ 
		logConfig('body:none','logCore','error'); 
		logCreate('body:none', 'error');
		echo json_encode(array('not load any','type'=>$type,'post'=>$_POST, 'get'=>$_GET ));
	}
}

function jqgrid7(){ //edit advance
	redirect(base_url().$this->uri->segment(1)."/jqgrid5/script11", "refresh");
	$this->param['content']='list5';
	$this->showView();
}

function jqgrid5(){ //edit
	$this->param['content']='list5';
	$this->showView();
}

function jqgrid2(){
	$this->param['content']='list2';
	$this->showView();
}

function jqgrid1(){
	$this->param['content']='list1';
	$this->showView();
}

function demo(){
	$this->load->view('jqgrid/demo_view');
}

function demo2(){
	$this->load->view('jqgrid/demo2_view');
}

private function showView(){
	$script=$this->uri->segment(3,'');
	
	if($script!=''){
		$jsScript=$this->param['folder'].$this->uri->segment(2)."_".$script.".js";
		$this->param['dataUrl']=  $this->uri->segment(2). "_".$script;
		$this->param['script']=$this->param['type']=$script;
		
		$this->param['openScript']=$jsScript;
		logCreate('open script:'.$jsScript.'|data:'. $this->uri->segment(2)."_".$script  );
		$load_view= $this->param['folder'].$this->param['content'].'_view';
		$param2=$this->param;
		unset($param2['openScript']);
		$this->param['htmlScript']=$this->load->view($load_view,$param2,true);
		
	}else{ 
		//logCreate('no script','info'); 
		redirect(base_url().$this->uri->segment(1)."/".$this->uri->segment(2)."/script1", "refresh");
	}
	$this->load->view('base_view', $this->param);
	
}
	function __CONSTRUCT(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->model('menu_model','menu');
		date_default_timezone_set('Asia/Jakarta');
		$this->param['today']=date('Y-m-d');
		$this->param['folder']='jqgrid/';
		$this->param['footerJS']=array();
		$this->param['mainMenu']=$this->menu->generate('jqgrid');
		$this->param['thisUrl']= $this->uri->segment(1).'/'.$this->uri->segment(2);
		$this->param['css']=array(			
			'cupertino/jquery-ui-1.10.3.custom.min.css',
			'jqgrid3.8/ui.jqgrid.css'
		);
		$this->param['js']=array(
			'jquery-1.9.min.js',	
			'bootstrap.js',
		);
		$script=$this->uri->segment(3,'');
		$jsScript=$this->param['folder'].$this->uri->segment(2)."_".$script.".js";
		$this->param['footerJS']=array(			
			'jquery-ui-1.9.2.min.js',			
			'jqgrid3.8/i18n/grid.locale-en.js',
			'jqgrid3.8/jquery.jqGrid.js', 
		);
		if($script!=''){
			$this->param['footerJS'][]=$jsScript;
		}
		$this->param['title']='Jqgrid example';
		
		logCreate('request:'.json_encode($_REQUEST));
		//log_message('debug','post:'.json_encode($_POST));
		//log_message('debug','get:'.json_encode($_GET));
	}
}
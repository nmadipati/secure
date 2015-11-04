<?php 
/*
altotest
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Altotest extends CI_Controller {
public $param;
	function index(){	 
		$this->param['content']='demo';
		$this->showView();
 
	}
	
	function view($type=''){
		$this->param['content']='show';
		$result='';
		if($type=='groupList'){
			$url=base_url().'alto/data/group/list';
			$result=_runApi($url);
			
		}else{}
		if($type=='groupDetail'){
			$post=array('idGroup'=>4);
			$url=base_url().'alto/data/group/detail';
			$result=_runApi($url,$post);
			
		}else{}
		
		if($type=='groupDetail2'){
			$post=array('idGroup'=>1);
			$url=base_url().'alto/data/group/detail';
			$result=_runApi($url,$post);
			
		}else{}
		
		if($type=='userList'){
			$post=array();//'idGroup'=>1);
			$url=base_url().'alto/data/user/list';
			$result=_runApi($url,$post);
			
		}else{}
		
		if($type=='userListGroup'){
			$post=array('idGroup'=>3);
			$url=base_url().'alto/data/user/listGroup';
			$result=_runApi($url,$post);
			
		}else{}
		if($type=='userListGroup2'){
			$post=array('idGroup'=>1);
			$url=base_url().'alto/data/user/listGroup';
			$result=_runApi($url,$post);
			
		}else{}
		
		if($type=='userDetail'){
			$post=array('idUser'=>1);
			$url=base_url().'alto/data/user/detail';
			$result=_runApi($url,$post);
			
		}else{}
		
		if($result==''){ die('no data'); }
			
		$this->param['result']=$result;
		$this->showView();
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
		//redirect(base_url().$this->uri->segment(1)."/".$this->uri->segment(2)."/script1", "refresh");
	}
	$this->load->view('base_view', $this->param);
	
}

	function __CONSTRUCT(){
		parent::__construct();
		$this->load->helper(array('api'));
		$this->load->model('menu_model','menu');
		date_default_timezone_set('Asia/Jakarta');
		$this->param['today']=date('Y-m-d');
		$this->param['folder']='alto/';
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
		$this->param['title']='Alto test';
		
		//logCreate('request:'.json_encode($_REQUEST)); 
	}
	
}
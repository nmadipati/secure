<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jmobile extends CI_Controller {
public $param;
	function index(){ 
		$this->param['content']='hello';
		$listDemo=array(
		1=>'List View  ',
		'Form Element',
		'Button',
		
		);
		$this->param['listDemo']=$listDemo;
		$this->showView(); 
	}
	
	function demo($pos=1){
		$this->param['content']='demo';
		$this->param['show']=$pos;
		$open='jmobile/demo/demo'.$pos.'_view';
		$this->param['demo']=true;
		//demo'.$pos;
		$this->showView(); 
	}

private function showView(){
	//$script=$this->uri->segment(3,'');	
//==========KHUSUS DEMO
	if(isset($this->param['demo'])){
		$open='jmobile/demo/demo'.$this->param['show'].'_view';
		$this->param['htmlDemo']= $this->load->view($open, $this->param, true);
	}
	$this->load->view('mobile_view', $this->param);
	
}
 
//======
	function __CONSTRUCT(){
		parent::__construct();
		$this->load->helper('form');
		 
		date_default_timezone_set('Asia/Jakarta');
		$this->param['today']=date('Y-m-d');
		$this->param['folder']='jmobile/';
		$this->param['baseFolder']='jmobile/';
		$this->param['footerJS']=array();
		 
		$this->param['thisUrl']= $this->uri->segment(1).'/'.$this->uri->segment(2);
		$this->param['css']=array(			
			'mobile/jquery.mobile.custom.structure.css',
			'mobile/jquery.mobile.custom.theme.css',
		);
		$this->param['js']=array(
			'jquery-1.11.1.js',	
			'mobile/jquery.mobile-1.4.5.js',
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
		 
	}
}
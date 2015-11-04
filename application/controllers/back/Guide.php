<?php 
//--------GUIDDE
defined('BASEPATH') OR exit('No direct script access allowed');

class Guide extends CI_Controller {
private $myLibs;
//=========DB HELPER
function dbhelper()
{
	$this->param['title']='Guide :: DB Helper';
	$this->param['content']='dbhelper';
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
			
			if(isset($this->param['content'])){
				$this->param['load_view']= 
					$this->param['folder'].$this->param['content'].'_view';				
			}
			
			$this->myLibs->checkView($this->param['load_view']);
			 
			
		}else{ redirect(base_url().$this->uri->segment(1)."/index","refresh");	}
	$this->load->view('base_view', $this->param);	
}
	
//=========BEGIN
function __CONSTRUCT(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('formBootsrap');
		$this->load->model('menu_model','menu');
 
		$this->load->library('my_libs');
		$this->myLibs = $this->my_libs;
		
		$this->param=$this->myLibs->params();
		$this->param['mainMenu']=$this->menu->generate('helper');
		$this->param['folder']='guide/';
		
//=============MAIN JS		
		$jsScript='main.js';
		$this->myLibs->checkView($jsScript,'js');
		$this->param['footerJS'][]=$jsScript;
//=============sub JS 					 
		$this->param['title']='Guide';		
		 
		//berisi detail user
		$this->param['id']=dbId('guide');
	}
}
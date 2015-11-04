<?php 
/* 
--------KHUSUS doctor---


*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Doctor extends CI_Controller {
function patdetail(){
	$id=$this->input->post('id');
	$row=$this->patient->getById($id);
	$html='<table class="table table-bordered">';
		$html.="<tr><td>Nama</td><td>".$row['pat_name']."</td></tr>";
		$html.="<tr><td>Umur</td><td>".$row['pat_umur']."</td></tr>";
		$html.="<tr><td>Keluhan</td><td>".$row['pat_compl']."</td></tr>";
		$html.="<tr><td>Telp</td><td>".$row['pat_phone']."</td></tr>";
		$html.="<tr><td>Alamat</td><td>".$row['pat_addr']."</td></tr>";
		 
	$html.="</table>";
	$result=array('status'=>'success',
	  //'row'=>$row,
	  'html'=>$html,
	);
	print json_encode($result);
}

function listing($status=''){
	$this->param['title']='Pendataan Klinik Online';
		//$this->param['fileJs'][]='js/core/anonim.js'; 
		$this->param['content']=array(
			'jumbo',
			'listing',
			'modal'
			
		);
		$idStatus=0;
		if($status=='umum')$idStatus=1;
		if($status=='ambulance')$idStatus=3;
		if($status=='homecare')$idStatus=2;
		
		$this->param['pasien']=$this->patient->getByStatus($idStatus);
		$this->showView(); 
}

function index(){
	$this->param['title']='Pendataan Klinik Online';
		//$this->param['fileJs'][]='js/core/anonim.js'; 
		$this->param['content']=array(
			'jumbo',
			'input',
			
		);
		$this->param['numPasien']=$this->patient->totalbyCat();
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
			if($controller=='')$controller='anonim';
			redirect(base_url().$controller."/index","refresh");	
		}
		//logCreate($this->param);
		$this->load->view('base_view', $this->param);
	
	}
	
	function __CONSTRUCT(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('formBootsrap');
		$this->load->model('patient_model','patient');
		date_default_timezone_set('Asia/Jakarta');
		$this->param['today']=date('Y-m-d');
		$this->param['folder']='doctor/';
		 
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
			'js/main.js' 
		);
		if($this->input->post())
			logCreate($this->input->post(),'post');
	}
}
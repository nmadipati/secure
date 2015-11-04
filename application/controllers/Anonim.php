<?php 
/* 
--------KHUSUS ANONIM---
Memakai SENCHA 
PROGRAM : PENDAFTARAN ONLINE
MODUL 	: ANONIM 
Anonim dapat mengirim pendaftaran secara Online
Pilihannya dapat mendaftar, meminta ambulan hingga meminta rawat di rumah. 
Rawat di rumah / Home care adalah fasilitas dimana dokter yang datang ke pasien dan melakukan tindakan disana

*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Anonim extends CI_Controller {
public $param;
	function savedata(){
		//logCreate($this->input->post());
		$result=array( 'status'=>true);
		$status=$this->input->post('status');
		if( $status==''){
			$post=$this->input->post();
			$this->modelku->saveNormal($post);
			$result['message']='Silakan Tunggu Konfirmasi dari Kami';
		}else{ 
			$post=$this->input->post();
			$this->modelku->saveDetail($post);
			$result['message']='Silakan Tunggu Kontak Dari Kami';
		}
		//'post'=>$this->input->post() );
		echo json_encode($result);
	}

	function formcontact(){
		//logCreate($this->input->post());
		$this->param['post']=$this->input->post();
		$html=$this->load->view($this->param['folder'].'formContact_view',$this->param, true);	
		$result=array( 'html'=>$html);
		echo json_encode($result);
	}

/* 
HALAMAN UTAMA 
semua input yang mengeluarkan tampilan hanya disini saja
*/ 
	public function index()
	{
		$this->param['title']='Pendaftaran Klinik Online';
		//$this->param['fileJs'][]='js/core/anonim.js'; 
		$this->param['content']=array(
			'jumbo',
			'form01',
			'about',
			'ambulance',
			'homecare',
			'howto',
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
		$this->load->model('anonim_model','modelku');
		date_default_timezone_set('Asia/Jakarta');
		$this->param['today']=date('Y-m-d');
		$this->param['folder']='anonim/';
		 
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
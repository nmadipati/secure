<?php 
//--------BOOTSTRAP EXAMPLE
defined('BASEPATH') OR exit('No direct script access allowed');

class Bootstrap extends CI_Controller {
public $param;
	function index(){
		redirect(base_url().$this->uri->segment(1)."/hello/script1", "refresh");
	}
	
	function modal(){
		$this->param['content']='modal';
		$this->showView();
	}
	
	private function showView(){
		$script=$this->uri->segment(3,'');
		if(isset($this->param['content'])){
				$this->param['load_view']= 
					$this->param['folder'].$this->param['content'].'_view';
				$this->checkView( $this->param['load_view'] );
			}else{ } 
		
		if($script!=''){
			$jsScript=$this->param['folder'].$this->uri->segment(2)."_".$script.".js";
			$this->checkView($jsScript,'js');
			$this->param['dataUrl']=  $this->uri->segment(2). "_".$script;
			$this->param['script']=$this->param['type']=$script;
			
			$this->param['openScript']=$jsScript;
			logCreate('open script:'.$jsScript.'|data:'. $this->uri->segment(2)."_".$script  );
			$load_view= $this->param['folder'].$this->param['content'].'_view';
			$param2=$this->param;
			unset($param2['openScript']);
			$this->param['htmlScript']=$this->load->view($load_view,$param2,true);
			
			
		}
		else{  
			redirect(base_url().$this->uri->segment(1)."/".$this->uri->segment(2)."/script1", "refresh");
		}
		
		
		$this->load->view('base_view', $this->param);
		
	}

		
	private function checkView($target,$stat='view'){
		//return true;
		if(!is_file("views/".$target.".php") && ($stat=='view'||$stat=='body') ){
			$txt="<?php 
/****
	views	: $target
	created	: ".date("d-m-Y H:i:s")."
	By		: CI3 Bootstrap Controllers
****/
defined('BASEPATH') OR exit('No direct script access allowed');";
			if($stat=='view')
			  $txt.="\n?>\n
<div class='container'><div class='row'>\n
<!-- content Start-->\n\n<!-- content End-->\n
</div></div>";
			file_put_contents ("views/".$target.".php", $txt,LOCK_EX );
			logCreate('create file:'."views/".$target.".php");
		}else{}
		
		if(!is_file("assets/js/".$target ) && $stat=='js'  ){
			$txt="/****
	Javascript	: $target
	created	: ".date("d-m-Y H:i:s")."
	By		: CI3 Bootstrap Controllers
****/";	
			file_put_contents ("assets/js/".$target , $txt,LOCK_EX );
			logCreate('create file:'."assets/js/".$target);
		}else{}
	}

	
	function __CONSTRUCT(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('formBootsrap');
		$this->load->model('menu_model','menu'); 
	
		date_default_timezone_set('Asia/Jakarta');
		$this->param['today']=date('Y-m-d');
		$this->param['folder']='bootstrap/';
		$this->param['footerJS']=array();
		$this->param['mainMenu']=$this->menu->generate('bootstrap');
		
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
			$this->checkView($jsScript,'js');
			//assets/js/bootstrap/modal_script1.js
			
		}else{}
		
		$this->param['title']='Bootstrap example';
		 
		logCreate('request:'.json_encode($_REQUEST));		
		//log_message('debug','post:'.json_encode($_POST));
		//log_message('debug','get:'.json_encode($_GET));
	}

}
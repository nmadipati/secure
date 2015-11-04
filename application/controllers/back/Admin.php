<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
public $param;
	public function test()
	{
		$this->param['baseFolder']='demo/';
		$this->param['folder']='demo/';
		$this->param['content']='table';
		//$this->config->load('logConfig', TRUE);
		 //$logConfig = $this->config->item( 'logConfig');
		 //var_dump( $logConfig ); die('--');
		 logCreate('hello');
		 logConfig('hello core','logCore');
		 logConfig('hello error','logError');
		 
		$this->load->view('demo/baseAdmin_view', $this->param);
	}
	public function index()
	{
		unset($this->param['footerJS']);
		$this->param['mainMenu']=$this->menu->generate( );
		$this->load->view('base_view',$this->param);
	}
	
	function __CONSTRUCT(){
		parent::__construct();
		$this->load->model('menu_model','menu');
		date_default_timezone_set('Asia/Jakarta');
		$this->param['today']=date('Y-m-d');
		$this->param['folder']='admin/';
		$this->param['footerJS']=array();
		$this->param['mainMenu']=$this->menu->generate('admin');
		log_message('info','post:'.json_encode($_POST));
		log_message('info','get:'.json_encode($_GET));
		 
		$this->param['thisUrl']= $this->uri->segment(1).'/'.$this->uri->segment(2);
	}	
}
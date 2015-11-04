<?php 
//--------PROGRAM STOCK
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller {
public $param;
private $stockDriver,$stockLibs;

function data($type='')
{
	logCreate('type:'.$type, 'info');
	logConfig('type:'.$type,'logCore','info');
	$this->param['get']=$this->input->get(NULL,true);
	$this->param['post']=$this->input->post(NULL,true);
//=============CATEGORY
	if($type=='stock_category_1'  ){
		$view='stock/category';
	}else{}	
	
	if($type=='stock_listCategory_1'){
		$view='stock/listCategory';
	}else{}
 
	
	if($type=='stock_category_edit'){ 
		$view='stock/categoryUpdate';
	}else{}
	
	if($type=='categoryDetail'){
		$view='stock/categoryDetail';
	}

//============LOCATION	
	if($type=='stock_location_1'){
		$view='stock/location';
	}else{}	
	if($type=='stock_location_edit'){
		$view='stock/locationUpdate';
	}else{}

//===========Product	
	if($type=='stock_products_1'|| $type=='stock_listObject_1'){
		$view='stock/objProducts';
	}else{}	
	if($type=='stock_products_edit'){
		$view='stock/objProductsUpdate';
	}else{}
	if($type=='objectDetail'){
		$view='stock/objDetail';
	}
	if($type=='objectDetailUpdate'){
		$view='stock/objDetailUpdate';
	}
	
	if($type=='objectStock'){
		$view='stock/objStock';
	}
	
	if(isset($view)){
		$this->checkView($view."_body",'body');
		$this->load->view($view.'_body',$this->param);
		 
		logConfig('body:'.$view.'_body','logCore','info'); 
	}else{ 
		logConfig('body:none','logCore','error'); 
		echo json_encode(array('not load any','type'=>$type,
		'params'=>$this->param ));
	}
	return true;
}

function update($type='')
{
	$this->param['get']=$this->input->get(NULL,true);
	$this->param['post']=$this->input->post(NULL,true);
	logCreate('edit type:'.$type, 'info');
	logConfig('edit type:'.$type,'logCore','info');
	if($type=='category'){
		$view='category';
		$this->param['post']['oper']='edit';
		$messages='id :'.$this->input->post('id').' Updated';
		$footer='Please Click Close';
	}else{}
	
	if($type=='object'){
		//$view='objProducts';
		$this->objectUpdate($type);
		exit();
	}else{}
	
	if(isset($view)){
		$views=$this->param['folder'].$view;
		$this->checkView($views."Update_body",'body');
		$result0=$this->load->view($views.'Update_body',$this->param,true);
		logConfig('body:'.$views.'Update_body','logCore','info'); 
		if($this->input->post('return')){
			$url = $this->input->post('return');//: $_SERVER['HTTP_REFERER'];
			redirect($url,'refresh'); 
		}
		else{ 
			 
			$return=json_decode($result0,true);
			$result=array(
				'body'=>isset($error)?'':$messages,
				'footer'=>$footer,
				
			);
			if(isset($error)){ $result['error']=$error; }
			
			$result['tmp']=$return;
			echo json_encode($result);
		}
	}
	elseif(isset($noBody )){
		$result=array(
				'body'=>$messages,
				'footer'=>$footer,
				
			); 
		if(isset($error))$result['error']=$error;
		echo json_encode($result);

	}else{
		logConfig('body:none','logCore','error'); 
		echo json_encode(array('not load any','type'=>$type,
		'params'=>$this->param ));
	}

}

  function edit($type='')
  {
	$this->param['get']=$this->input->get(NULL,true);
	$this->param['post']=$this->input->post(NULL,true);
	logCreate('edit type:'.$type, 'info');
	logConfig('edit type:'.$type,'logCore','info');
	if($type=='category'){
		$view='editCategory';
	}else{}
	
	if($type=='object'){
		$view='editObject';
		$this->objectEdit();
		die();
	}else{}
	
	if(isset($view)){
		$views=$this->param['folder'].$view;
		$this->checkView($views."Form_view",'body');
		$this->load->view($views.'Form_view',$this->param);
		logConfig('body:'.$views.'Form_view','logCore','info'); 
	}else{ 
		logConfig('body:none','logCore','error'); 
		echo json_encode(array('not load any','type'=>$type,
		'params'=>$this->param ));
	}
  }

/*
	Category
*/
function listCategory($type='list',$id=0)
{	
	if($type=='list'){
		$this->param['content']='listCategory';
		$this->param['title']='Stock :: List Category';
		
		//$this->stock->somemethod();	
	}else{}
	
	if($type=='detail'){
		//$this->param['content']='detailCategory';
		$this->param['catId']=$this->uri->segment(4,'');
		$data = $this->stockLibs->categoryDetail($this->param);
		//$this->stockDriver->category->detail($this->param);
		///$this->data( 'categoryDetail');	//$view='stock/categoryDetail';
		$noView=1; 
		echo json_encode($data);
	}else{}
	
	if(!isset($noView)){
		
		$this->showView();
	}
}

function category(){	
	$this->param['content']='category';
	$this->param['title']='Stock :: Category';
	$this->showView();
}

/*
	Product
*/
  function objectEdit()
  {
	$this->param['post']= $this->input->post();
	$type2='objectData';
/*
libraries/Stocks_libs.php
libraries/stocks/Stocks.php
libraries/stocks/drivers/stock_objectedit.php
*/	
	$data = $this->stockLibs->$type2($this->param);
	logCreate('controller:'.json_encode($data));
	if(!isset($data['error'])){ 
		echo json_encode($data);
	}else{
		echo $data['error']; 
		logCreate('error');	
	}
  }
  
   function objectDetail()
   {
	$this->param['post']= $this->input->post();
	$type2='objectDetail';
/*
libraries/Stocks_libs.php
libraries/stocks/Stocks.php
libraries/stocks/drivers/stock_objectstock.php
*/
		$data = $this->stockLibs->$type2($this->param);
		if($data){ 
			$messages=$data['result']; 
			
		}
		else{
			$error='Check your input';
			$messages='';
		}		
 		
		$footer='Please Click Close';
		$noBody=1;
		
		$result=array(
				'body'=>$messages,
				'footer'=>$footer,	
				//'tmp'=>$data
			); 
		if(isset($error))$result['error']=$error;
		echo json_encode($result);
   }
   
   function objectStock()
   {
	$this->param['post']= $this->input->post();
	$type2='objectStock';
/*
libraries/Stocks_libs.php
libraries/stocks/Stocks.php
libraries/stocks/drivers/stock_objectstock.php
*/
		$data = $this->stockLibs->$type2($this->param);
		if($data){ 
			$messages=$data['result']; 
			
		}
		else{
			$error='Check your input';
			$messages='';
		}		
 		
		$footer='Please Click Close';
		$noBody=1;
		
		$result=array(
				'body'=>$messages,
				'footer'=>$footer,				
			); 
		if(isset($error))$result['error']=$error;
		echo json_encode($result);
   }
   
   function objectUpdate($type='unk') //new & edit
   {
	$id= (int)$this->input->post('id');
		//$this->param['post']['oper']=$id===0?'new':'edit';
		$type2=$id===0?'objectNew':'objectEdit';		
		logCreate('oper:'. $type2. '|id:'.$id);
		$this->param['post']= $this->input->post();
/*
libraries/Stocks_libs.php
libraries/stocks/Stocks.php
libraries/stocks/drivers/stock_objectedit.php
*/
		$data = $this->stockLibs->$type2($this->param);
		if($data){ 
			$messages=$data['result']; 
			
		}
		else{
			$error='Check your input';
			$messages='';
		}		
 		
		$footer='Please Click Close';
		$noBody=1;
		
		$result=array(
				'body'=>$messages,
				'footer'=>$footer,				
			); 
		if(isset($error))$result['error']=$error;
		echo json_encode($result);
   
   }

   function listProduct($type='list',$id=0){
	$url="stock/listObject/".$type;//uri_string();
	if($id!=0)$url.="/$id";
	redirect(base_url().$url, "refresh");
   }
   
   function listObject($type='list',$id=0){
//=======FRONT
	if($type=='list'){ 
		$this->param['content']='listObject';
		$this->param['title']='Stock :: List Object'; 
		 $this->param['categoryData']= ''; 
	}else{}

//=======popup detail (json) not used	
	if($type=='detail'){
		$this->param['content']='detailObject';
		$this->param['objId']=$this->uri->segment(4,'');
		$this->data( 'objectDetail');
		$noView=1; 
	}else{}

//=======popup detail with update button (json)
	if($type=='detailUpdate'){
		$this->param['content']='detailObject';
		$this->param['objId']=$this->uri->segment(4,'');
		//$this->data( 'objectDetailUpdate');
		$this->objectDetail();
		$noView=1; 
	}else{}

//=======popup stock (json)	
	if($type=='stock'){
		$this->param['content']='detailStock';
		$this->param['objId']=$this->uri->segment(4,'');
		//$this->data( 'objectStock');
		$this->objectStock();
		$noView=1; 
	}else{}
	
	if(!isset($noView)){		
		$this->showView();
	}
  }
  
  function products(){
	$this->param['title']='Stock :: Product';
	$this->param['content']='objProduct'; 
	$data=$this->loadData();
	$this->param['categoryData']= $data['category'] ;
	$this->showView(); 
 }
 
 function location(){
	$this->param['title']='Stock :: Location';
	$this->param['content']='location';	 
	$this->showView(); 
 }

 function report(){
	$this->param['title']='Stock :: Report Stock';
	$this->param['content']='report';
	$this->param['data']=$this->loadData( );
	$this->showView();
 }
 
//--------------
function input($id=0){
	$this->param['title']='Stock :: Input Flow';
	$this->param['content']='flow';
	$this->param['objId']=intval($id);
	$this->showView();
}

function flowUpdate(){
	$this->param['title']='Stock :: Update Flow';
	$this->param['content']='flowUpdate';
	$this->param['get']=$this->input->get(NULL,true);
	$this->param['post']=$this->input->post(NULL,true);
	$this->showView();
	$url=base_url('stock/report');
	redirect($url,'refresh');
	
}


/*
	VIEW
*/
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
			$this->checkView( $this->param['load_view'] );
			
		}else{ redirect(base_url().$this->uri->segment(1)."/index","refresh");	}
		$this->load->view('base_view', $this->param);
	
	}
	
	private function loadData( ){
		$this->checkView($this->param['folder'].$this->param['content']."_body", 'body');
		$param=$this->param;
		$param['get']=$this->input->get(NULL,true);
		$param=$this->load->view( $this->param['folder'].$this->param['content']."_body",$param,TRUE);
		
		return json_decode($param,TRUE);
	}
	
	private function checkView($target,$stat='view'){
		//return true;
		if(!is_file("views/".$target.".php") && ($stat=='view'||$stat=='body') ){
			$txt="<?php 
/****
	views	: $target
	created	: ".date("d-m-Y H:i:s")."
	By		: CI3 Stock Controllers
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
	By		: CI3 Stock Controllers
****/";	
			file_put_contents ("assets/js/".$target , $txt,LOCK_EX );
			logCreate('create file:'."assets/js/".$target);
		}else{}
	}

	private function userId(){
		$this->load->library('session');
		$userid = $this->session->userdata('nasgor_userid');
		if(!$userid){
			$ar=array('nasgor_userid'=>1981);
			$this->session->set_userdata($ar );
			redirect(current_url(),'refresh');
		}else{}
		return $userid;
	}
	
	private function userDetail($id=1981){
		$ar=array(
			'id'=>$id,
			'name'=>'demo 123',
			'username'=>'demo',
			'password'=>md5('123123:tokenku')
			
		);
		return $ar;
	}
	
	private function userGroup($id){	
		return array(61,62);
	}
/*

*/
	function __CONSTRUCT(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('formBootsrap');
		$this->load->model('menu_model','menu');
		$this->load->model('productCategory_model','category');
		$this->load->model('productObject_model','objProduct');
		$this->load->model('productLocation_model','location');
		$this->load->model('productType_model','type');
		$this->load->model('productInvoice_model','invoice');
		$this->load->model('productFlow_model','flow');
		$this->load->model('productGroup_model','group');
		// $this->load->driver('stocks');
		// $this->stockDriver = $this->stocks;
		$this->load->library('stock_libs');
		$this->stockLibs = $this->stock_libs;
	
		date_default_timezone_set('Asia/Jakarta');
		$this->param['today']=date('Y-m-d');
		$this->param['folder']='stock/';
		$this->param['footerJS']=array();
		$this->param['mainMenu']=$this->menu->generate('stock');
		
		$this->param['thisUrl']= $this->uri->segment(1).'/'.$this->uri->segment(2);
		$this->param['css']=array(			
			'cupertino/jquery-ui-1.10.3.custom.min.css',
			'jqgrid3.8/ui.jqgrid.css'
		);
		$this->param['js']=array(
			'jquery-1.9.min.js',	
			'bootstrap.js',
		);
		
		$this->param['footerJS']=array(			
			'jquery-ui-1.9.2.min.js',			
			'jqgrid3.8/i18n/grid.locale-en.js',
			'jqgrid3.8/jquery.jqGrid.js', 
		);
//=============MAIN JS		
		$jsScript='main.js';
		$this->checkView($jsScript,'js');
		$this->param['footerJS'][]=$jsScript;
//=============sub JS 			
		$name=$this->uri->segment(2,'');
		$jsScript=$this->param['folder'].$this->uri->segment(1)."_".$name.".js";
		if($name!=''){
			$this->param['footerJS'][]=$jsScript;
			$this->checkView($jsScript,'js');
		}else{}
		$this->param['title']='Jqgrid example';
		
		$this->param['userid']=$this->userId();
		$this->param['user']=$this->userDetail( $this->param['userid'] );
		$this->param['group']=$this->userGroup( $this->param['userid'] );
		//berisi detail user
		$this->param['id']=dbId();
		$this->param['idStock']=dbId('stock',20,3);
		logCreate('request:'.json_encode($_REQUEST));
		
		//log_message('debug','post:'.json_encode($_POST));
		//log_message('debug','get:'.json_encode($_GET));
	}

}
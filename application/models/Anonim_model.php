<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Anonim_model extends CI_Model {
public $table='pro_anonim';
public $table2='pro_anonimdaftar';
//anonim_model
function saveDetail($post0){
	$data=$post0['daftar'];
	$post=array();
	foreach($data as $values){
		$post[$values['name']]=$values['value'];
	}
	$id=dbId('anonim');
	$status=0;//delete
	if($post0['status']=='ambulance')$status=3;
	if($post0['status']=='homecare')$status=2;
	if(!isset($post['pat_complDet']))$post['pat_complDet']=array();
	$data=array( 
		'pat_id'=>$id,
		'pat_name'=>$post['pat_name'],
		'pat_umur'=>$post['pat_umur'],
		'pat_phone'=>$post['pat_phone'],
		'pat_addr'=>$post['pat_addr'],
		'pat_addr2'=>$post['pat_addr2'],
		'pat_compl'=>$post['pat_compl'],
		'pat_compl2'=>json_encode($post['pat_complDet']),
		'pat_status'=>$status
	);
	$this->db->insert($this->table, $data);
	
	$data=$post0['contact'];$post=array();
	foreach($data as $values){
		$post[$values['name']]=$values['value'];
	}
	
	$data=array( 
		'patdaf_id'=>$id,
		'patdaf_name'=>$post['pat_name'], 
		'patdaf_phone'=>$post['pat_phone'],
		'patdaf_addr'=>$post['pat_addr'], 
	);
	$this->db->insert($this->table2, $data);
	
}
function saveNormal($post){
	//{"pat_name":"gunawan","pat_umur":"12","pat_phone":"1231412","pat_addr":"sdasfasfas","pat_addr2":"","pat_compl":""}
	$id=dbId('anonim');
	$data=array( 
		'pat_id'=>$id,
		'pat_name'=>$post['pat_name'],
		'pat_umur'=>$post['pat_umur'],
		'pat_phone'=>$post['pat_phone'],
		'pat_addr'=>$post['pat_addr'],
		'pat_addr2'=>$post['pat_addr2'],
		'pat_compl'=>$post['pat_compl'],
		'pat_compl2'=>json_encode($post['pat_complDet']),
		'pat_status'=>1
	);
	$this->db->insert($this->table, $data);
	$data=array( 
		'patdaf_id'=>$id,
		'patdaf_name'=>$post['pat_name'], 
		'patdaf_phone'=>$post['pat_phone'],
		'patdaf_addr'=>$post['pat_addr'], 
	);
	$this->db->insert($this->table2, $data);
	
}

public function __construct()
 {
    $this->load->database();
	$this->load->helper('date_helper');
 }
}
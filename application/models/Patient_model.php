<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Patient_model extends CI_Model {
public $table='pro_anonim';
public $table2='pro_anonimdaftar';

	function getById($id){
		$sql="select pat_id, pat_name, pat_umur, pat_phone, pat_addr, pat_compl,pat_compl2
		from {$this->table} where pat_id=$id";
		return $this->db->query($sql)->row_array();
	}
	function getByStatus($idStatus, $limit=15){
		$sql="select pat_id, pat_name, pat_umur, pat_phone, pat_addr, pat_compl,pat_compl2
		from {$this->table} where pat_status=$idStatus order by pat_input desc limit $limit";
//		$sql="select * from {$this->table} limit 1";
		$data=$this->db->query($sql)->result_array();
//die(print_r($data,1));
		$result=array();
		foreach($data as $n=>$row){
			$compl2=json_decode($row['pat_compl2'], true);
			if(count($compl2)){
				$row['pat_compl'].="<br/>Keluhan lain:".implode(", ",$compl2);	
			}else{}
			$result[$n]=$row;
		}
		return $result;
		/*
		'pat_id'=>$id,
		'pat_name'=>$post['pat_name'],
		'pat_umur'=>$post['pat_umur'],
		'pat_phone'=>$post['pat_phone'],
		'pat_addr'=>$post['pat_addr'],
		'pat_addr2'=>$post['pat_addr2'],
		'pat_compl'=>$post['pat_compl'],
		'pat_compl2'=>json_encode($post['pat_complDet']),
		'pat_status'=>1
		*/
	}
	function totalbyCat()
	{
		$sql="select pat_status stat, count(pat_id) tot from ".$this->table." 
		group by pat_status";
		$data=$this->db->query($sql)->result_array();
		$result=array();
		foreach($data as $row){
			$result[$row['stat']]=$row['tot'];
		}
		return $result;
	}

  public function __construct()
 {
    $this->load->database();
	$this->load->helper('date_helper');
 }
}
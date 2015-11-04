<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class ProductInvoice_model extends CI_Model {
public $table='pro_invoices';
/***
table:pro_invoices
id, code, detail, date
***/
public $tableObject='pro_invoiceobject';
public $tableFlow='pro_invoiceflow';

 function detail($id,$field='id'){
	$sql="select id, code, detail, date
	from {$this->table} where $field=$id";	 
	$data=dbFetchOne($sql); 
	if($data==false)return false;
	$clean_data=dbCleanField($data,' '); 
	return $clean_data ;
 }
 
function total($group=0){
	 
	$sql="select count(*) total from {$this->table} ";
	$data=dbFetchOne($sql);
	return isset($data['total'])?$data['total']:false;
	
}
 
 public function __construct()
 {
    $this->load->database();
	$this->load->helper('date_helper');
 }

}
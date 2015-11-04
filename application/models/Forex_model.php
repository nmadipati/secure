<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Forex_model extends CI_Model {
public $table='pro_anonim';
public $table2='pro_anonimdaftar';

function createNew($input){
	$idUser=dbId('forexLiveUser',204000);
	$hexdate=dechex( date("Ymdh"));
	$username0=strtoupper(base64_encode($hexdate));
	$username=sprintf("%s%06s",substr($username0,0,3),$idUser);
	$users=array(
	   'userid'=>$idUser,
	   'username'=>$username,
	   'password'=>$input['password'],
	   'act_type'=>$input['act_type'],
	   'leverage'=>$input['leverage'],
	   'investor_password'=>$input['investor_password']
	   //'u0'=>$username0
	);
	return $users;
}

	function liveuserCreate($input){
		return $this->createNew($input);
	}

  public function __construct()
 {
    $this->load->database();
	$this->load->helper('date_helper');
 }
}
<?php
//altodriver
defined('BASEPATH') OR exit('No direct script access allowed');

class Altodriver extends CI_Driver_Library {
private $CI;
public $params;
public $validAction;
	private function validAction($action=''){
		$arAction=$arTmp=$arTmp2=array();
/* add to action and remove arTmp */
		$arTmp2=$arAction;$arTmp=array(); 
/*=========GROUP=======*/
		$arTmp=array( 
			'groupList',
			'groupDetail',
		);
		$arAction = array_merge($arTmp, $arTmp2);
		
/* add to action and remove arTmp */
		$arTmp2=$arAction;$arTmp=array(); 
/*=====USER====*/			
		$arTmp=array( 
			'userList',
			'userDetail',
			'userListgroup'
		);
		$arAction = array_merge($arTmp, $arTmp2);
		
		if(in_array($action,$arAction)){
			logConfig('action:'.$action.'|valid','logAlto');
			return true;
		}
		logConfig('action:'.$action.'|not valid','logAlto');
		return false;
	}

	public function valid($module='',$action=''){	
		$aSearch = $this->valid_drivers;		
		if(in_array($module,$aSearch)){ 
			$function=strtolower($module).ucfirst(strtolower($action));
			//$result=$this->validAction0($function);
			//logConfig('valid0|func:'.$function.'|result:'.$result,'logAlto','debug');
			$result= $this->validAction($function);
			if($result){
				return $result;
			}else{ return array('error'=>14); }
		}
		else{
			logConfig('module:'.$module.'|not valid','logAlto');
			logConfig('module:'.$module.'|search:'.json_encode($aSearch),'logAlto','debug');
			return array('error'=>24);
		}
	}
	
	public function run($module='',$action='', $params=array() ){
		$function=strtolower($module).ucfirst(strtolower($action));		
		$result= $this->$module->$function($params);  
		logConfig('altoDriver|module:'.$module.'|function:'.$function,'logAlto');
		return $result;
	}
	
	public function __construct($params=array() )
    {
		$this->params=$params;
		$this->CI =& get_instance();
		$this->valid_drivers = array('group','user'); 
		
    }
	
	private function validAction0($action=''){
		$dir=APPPATH.'libraries/Altodriver/drivers';
		$arAction=array();
		logConfig('validAction0|dir:'.$dir.'|action:'.$action,'logAlto');
		if ($handle = opendir($dir)){
			while (false !== ($entry = readdir($handle))) {
				if($entry!=='.'&&$entry!=='..'){
					$name=strtolower(trim($entry));//Alto_group.php
					$name0=substr($name,0,strlen($name)-4);
					$name= str_replace("_",'',$name0);
					logConfig('arAction:'.$name."|name:".$name,'logAlto');
					$arAction[]=$name;
				}
			}
	
		}
		
		if(in_array(strtolower($action),$arAction)){
			logConfig('validAction0|action:'.strtolower($action)."|ok",'logAlto');
			return true;
		}
		logConfig('validAction0|action:'.strtolower($action)."|fail",'logAlto');
		return false;
	}
	
	function test(){
		$dir=APPPATH.'libraries/Altodriver/drivers';
		if ($handle = opendir($dir)){
			while (false !== ($entry = readdir($handle))) {
				logConfig('dir:'.$dir.'|file:'.$entry,'logAlto');
			}
	
		}
		
	}
}
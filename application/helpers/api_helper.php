<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/* 
*/
if ( ! function_exists('_runApi')){
	function _runApi($url, $parameter=array()){
	global $maxTime;
	$CI =& get_instance();
	if(count($parameter)){
		$logTxt="func:_runApi| url:{$url}| param:".http_build_query($parameter,'','&');
	}else{ 
		$logTxt="func:_runApi| url:{$url}";
	}
		logCreate( 'API: '.$logTxt); 
		
	if(count($parameter)){	
		//logCreate( 'API: '.'param:'.print_r($parameter,1),'debug');		
		logCreate( 'API: '."url:{$url}| param:".print_r($parameter,1),'debug');
	}else{ 
		logCreate( 'API: param:'.print_r(parse_url($url),1),'debug');
	}
		$curl = curl_init();
		 
		curl_setopt($curl, CURLOPT_URL, $url  );
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		if($parameter != '' && count($parameter)!=0 ) {
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_TIMEOUT, $maxTime);
			curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($parameter,'','&'));
			if( isset($_SERVER['HTTP_USER_AGENT']) ) curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
			logCreate('API:POST','info');
		}else{ 
			logCreate('API:GET','info');
		}
		
		$response = curl_exec($curl);

		if (0 != curl_errno($curl)) {
			$response = new stdclass();
			$response->code = '500';
			$response->message = curl_error($curl);
			
		}
		else{
			$response0 = $response; 
			$response = json_decode($response,1);
			if(!is_array($response)){
				$response=$response0;
			}
		}
		
		curl_close($curl);
		if(!isset($response0)) $response0='?';
		logCreate( 'API |url:'. $url. "|raw:".(is_array($response)?'total array/obj='.count($response):$response0 ) );
		 
		return $response;
			
	}
} else{}
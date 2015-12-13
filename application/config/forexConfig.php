<?php
$config['app_code']=array(
	'9912310',
);


if(defined('LOCAL')){
	$config['urlForex']=array( 
		'default'=>'localhost/forex/fake' 
		
	);
	$config['api_url']='localhost/forex/api';
}
else{ 
	$config['urlForex']=array( 
		'default'=>'http://nfx.posismo.com/api/account/openAccount' 
		
	);
	$config['api_url']='http://dev.salmaforex.com/forex/api';

}
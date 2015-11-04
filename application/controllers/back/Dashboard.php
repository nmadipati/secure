<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
function index(){
	
}

function __CONSTRUCT(){
		parent::__construct();
		redirect(base_url(),'refresh');
	}
	
}
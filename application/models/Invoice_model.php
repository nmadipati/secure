<?php
class Invoice_model extends CI_Model {
public $table='mujur_invoice';

	function total()
	{
		$sql="select count(id) total from ".$this->table;
		$data=dbFetchOne($sql);
		return isset($data['total'])?$data['total']:false;
		
		if (!$this->db->simple_query($sql)){
			logCreate('sql:'.$sql.'|'.$this->db->error(),'error');
			return false;
		}
		else{
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0){
				$row = $query->row_array();
				return $row['total'];
			}
			 
		}
	return false;
	}

        public function __construct()
        {
            $this->load->database();
			$this->load->helper('date_helper');
        }
		
}
<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

$sql="select reg_id id 
	from {$this->forex->tableRegis} order  by 
	reg_created desc limit 40";
$res=$this->db->query($sql)->result_array();
$s="<div style='width:700px;margin:auto'><table border=1>";
$i=1;
foreach($res as $row){
	$dt=$this->forex->regisDetail($row['id']);
	$s.="\n<tr><td>".$i++."</td><td>".implode("</td>\n\t\t<td>", $dt );
	//implode("</td>\n\t<td>",array_keys($row));
	$s.="</td>\n\t</tr>";
	 
}
$s.="</table></div>";

echo $s;	
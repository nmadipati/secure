<?php 
class Stockdriver_objectstock extends CI_Driver {
public $CI;
//====UPDATE
	function run($params){
		$CI = $this->CI;
//---
		extract($params);
		ob_start();
//-------DATA
if($group==0){
		$group=62;
	}else{}
if(!is_array($group)){ $group=array($group); }
$valGroup="'".implode("','", $group)."'";
	
if($objId!=0){
	$SQL="select obj_id id, obj_group `group`
FROM ".$CI->objProduct->table."   
where `obj_group` in($valGroup)
and obj_id=".$objId;

	$result=dbQuery($SQL,1);
	$row0=$result->row_array();
	$row=$CI->objProduct->detail($row0['id']);
	$groupData=$CI->group->detail($row0['group']);
	$catData=$CI->category->detail($row['category']);
}else{ 
	$row=$groupData=$catData=array();
}
?><table class='table  table-bordered'>
<?php 
$ar=array( 
'id'=>$objId, 'code'=>$row['code'],	
	'name'=>$row['name'],
	'detail'=>$row['detail'], 
);
	foreach($ar as $nm=>$val){
	?>
	<tr><td><?=$nm;?></td><td>:</td><td><?=$val;?></td></tr>
<?php 
	}
	
	$ar=array();
$objLoc0=$CI->location->listAll($group,1) ;
	$key=array_keys ($objLoc0);
	foreach($key as $idKey){
		$objLoc=$objLoc0[$idKey]; //$key[0]]; 
		$total=0;
		foreach($objLoc as $loc_id=>$loc_name){ 
			$n=$CI->flow->totalInLocation((int)$objId,(int)$loc_id);
			 if($n==0)continue;
			$arLocation=$CI->location->detail((int)$loc_id);
			$ar[ ]=array( 'name'=>$loc_name, 'qty'=>number_format($n,0));
			$total+=$n;
		}
	}
	//$ar[ ]=('Total' ]=number_format($total,0)." {$row['entity']}";
		
	if($total!=0){
	?></table>
	<table class='table table-striped' ><tr><th colspan=2>STOCK </th><th><?=number_format($total,0)." {$row['entity']} ";?></th></tr>
	<tr>
	  <th>Location</th>
	  <th>Quantity</th>
	  <th>Subtotal</th>
	</tr>
	<?php 
		$sub=0;
		foreach($ar as $nm=>$data){?>
	<tr>
	  <td><?=$data['name'];?></td>
	  <td><?="{$data['qty']} {$row['entity']}";?></td>
	  <td><?php $sub+=$data['qty']; 
	  echo $sub." {$row['entity']}";?></td>
	</tr>
<?php 
		}
	 
	}
	else{
	?><tr><th colspan=3>NO STOCK</th></tr><?php 
	}
?>
</table>
<?php 
			$link='stock/input/'.$objId;
		echo anchor($link, 'Update Stock', 'class="btn btn-primary"');
		 
		$table = ob_get_contents();
		ob_end_clean();
			$responce['result']=$table;
		$responce['footer']='';	
//---
		return $responce;
	} 

	public function __construct( )
    { 
		$this->CI =& get_instance();  
    }
}	

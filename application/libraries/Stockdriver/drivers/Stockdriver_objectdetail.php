<?php 
class Stockdriver_objectdetail extends CI_Driver {
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
		?><table class='table table-striped table-bordered'>
		<?php 
		$ar=array( 
		'id'=>$objId,
		'code'=>$row['code'],	
			'name (invoice)'=>$row['name'],
			'name (original)'=>$row['name0'],
			'detail'=>nl2br($row['detail'])
		);
			foreach($ar as $nm=>$val){?>
	 <tr>
			<td><?=$nm;?></td>
			<td>&nbsp;:&nbsp;</td>
			<td><?=$val;?></td>
	 </tr>
<?php 
			}
		?>
		</table>
		<?php 
			$link='stock/input/'.$objId;
		echo anchor($link, 'Update Stock', 'class="btn btn-primary"');
		?>
		<!--http://localhost/stock/input/{id}-->
		<?php 
		$table = ob_get_contents();
		ob_end_clean();
		$responce['body']= $responce['result']=$table;
		$responce['footer']='';	
		$responce['row']=$row;
//---
		return $responce;
	} 

	public function __construct( )
    { 
		$this->CI =& get_instance();  
    }
}	

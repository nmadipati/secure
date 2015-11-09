<?php 

class Stockdriver_category extends CI_Driver {
public $CI;
	public function detail($params=array()){
	//$catModel =$this->CI->load->model('productCategory_model');
//	$CI =& get_instance(); 
	ob_start();
	extract($params);
		if($group==0){
			$group=62;
		}else{}
		if(!is_array($group)){ $group=array($group); }
		$valGroup="'".implode("','", $group)."'";
			
		$SQL="select cat_id id, cat_name name, cat_detail detail,cat_group `group`
		FROM ".$this->CI->category->table."   
		where `cat_group` in($valGroup)
		and cat_id=".$catId;

		$result=dbQuery($SQL,1);
		$catData=$result->row_array();
		?>
<table class='table table-striped table-bordered'>
<?php 
$ar=array( 
'id'=>$catId,
	'name'=>$catData['name'],
	'detail'=>$catData['detail']
);
	foreach($ar as $nm=>$val){
	?><tr><td><?=$nm;?></td><td>:</td><td><?=$val;?></td></tr><?php 
	}
?>
</table>
<?php 
$form = ob_get_contents();
ob_end_clean();
	
	$responce['body']=$form;
	$responce['footer']='';
		return $responce;
	}
 
	public function __construct( )
    { 
		$this->CI =& get_instance();  
    }
}	
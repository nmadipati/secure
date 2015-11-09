<?php 
class Stockdriver_objectedit extends CI_Driver {
public $CI;
//====UPDATE
	function data($params){
		$CI = $this->CI;
		ob_start();
		extract($params);
//-------DATA
		if($group==0){
				$group=62;
			}else{}
		if(!is_array($group)){ $group=array($group); }
		$valGroup="'".implode("','", $group)."'";
			
		if($post['id']!=0){
			$SQL="select obj_id id, obj_group `group`
		FROM ".$CI->objProduct->table."   
		where `obj_group` in($valGroup)
		and obj_id=".$post['id'];

		$result=dbQuery($SQL,1);
		$row0=$result->row_array();
			$row=$CI->objProduct->detail($row0['id']);
			$groupData=$CI->group->detail($row0['group']);
			$catData=$CI->category->detail($row['category']);
		}else{ 
			$row=$groupData=$catData=array();
		}
		 
		$oth=array(
		  'onclick'=>'saveCategory()'
		);
		$form=array(); 
		if(isset($row['code'])){
			$s= form_hidden('id',$post['id']); 
			$s.=bsInput('Code','code',$row['code']); 
			$s.=bsInput('Name','name1',$row['name0']); 
			$s.=bsInput('Invoice Name','name2',$row['name']); 
			$s.=bsInput('Entity','entity',$row['entity']); 
			$s.=bsText('Detail','note',$row['detail']);
		}
		else{ 
			$s= form_hidden('id',$post['id']); 
			$s.=bsInput('Code','code' ); 
			$s.=bsInput('Name','name1' ); 
			$s.=bsInput('Invoice Name','name2' ); 
			$s.=bsInput('Entity','entity' ); 
			$s.=bsText('Detail','note' );
		
		}
		$form['object']=$s;$s='';
		  
		if(!isset($groupData['name'])){ 	 
			$groupData=$CI->group->detail($group[0]);
			$s.="<h4>NEW INPUT FOR GROUP</h4>";
			if(count($groupData)>1){
				$s.=form_hidden('group',$group[0]);
			}else{
				$groupData=$CI->group->detail($group[1]);
				$s.=form_hidden('group',$group[1]);
			}
			//json_encode($group);
		}else{}
			$s.="Name:".$groupData['name'] ;
			$s.="<br/>".$groupData['detail'] ;
			
			$form['group']=$s;$s='';
		$data=$CI->category->listAll($group);
///=======category 		
		$category=isset($row['category'])?$row['category']:0;
		$s.=bsSelect('Category','category',$data,$category);
		if(isset($catData['detail'])){
			$s.="<hr/> Name:".$catData['name'] ;
			$s.="<br/>".$catData['detail'] ;
		}else{}
		$form['category']=$s;$s='';
		//=========result 
		$txt = ob_get_contents();
		ob_end_clean();
			$responce['body']=$form;
		if($txt!='')
			$responce['error']=$txt;
		$responce['footer']='';	
		$responce['data']=array( 
			'object'=>$row,
			'group'=>$groupData,
			'category'=>$catData
		);
		
		return $responce;
	}
	
	function run($params){
		$CI = $this->CI;
//---
		extract($params);
		ob_start();
		$responce=array();  
			$data=array( 
				'obj_code'=>$post['code'],
				'obj_name0'=>$post['name1'],
				'obj_name'=>$post['name2'],
				'obj_detail'=>$post['note'],
				'obj_entity'=>$post['entity'],
				'obj_category'=>(int)$post['category'],
				
			);
			$where="obj_id=$post[id]";
			$str = $CI->db->update_string($CI->objProduct->table, $data, $where);
			dbQuery($str,1);
			$responce['result']='id:'.$post['id'].' updated '; 

		$error = ob_get_contents();
		ob_end_clean();
		if($error!='')
			$responce['error']=$error;
//---
		return $responce;
	} 

	public function __construct( )
    { 
		$this->CI =& get_instance();  
    }
}	

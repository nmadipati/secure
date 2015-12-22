<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class='container'>
    <div style='margin-top:30px;'>
        <form novalidate="novalidate" name="frm" id0="frm" id="frmLiveAccount" method="POST"  class="form-horizontal" role="form">
		<input type='hidden' name='type' value='request' />
			<div class="frame-form-basic">
			<h2>Personal Data</h2>
			<table class='formBasic' border="0">
			<?=bsInput( lang('forex_firstname'),'firstname','', lang('forex_inputsuggestion') );?> 
			<?=bsInput( lang('forex_lastname'),'lastname','', lang('forex_inputsuggestion') );?> 
			<?=bsInput( lang('forex_address'),'address','', lang('forex_inputsuggestion2') );?>
			<?=bsInput( lang('forex_state'),'state','', lang('forex_inputsuggestion2') );?>
			 
			<?=bsInput( lang('forex_city'),'city','', lang('forex_inputsuggestion2') );?>
			<?=bsInput( lang('forex_zipcode'),'zipcode','', lang('forex_inputsuggestion') );?>
			<tr>
			<td><label for="input_date"><?=lang('forex_country');?></label></td><td>&nbsp;</td>
			<td>
			<div class="form-group">
<?php 
	$all= $this->country->getAll(); //id only
	$data=array();
	foreach($all as $row){
		$row2=$this->country->getData($row['id']);	
		$data[$row['id']]=$row2['name'];
	}
	echo form_dropdown("citizen",$data,101);
?>
		</div>
		</td>
		</tr>
		<?=bsInput( lang('forex_agent'),'agent','', lang('forex_inputsuggestion') );?>	
		</table>
		</div>
		<div class="frame-form-basic">
		<h2>Contact Information</h2>
		<table class='formBasic' border="0"> 
			<?=bsInput( lang('forex_email'),'email','', lang('forex_inputsuggestion') );?>
			<?=bsInput( lang('forex_phone'),'phone','', lang('forex_inputsuggestion') );?>
		<tr>
			<td><label for="input_date">Date of Birth</label></td><td>&nbsp;</td>
			<td><div class="form-group">
			  <input name="dob1" value="<?=date("d",strtotime("-20 years"));?>" id="input_date" class="dob"  type="text"> -
			  <input name="dob2" value="<?=date("m",strtotime("-20 years"));?>" id="input_date2" class="dob"  type="text"> -
			  <input name="dob3" value="<?=date("Y",strtotime("-20 years"));?>" id="input_date3" class="dob"  type="text">
			</div></td>
		</tr>	
		</table>
			<div class="form-group">
                <label class="col-sm-3 control-label"></label>
                <div class="col-sm-5">
                    <input name="submit" id="submit" value="Create Account" class="btn btn-info" type="button" onclick="createLiveUser()">
                </div>
            </div>
		</div>
 
            
        </form>
    </div>
</div>
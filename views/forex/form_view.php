<div class='container'>
    <div style='margin-top:30px;background:white'>
        <form novalidate="novalidate" name="frm" id0="frm" id="frmLiveAccount" method="POST"  class="form-horizontal" role="form">
			<h2>Personal Data</h2>
			<table class='formBasic'>
			<?=bsInput( lang('forex_firstname'),'realname1','', lang('forex_inputsuggestion') );?>
			<?=bsInput( lang('forex_lastname'),'realname2','', lang('forex_inputsuggestion') );?>
		<tr>
			<td><label for="input_date">Date of Birth</label></td><td>&nbsp;</td>
			<td><div class="form-group">
			  <input name="dob1" value="<?=date("d",strtotime("-20 years"));?>" id="input_date" class="form-control"  type="text"> -
			  <input name="dob2" value="<?=date("m",strtotime("-20 years"));?>" id="input_date2" class="form-control"  type="text"> -
			  <input name="dob3" value="<?=date("Y",strtotime("-20 years"));?>" id="input_date3" class="form-control"  type="text">
			</div></td>
		</tr>
		<tr>
			<td><label for="input_date"><?=lang('forex_country');?></label></td><td>&nbsp;</td>
			<td><div class="form-group">
<?php 
	$all= $this->country->getAll(); //id only
	$data=array();
	foreach($all as $row){
		$row2=$this->country->getData($row['id']);	
		$data[$row['id']]=$row2['name'];
	}
	echo form_dropdown("citizen",$data);
?>
			</table>
			<h2>Contact Information</h2>
			<table class='formBasic'>
			<?=bsInput( lang('forex_email'),'email','', lang('forex_inputsuggestion') );?>
			<?=bsInput( lang('forex_phone'),'phone','', lang('forex_inputsuggestion') );?>
			</table>
<!--			
Email
Mobile phone
Access Password
Confirm Password
            <div class="form-group">
                <label class="col-sm-3 control-label"><strong>Account Type :</strong>
                </label>
                <div class="col-sm-5">
                    <select name="act_type" id="act_type" class="form-control">
                        <option value="">-- Select account type --</option>
                        <option value="1">CENT</option>
                        <option value="2">MINI FIXED</option>
                        <option value="3">MINI S</option>
                        <option value="4">STANDARD</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><strong>Leverage :</strong>
                </label>
                <div class="col-sm-5" id="decision" style="display: none;">
                    <select name="leverage17" id="leverage17" class="form-control">
                        <option value="">-- Select leverage --</option>
                        <option value="1">1:1</option>
                        <option value="2">1:2</option>
                        <option value="3">1:3</option>
                        <option value="5">1:5</option>
                        <option value="10">1:10</option>
                        <option value="15">1:15</option>
                        <option value="20">1:20</option>
                        <option value="25">1:25</option>
                        <option value="33">1:33</option>
                        <option value="50">1:50</option>
                        <option value="66">1:66</option>
                        <option value="75">1:75</option>
                        <option value="100">1:100</option>
                        <option value="125">1:125</option>
                        <option value="150">1:150</option>
                        <option value="175">1:175</option>
                        <option value="200">1:200</option>
                    </select>
                </div>
                <div class="col-sm-5" id="reason" style="display: inline-block;">
                    <select name="leverage" id="leverage" class="form-control">
                        <option value="">-- Select leverage --</option>
                        <option value="1">1:1</option>
                        <option value="2">1:2</option>
                        <option value="3">1:3</option>
                        <option value="5">1:5</option>
                        <option value="10">1:10</option>
                        <option value="15">1:15</option>
                        <option value="20">1:20</option>
                        <option value="25">1:25</option>
                        <option value="33">1:33</option>
                        <option value="50">1:50</option>
                        <option value="66">1:66</option>
                        <option value="75">1:75</option>
                        <option value="100">1:100</option>
                        <option value="125">1:125</option>
                        <option value="150">1:150</option>
                        <option value="175">1:175</option>
                        <option value="200">1:200</option>
                        <option value="300">1:300</option>
                        <option value="400">1:400</option>
                        <option value="500">1:500</option>
                        <option value="1000">1:1000</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"></label>
                <div class="col-sm-5">
                    <input name="check" id="check" onchange="myfunction();" type="checkbox">Generate Trader's Password Automatically</div>
            </div>
            <div class="form-group" id="hid2" style="display:none">
                <label class="col-sm-3 control-label"></label>
                <div class="col-sm-5" id="pass"></div>
            </div>
            <div class="form-group" id="hid">
                <label class="col-sm-3 control-label"><strong>Trader's Password :</strong>
                </label>
                <div class="col-sm-5">
                    <input name="password" id="password" class="form-control" type="password"><span id="password_Warn" class="err"></span>

                </div>
            </div>
            <div class="form-group" id="hid1">
                <label class="col-sm-3 control-label"><strong>Confirm Password :</strong>
                </label>
                <div class="col-sm-5">
                    <input name="confirm_password" id="confirm_password" class="form-control" type="password">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"></label>
                <div class="col-sm-5">
                    <input name="check1" id="check1" onchange="myfunction1();" type="checkbox">Generate Investor's Password Automatically</div>
            </div>
            <div class="form-group" id="investor2" style="display:none">
                <label class="col-sm-3 control-label"></label>
                <div class="col-sm-5" id="investor_pass"></div>
            </div>
            <div class="form-group" id="investor">
                <label class="col-sm-3 control-label"><strong>Investor's Password :</strong>
                </label>
                <div class="col-sm-5">
                    <input name="investor_password" id="investor_password" class="form-control" type="password">
                </div>
            </div>
            <div class="form-group" id="investor1">
                <label class="col-sm-3 control-label"><strong>Confirm Password :</strong>
                </label>
                <div class="col-sm-5">
                    <input name="confirm_investor_password" id="confirm_investor_password" class="form-control" type="password">
                </div>
            </div>
-->
            <div class="form-group">
                <label class="col-sm-3 control-label"></label>
                <div class="col-sm-5">
                    <input name="submit" id="submit" value="Open Account" class="btn btn-info" type="button" onclick="createLiveUser()">
                </div>
            </div>
        </form>
    </div>
</div>
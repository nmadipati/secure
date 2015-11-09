/* FOREX */
function createLiveUser(){
	var url=siteUrl+"forex/data";
	var formData=jQuery("#frmLiveAccount").serializeArray();
	params={type:"request",data:formData}
	respon=sendAjax(url,params);
	respon.success(function(result,status) {
		  clearModal();
		if(result.status==true){ 
			jQuery(".modal-title").html(result.data.title);
			jQuery(".modal-body").html(result.data.html);
		}else{
			jQuery(".modal-title").html("WARNING");
			jQuery(".modal-body").html(result.message);
			
		}
		
		jQuery("#myModal").modal({show: true});	
		console.log("success");
			console.log(result);
			
	   });
	   respon.error(function(xhr,status,msg){			
			console.log("Error");
			console.log(status);
			console.log(msg);
			console.log(xhr);
			
		});
}


jQuery(function() {
    jQuery( ".datepicker,#input_dob" ).datepicker({
	dateFormat:'yy-mm-dd',
	showAnim: "fold"
	});
	
 
  });
  
 

function sendAjax(url,params){
	var request = jQuery.ajax({
          url: url,
          type: "POST",
          data: params,
          dataType: "json", 
		  cache:false,
		  timeout:20000, 
    });
	
	return request;
}

//jQuery( ".datepicker, #input_dob" ).datepicker({ dateFormat:'yy-mm-dd'});
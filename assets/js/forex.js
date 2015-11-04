/* FOREX */
function createLiveUser(){
	var url=siteUrl+"forex/data";
	var formData=$("#frmLiveAccount").serializeArray();
	params={type:"request",data:formData}
	respon=sendAjax(url,params);
	respon.success(function(result,status) {
		  clearModal();
		if(result.status==true){ 
			$(".modal-title").html(result.data.title);
			$(".modal-body").html(result.data.html);
		}else{
			$(".modal-title").html("WARNING");
			$(".modal-body").html(result.message);
			
		}
		
		$("#myModal").modal({show: true});	
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


$(function() {
    $( ".datepicker" ).datepicker({
	dateFormat:'yy-mm-dd',
	showAnim: "fold"
	});
	
	$("#myModal").modal({show:false});
  });
  
  function clearModal(){
	$(".modal-title, .modal-body").empty();  
  }

function sendAjax(url,params){
	var request = $.ajax({
          url: url,
          type: "POST",
          data: params,
          dataType: "json", 
		  cache:false,
		  timeout:20000, 
    });
	
	return request;
}
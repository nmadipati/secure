jQuery("#fType").jqGrid({
		url:'index2.php?option=com_rs&l=l&t=fields&opt=master',
		datatype: "json",
		colNames:['Kode', 'Nama',],
		colModel:[
			//{name:'id',index:'id', width:55},
			{name:'code',index:'code', width:90},
			{name:'name',index:'name', width:200}, 		
		],
		rowNum:10,
		width:500,
		rowList:[10,20,30],
		pager: '#fType_pager',
		sortname: 'name',
		viewrecords: true,
		sortorder: "asc",
		multiselect: false,
		caption: "MASTER FIELDS",
		onSelectRow: function(ids,stat) { 
			if(ids == null) {
				ids=0;
				if(jQuery("#fGroup").jqGrid('getGridParam','records') >0 )
				{
					jQuery("#fGroup").jqGrid('setGridParam',{url:"index2.php?option=com_rs&l=l&t=fields&opt=group",page:1});
					jQuery("#fGroup").jqGrid('setCaption',"Group Field: "+ids)
					.trigger('reloadGrid');
				}
			} else {
				var ret = jQuery("#fType").jqGrid('getRowData',ids);
				console.log(ret);
				jQuery("#fGroup").jqGrid('setGridParam',{url:"index2.php?option=com_rs&l=l&t=fields&opt=group&id="+ids,page:1});
				jQuery("#fGroup").jqGrid('setCaption',"Group Field: "+ret.name)
				.trigger('reloadGrid');			
			}
		
		}
	});
	jQuery("#fType").jqGrid('navGrid','#fType_pager',{add:false,edit:false,del:false});
	
http://localhost/sejahtera/index2.php?option=com_rs&l=h&t=billingList&layout=home
@extends($view_base_prefix . '/layouts/child')
@section('css')
<link href="{{asset_site($base_resource, 'plugin', 'jqgrid/css/ui.jqgrid.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-sm-12" style="height: 25px;">
                        <div class="ibox-tools">
                            <div class="adm-fa-hover"><a href="javascript:window.location.href='{{route('manage.role')}}'"><i class="fa fa-refresh"></i></a></div>
                        </div>
                    </div>
                </div>
                <div class="row" id="jqGridRow">
                    <div class="jqGrid_wrapper">
                        <table id="table_list_2"></table>
                        <div id="pager_list_2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{asset_site($base_resource, 'plugin', 'jqgrid/js/jquery.jqGrid.min.js')}}"></script>
<script type="text/javascript" src="{{asset_site($base_resource, 'plugin', 'jqgrid/js/i18n/grid.locale-cn.js')}}"></script>
<script type="text/javascript" src="{{asset_site($base_resource, 'js', 'jqgrid-custom.js')}}"></script>
<script type="text/javascript">
var statusJson = {"on":"正常","off":"禁用"};
$(document).ready(function() {
	$("#table_list_2").jqGrid({
        url: "{{route('manage.role.list', ['param'=>'type'])}}",
		editurl: "{{route('manage.role.modify')}}",
		datatype: "json",
		height:$(window).height() - 210,
		autowidth: true,
		shrinkToFit: true,
		rowNum: {{$rows}},
		rowList: [10, 20, 30],
        sortname: 'role_id',
        sortorder: 'desc',
		loadComplete : function(xhr){ //请求成功事件
			try{
				$('.ui-jqdialog-titlebar-close').click();
			}catch(e){}
		},
		colNames: ["序号", "角色名", "角色描述", "角色状态", "创建时间"],
		colModel: [
			{name:"role_id",index: "role_id",width: 60,sorttype: "int",editable:true,align: "center",search: true,hidden:true},
			
			{name:"role_name",index:"role_name",align: "center",editable:true,width: 90,search: true},
			
			{name:"role_description",index:"role_description",align: "center",editable:true,edittype:'text',editrules:{edithidden:true,required:true},width: 90,search: true},
            
            
            {name:"role_status",index:"role_status",align: "center",editable:true,edittype:'custom',editrules:{edithidden:true,required:true,minValue:0},
				editoptions:{
					custom_value: function(elem, oper, value){return getFreightElementValue(elem, oper, value, 'radio')},
					custom_element: function(value, editOptions){return createFreightEditElement(value, editOptions, statusJson, 'radio', 'single')}
				},
				formatter:function(cellvalue, options, rowObject){
					return arrFormat(cellvalue, statusJson, 'single');
				},
				unformat:function(cellvalue, options){
					return arrUnformat(cellvalue, statusJson, 'single');
				},
				width: 90,search: true},
            
			{name:"created_at",index:"created_at",align: "center",editable:false,width: 90,search: true},
		],
		pager: "#pager_list_2",
		viewrecords: true,
        pgbuttons:true,
		hidegrid: false
	}).navGrid('#pager_list_2', {edit: true, add: true, del: false, search:true,searchtext:''},{
		editCaption : "修改",
		top:50,
		left:($(document).innerWidth() - 400) / 5 * 2,
		width:500,
		jqModal : true,  
		reloadAfterSubmit : true,  
		afterShowForm : function(form) {},  
		afterSubmit: function(response, postdata) {
			if (response.responseJSON.code == 0) {
				return [false, response.responseJSON.msg];
			} else {
				window.top._toastr(response.responseJSON.msg);
				return [true, '', ''];
			}
		}
	},{
		addCaption : "新增",
		top:50,
		left:($(document).innerWidth() - 400) / 5 * 2,
		width:500,
		modal:true,
		jqModal: true,
		reloadAfterSubmit : true,
		afterShowForm : function(form) {},  
		afterSubmit: function(response, postdata) {
			if (response.responseJSON.code == 0) {
				return [false, response.responseJSON.msg];
			} else {
				window.top._toastr(response.responseJSON.msg);
				return [true, '', ''];
			}
		}
	},{
		caption : "搜索",
		top:50,
		left:($(document).innerWidth() - 400) / 5 * 2,
		width:500,
		multipleSearch:true
	}).navButtonAdd('#pager_list_2', {
		caption:"",
		buttonicon:"fa fa-legal",
		position: "last",
		title:"设置权限",
		cursor: "pointer",
		onClickButton:function(){
            var id = $("#table_list_2").jqGrid('getGridParam','selrow');
            if (!id) {
                layer.msg("请选择记录", {time:2000,icon: 5, shade:0.3});
            } else {
                var rowData = $("#table_list_2").jqGrid("getRowData", id);
                popup("{{route('manage.role.permissions')}}?role_id="+rowData.role_id, "权限设置");
            }
		}
	});
});
//设置宽度
jQuery("#table_list_2").setGridWidth($("#jqGridRow").innerWidth(), true);
</script>
@endsection
@extends($view_base_prefix . '/layouts/child')
@section('css')
    
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <form id="modifyRoleAuthForm" class="form-horizontal m-t" method="post" action="{{route('manage.role.permissions')}}" novalidate="novalidate" enctype="multipart/form-data">
                    <input type="hidden" name="role_id" value="{{$role_id}}">
                    <div class="form-group">
                        <div class="col-sm-12">
                        @foreach ($permissions as $group)
                                <div class="ibox float-e-margins clear">
                                    <div class="ibox-title">
                                        <div class="col-sm-3">
                                            <div class="checkbox checkbox-success">
                                                <input id="{{$loop->index}}" class="checkbox-parent" type="checkbox">
                                                <label for="{{$loop->index}}"><h5>{{$group['label']}}</h5></label>
                                            </div>
                                        </div>
                                        <div class="ibox-tools">
                                            <a class="collapse-link">
                                                <i class="fa fa-chevron-up"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ibox-content">
                                        @foreach ($group['menu'] as $permission)
                                            <div class="col-sm-3">
                                                <div class="checkbox checkbox-primary">
                                                    @if (isset($role_permissions[$permission['alias'] . '-' . $permission['method']]))
                                                        <input id="{{$permission['alias']}}" name="menus[]" value="{{$permission['alias']}}-{{$permission['method']}}" class="{{$loop->parent->index}}-select-child" type="checkbox" checked>
                                                    @else
                                                        <input id="{{$permission['alias']}}" name="menus[]" value="{{$permission['alias']}}-{{$permission['method']}}" class="{{$loop->parent->index}}-select-child" type="checkbox">
                                                    @endif
                                                    <label for="{{$permission['alias']}}">{{$permission['label']}}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 text-right">
                            <div class="col-sm-offset-2">
                                <button class="btn btn-primary" type="submit">保存</button>
                                <button class="btn btn-white" type="button" onclick="javascript:parent.layer.closeAll();">取消</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    
<script src="{{asset_site($base_resource, 'plugin', 'validform/js/validform.min.js')}}"></script>
<script>
$(function(){
    $(".checkbox-parent").on('click', function(){
        if (this.checked) {
            $("."+$(this).attr('id') + "-select-child").prop('checked', true);
        } else {
            $("."+$(this).attr('id') + "-select-child").prop('checked', false);
        }
    });
    $("#modifyRoleAuthForm").Validform({
        tiptype:function(msg, o, cssctl){
            if (o.type != 2) {
                layer.msg(msg, {'icon':2});
                return false;
            }
        },
        ajaxPost:true,
        beforeSubmit:function(form){
            if ($("#modifyRoleAuthForm").prop('disabled') == true) {
                layer.msg('不能重复提交表单', {'icon':2});
                return false;
            }
            $("#modifyRoleAuthForm").prop('disabled', true);
            var add_sow_load = layer.load();
            $.ajax({
                type    : 'post',
                url     : $(form).attr('action'),
                data    : $(form).serialize(),
                dataType: 'json',
                success:function(json){
                    layer.close(add_sow_load);
                    if (json.code == 1) {
                        parent.layer.closeAll();
                        window.top._toastr('操作成功');
                        if (json.url) parent.window.location.href=json.url;
                    } else {
                        $("#modifyRoleAuthForm").prop('disabled', false);
                        window.top._toastr(response.responseJSON.msg);
                        window.top._toastr(json.msg, 'error');
                    }
                    return false;
                },
                error:function(){
                    layer.close(add_sow_load);
                    window.top._toastr('网络错误', 'error');
                }
            });
            return false;
        }
    });
});
</script>
@endsection
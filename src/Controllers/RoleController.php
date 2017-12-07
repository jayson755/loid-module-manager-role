<?php

namespace Loid\Module\Manager\Role\Controllers;

use Illuminate\Http\Request;
use Loid\Frame\Controllers\Controller;
use DB;
use LogicRole;

class RoleController extends Controller{
    
    private $moudle = 'loid-module-manager-role';
    
    public function __construct(){
        parent::__construct();
        
        if ($moudle = DB::table('system_support_moudle')->where('moudle_sign', $this->moudle)->first()) {
            $this->view_prefix = $moudle->view_namespace . '::' . config('view.default.theme') . DIRECTORY_SEPARATOR;
        }
    }
    
    public function index(Request $request){
        return $this->view("{$this->view_prefix}/index", [
            'rows' => $this->rows,
            'view_prefix' => $this->view_prefix
        ]);
    }
    
    public function _getList($type){
        return \Loid\Frame\Support\JqGrid::instance(['model'=> DB::table('system_manager_role'),'vagueField'=>['role_id','role_name','role_description','role_status','role_belong','created_at']])->query();
    }
    
    /**
     * 操作角色
     */
    public function modify(Request $request){
        $role_name = $request->input('role_name');
        $role_description = $request->input('role_description');
        $role_status = $request->input('role_status');
        
        $params = [
            'role_name' => $role_name,
            'role_description' => $role_description,
            'role_status' => $role_status,
            'role_belong' => \Auth::user()->id
        ];
        
        try {
            if ('add' == $request->input('oper')) {
                LogicRole::add($params);
            } else {
                LogicRole::modify($request->input('role_id'), $params);
            }
        } catch (\Exception $e) {
            return $this->response(false, '', $e->getMessage());
        }
        return $this->response(true);
    }
    
    /**
     * 权限设置
     */
    public function permissions(Request $request){
        $role_id = $request->input('role_id');
        if ($request->isMethod('post')) {
            try {
                LogicRole::modifyPermissions((int)$role_id, $request->input('menus', []));
            } catch (\Exception $e) {
                return $this->response(false, '', $e->getMessage());
            }
            return $this->response(true);
        } else {
            return $this->view("{$this->view_prefix}/permissions", [
                'permissions' => config('permission.menus'),
                'role_id' => $role_id,
                'role_permissions' => get_val_by_Key('access_gisn', LogicRole::getPermissions((int)$role_id), 'access_gisn')
            ]);
        }
    }
}

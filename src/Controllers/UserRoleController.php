<?php

/**
 * 用户角色
 */
namespace Loid\Module\Manager\Role\Controllers;
use Loid\Module\Manager\Role\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use LogicRole;

class UserRoleController extends Controller{
    
    
    public function index(){
        return $this->view("{$this->view_prefix}/user_role/index", [
            'view_prefix' => $this->view_prefix,
            'rows' => $this->rows,
        ]);
    }
    
    public function _getList($type){
        $list = \Loid\Frame\Support\JqGrid::instance(['model'=> DB::table('users'),'vagueField'=>['name','email'],'filtField'=>['remember_token','password']])
            ->query(['id|<>'=>\Auth::user()->id]);
            foreach ($list['rows'] as $key => $val) {
                $list['rows'][$key]['role'] = DB::table('system_manager_role')->where(function($query) use ($val){
                    $query->where('role_id', DB::table('system_manager_user_role')->where('user_id', $val['id'])->value('role_id'));
                })->value('role_name');
            }
        return $list;
    }
    
    public function modify(Request $request){
        try {
            $role = (int)$request->input('role');
            if (empty($role)) throw new \Exception('请选择角色');
            if ('edit' == $request->input('oper')) {
                LogicRole::userRoleModify((int)$request->input('id'), $role);
            } else {
                throw new \Exception('无新增操作');
            }
        } catch (\Exception $e) {
            return $this->response(false, '', $e->getMessage());
        }
        return $this->response(true);
        
    }
}

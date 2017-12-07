<?php
namespace Loid\Module\Manager\Role\Logic;

use Loid\Module\Manager\Role\Model\ManagerRole;
use DB;
use Illuminate\Http\Request;

class Role{
    
    /**
     * 添加角色
     * @param array $params 数据
     *
     * @return void
     */
    public function add(array $params){
        if (empty($params['role_name'])) throw new \Exception('角色名必须');
        
        if (!in_array($params['role_status'], ['on', 'off'])) $params['role_status'] = 'on';
        
        if (empty($params['role_belong'])) throw new \Exception('操作人缺失');
        
        $model = new ManagerRole;
        $model->role_name = $params['role_name'];
        $model->role_description = empty($params['role_description']) ? '' : $params['role_description'];
        $model->role_status = $params['role_status'];
        $model->role_belong = $params['role_belong'];
        $model->save();
    }
    
    /**
     * 角色修改
     * @param int $role_id
     * @param array $params 数据
     *
     * @return void
     */
    public function modify(int $role_id, array $params){
        $role = ManagerRole::find($role_id);
        if (empty($role)) throw new \Exception('操作对象错误');
        
        if (empty($params['role_name'])) throw new \Exception('角色名必须');
        
        if (!in_array($params['role_status'], ['on', 'off'])) $params['role_status'] = 'on';
        
        if (empty($params['role_belong'])) throw new \Exception('操作人缺失');
        
        $role->role_name = $params['role_name'];
        $role->role_description = empty($params['role_description']) ? '' : $params['role_description'];
        $role->role_status = $params['role_status'];
        $role->role_belong = $params['role_belong'];
        $role->save();
    }
    
    /**
     * 修改用户权限
     * @param $user_id 用户Id
     * @param $role_id 权限id
     *
     * @return void
     */
    public function userRoleModify(int $user_id, int $role_id){
        $role = ManagerRole::find($role_id);
        if (empty($role)) throw new \Exception('系统无该角色');
        if (!DB::table('users')->where('id', $user_id)->count()) throw new \Exception('系统无该用户');
        
        if (DB::table('system_manager_user_role')->where('user_id', $user_id)->count()) {
            DB::table('system_manager_user_role')->where('user_id', $user_id)->update([
                'role_id' => $role_id,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            DB::table('system_manager_user_role')->insert([
                'user_id' => $user_id,
                'role_id' => $role_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
    
    /**
     * 赋值权限
     * @param int $role_id 权限id
     * @param arary $permissions 功能
     * 
     * @return void
     */
    public function modifyPermissions(int $role_id, array $permissions){
        DB::table('system_manager_access')->where('role_id', $role_id)->delete();
        if (!empty($permissions)) {
            $insert_data = [];
            foreach ($permissions as $val) {
                list($alias, $method) = explode('-', $val);
                foreach (explode('|', $method) as $v) {
                    $insert_data[] = [
                        'role_id' => $role_id,
                        'access_permission' => "{$alias}.{$v}",
                        'access_gisn' => $val
                    ];
                }
            }
            DB::table('system_manager_access')->insert($insert_data);
        }
    }
    
    /**
     * 获取权限
     * @param int $role_id 权限id
     *
     * @return array
     */
    public function getPermissions(int $role_id){
        return DB::table('system_manager_access')->select(['access_gisn'])->where('role_id', $role_id)->get()->toArray();
    }
    
    /**
     * 根据用户获取权限
     * @param \App\User $user
     *
     * @return array $user_permissions
     */
    public function userPermissionsAction(\App\User $user){
        $permissions = config('permission.menus');
        if (1 === $user->id) {
            return $permissions;
        }
        $access = DB::table('system_manager_access')->select('access_gisn', 'access_permission')->where(function($query) use ($user){
            $query->where('role_id', DB::table('system_manager_user_role')->where('user_id', $user->id)->value('role_id'));
        })->get()->toArray();
        $access = get_val_by_Key('access_gisn', $access, 'access_permission');
        $user_permissions = [];
        foreach ($permissions as $key => $val) {
            $new = [
                'label' => $val['label'],
                'icon' => $val['icon'],
            ];
            foreach ($val['menu'] as $action) {
                if (isset($access[$action['alias'] . '-' . $action['method']])) $new['menu'][] = $action;
            }
            if (isset($new['menu'])) $user_permissions = array_merge($user_permissions, [$key => $new]);
        }
        return $user_permissions;
    }
    
    /**
     * 判断用户是否有某一操作权限
     * @param string $permission 权限
     * @param \App\User $user
     *
     * @return bool
     */
    public function checkUserPermissions(Request $request, \App\User $user){
        if (1 === $user->id) return true;
        if (in_array(get_class($request->route()->getController()), config('permission.no_auth_class'))) {
            return true;
        }
        if (in_array($request->route()->getActionMethod(), config('permission.no_auth_method'))) {
            return true;
        }
        if (in_array($request->route()->getActionName(), config('permission.no_auth_class_method'))) {
            return true;
        }
        $permission = $request->route()->getName() . '.' .  strtolower($request->method());
        
        if (DB::table('system_manager_access')->where(function($query) use ($user, $permission){
            $query->where('role_id', DB::table('system_manager_user_role')->where('user_id', $user->id)->value('role_id'));
            })->where('access_permission', $permission)->count()
        ) {
            return false;
        }
        return false;
    }
}
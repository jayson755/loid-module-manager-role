<?php

use Illuminate\Http\Request;

Route::get('role.api', function (Request $request, DB $db) {
    $roles = $db::table('system_manager_role')->where('role_status', 'on')->select('role_id', 'role_name')->get();
    $option = "<option>--请选择--</option>";
    foreach ($roles as $role) {
        $option .= "<option value='{$role->role_id}'>{$role->role_name}</option>";
    }
    return "<select>{$option}</select>";
})->name('api.role');


<?php

Route::group(['prefix'=>'manage', 'middleware'=>['web', 'auth', \Loid\Frame\Middleware\MoudleInit::class]], function () {
    
    Route::get('role.html', Loid\Module\Manager\Role\Controllers\RoleController::class . '@index')->name('manage.role');
    
    Route::get('role/list/{param}.html', Loid\Module\Manager\Role\Controllers\RoleController::class . '@getjQGridList')->name('manage.role.list');
    
    Route::post('role/modify.html', Loid\Module\Manager\Role\Controllers\RoleController::class . '@modify')->name('manage.role.modify');
    
    //权限设置
    Route::match(['get', 'post'], 'authorize.html', Loid\Module\Manager\Role\Controllers\RoleController::class . '@permissions')->name('manage.role.permissions');
    
    //用户角色设置
    Route::get('userrole.html', Loid\Module\Manager\Role\Controllers\UserRoleController::class.'@index')->name('manage.user.role');
    
    Route::get('userrole/list/{param}.html', Loid\Module\Manager\Role\Controllers\UserRoleController::class.'@getjQGridList')->name('manage.user.role.list');
    
    Route::post('userrole/modify.html', Loid\Module\Manager\Role\Controllers\UserRoleController::class . '@modify')->name('manage.user.role.modify');
});
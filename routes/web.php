<?php

Route::group(['prefix'=>'manage', 'middleware'=>['web', 'auth', \Loid\Frame\Middleware\MoudleInit::class]], function () {
    
    Route::get('role.html', 'Loid\\Frame\\Manager\\Role\\Controllers\\RoleController@index')->name('manage.role');
    
    Route::match(['get', 'post'], 'role/add.html', 'Loid\\Frame\\Manager\\Role\\Controllers\\RoleController@add')->name('manage.role.add');
    
    Route::match(['get', 'post'], 'role/modify.html', 'Loid\\Frame\\Manager\\Role\\Controllers\\RoleController@modify')->name('manage.role.modify');

});
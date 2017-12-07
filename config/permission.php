<?php

return [
    /*不用登陆就能访问的方法*/
    'no_login_method' => [],
    
    /*不用授权就能访问的类*/
    'no_auth_class' => [],
    
    /*不用授权就能访问的方法*/
    'no_auth_method' => [],
    
    /*菜单权限配置*/
    
    'menus' => [
        'role' => array(
            'label' => '权限管理',
            'icon'  => 'fa-cog',
            'menu'  => array(
                array('label' => '角色信息', 'display'=>true, 'alias' => 'manage.role', 'method' => 'get'),
                array('label' => '角色修改', 'display'=>false, 'alias' => 'manage.role.modify',  'method' => 'post'),
                array('label' => '角色权限设置', 'display'=>false, 'alias' => 'manage.role.permissions',  'method' => 'get|post'),
                
                array('label' => '用户角色', 'display'=>true, 'alias' => 'manage.user.role', 'method' => 'get'),
                array('label' => '用户角色修改', 'display'=>false, 'alias' => 'manage.user.role.modify',  'method' => 'post'),
            ),
        ),
    ],
];
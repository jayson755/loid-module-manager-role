<?php
/**
 *验证模块是否合法
 */
namespace Loid\Frame\Manager\Role;

use Loid\Frame\Init as FrameInit;

class Init extends FrameInit{
    
    
    /**
     *模块功能数据初始化 - 初始化当前登录用户的权限
     */
    public static function moudleInit(){
       
       //print_R(app()->auth->guard()->user());die;
       
       
       
    }
    
}

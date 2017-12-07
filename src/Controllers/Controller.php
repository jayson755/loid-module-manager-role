<?php

/**
 * 系统角色模块base控制器
 */
namespace Loid\Module\Manager\Role\Controllers;
use Loid\Frame\Controllers\Controller as LoidController;
use Illuminate\Http\Request;

class Controller extends LoidController{
    
    protected $moudle = 'loid-module-manager-role';
    
    public function __construct(){
        parent::__construct();
        if ($moudle = app()->moudle[$this->moudle]) {
            $this->view_prefix = $moudle->view_namespace . '::' . config('view.default.theme') . DIRECTORY_SEPARATOR;
        }
    }
}
<?php

namespace Loid\Frame\Manager\Role\Controllers;

use Illuminate\Http\Request;
use Loid\Frame\Controllers\Controller;
use DB;

class RoleController extends Controller{
    
    private $moudle = 'loid-module-manager-role';
    
    public function __construct(){
        parent::__construct();
        
        if ($moudle = DB::table('system_support_moudle')->where('moudle_sign', $this->moudle)->first()) {
            $this->view_prefix = $moudle->view_namespace . '::' . config('view.default.theme') . DIRECTORY_SEPARATOR;
        }
    }
    
    /**
     * 子类的重写，利用子类后期静态绑定获取子类文件路劲
     */
    protected static function getFilePath(){
        return __DIR__;
    }
    
    
    public function index(Request $request){
        return view("{$this->view_prefix}/index");
    }
    
    /**
     *添加角色
     */
    public function add(){
        
    }
    
    /**
     *更新角色
     */
    public function modify(){
        
    }
}

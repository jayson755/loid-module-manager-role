<?php
namespace Loid\Frame\Manager\Role\Api;

use Loid\Frame\Manager\Role\Model\ManagerRole as Role;
use App\User;

class ManagerRole{
    
    private $roleModel = null;
    
    public function __construct(){
        $this->roleModel = new Role;
    }
    
    /**
     * 获取指定用户的权限
     * @param App\User
     */
    public function getUserAccess(User $user){
        
    }
    
}
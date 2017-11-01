<?php

namespace Loid\Frame\Manager\Role\Model;

use Illuminate\Database\Eloquent\Model;

class ManagerRole extends Model{
    
    protected $table = 'system_manager_role';
    
    public $primaryKey = 'role_id';
    
    public $timestamps = true;
}

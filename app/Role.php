<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $primaryKey = 'id';

    public function user()
    {
        return $this->hasMany('App\Profile', 'role_FK', 'id');
    }
}

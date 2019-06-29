<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'user_FK',
        'father_name',
        'mother_name',
        'date_of_birth',
        'register',
        'address',
        'cpf',
        'rg',
        'contact',
        'photo',
        'status',
        'role_FK',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_FK', 'id');
    }

    public function role()
    {
        return $this->belongsTo('App\Role', 'role_FK', 'id');
    }
}

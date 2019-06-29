<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_FK', 'role_FK', 'status',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_FK', 'id');
    }
}

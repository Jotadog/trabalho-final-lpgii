<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    public function profile()
    {
        return $this->hasOne('App\Profile');
    }

    public function company()
    {
        return $this->hasOne('App\Company');
    }

    public function advisor()
    {
        return $this->hasOne('App\Profile');
    }
}

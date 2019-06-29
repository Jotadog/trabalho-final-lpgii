<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluationGroup extends Model
{
    public function advisor()
    {
        return $this->hasOne('App\Profile');
    }

    public function appraiser1()
    {
        return $this->hasOne('App\Profile');
    }

    public function appraiser2()
    {
        return $this->hasOne('App\Profile');
    }

    public function company()
    {
        return $this->hasOne('App\Company');
    }

    public function profile()
    {
        return $this->hasOne('App\Profile');
    }
}

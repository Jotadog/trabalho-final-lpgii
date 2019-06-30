<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    public function profile()
    {
        return $this->belongsTo('App\Profile', 'profile_FK', 'user_FK');
    }

    public function company()
    {
        return $this->belongsTo('App\Company', 'company_FK', 'id');
    }

    public function advisor()
    {
        return $this->belongsTo('App\Profile', 'advisor_FK', 'id');
    }

    protected $fillable = [
        'id',
        'profile_FK',
        'supervisor_name',
        'company_FK',
        'supervisor_phone',
        'supervisor_email',
        'start_date',
        'end_date',
        'advisor_FK'
    ];
}

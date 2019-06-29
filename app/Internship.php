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

    protected $fillable = [
        'id',
        'appraiser1_FK',
        'advisor_FK',
        'appraiser2_FK',
        'advisor_note',
        'defense_date',
        'status',
        'report_path',
        'appraiser_note1',
        'appraiser_note2',
        'company_FK',
        'user_FK'
    ];
}

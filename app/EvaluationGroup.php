<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluationGroup extends Model
{
    public function advisor()
    {
        return $this->belongsTo('App\Profile', 'advisor_FK', 'id');
    }

    public function appraiser1()
    {
        return $this->belongsTo('App\Profile', 'appraiser1_FK', 'id');
    }

    public function appraiser2()
    {
        return $this->belongsTo('App\Profile', 'appraiser2_FK', 'id');
    }

    public function company()
    {
        return $this->belongsTo('App\Company', 'company_FK', 'id');
    }

    public function profile()
    {
        return $this->belongsTo('App\Profile', 'profile_FK', 'id');
    }

    protected $fillable = [
        'appraiser1_FK',
        'appraiser2_FK',
        'advisor_FK',
        'advisor_note',
        'defense_date',
        'status',
        'report_path',
        'appraiser_note1',
        'appraiser_note2',
        'company_FK',
        'profile_FK'
    ];
}

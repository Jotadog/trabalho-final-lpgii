<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluationGroup extends Model
{
    public function advisor()
    {
        return $this->belongsTo('App\Profile');
    }

    public function appraiser1()
    {
        return $this->belongsTo('App\Profile');
    }

    public function appraiser2()
    {
        return $this->belongsTo('App\Profile');
    }

    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    public function profile()
    {
        return $this->belongsTo('App\Profile');
    }

    protected $fillable = [
        'appraiser1_FK',
        'appraiser1_FK',
        'advisor_FK',
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

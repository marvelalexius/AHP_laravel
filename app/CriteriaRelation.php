<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CriteriaRelation extends Model
{
    public function first_criteria()
    {
        return $this->belongsTo('App\Criteria', 'first_criteria_id');
    }

    public function second_criteria()
    {
        return $this->belongsTo('App\Criteria', 'second_criteria_id');
    }
}

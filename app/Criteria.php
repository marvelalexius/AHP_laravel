<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{

    public function first_criteria()
    {
        return $this->belongsToMany('App\Criteria', 'criteria_relations', 'first_criteria_id', 'second_criteria_id')->withPivot('weight');
    }

    public function second_criteria()
    {
        return $this->belongsToMany('App\Criteria', 'criteria_relations', 'second_criteria_id', 'first_criteria_id')->withPivot('weight');
    }

    public function total()
    {
        return $this->hasOne('App\CriteriaTotal');
    }
}

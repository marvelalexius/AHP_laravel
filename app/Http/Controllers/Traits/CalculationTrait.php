<?php

namespace App\Http\Controllers\Traits;

trait CalculationTrait
{
  public function generateTable($criterias, $criteria_names)
  {
    $criteria_table = $criterias->mapWithKeys(function($item, $key) {
        $sorted_criteria = $item->first_criteria->sortBy('id');

        return [
            $item->name => $sorted_criteria->mapWithKeys(function($item, $key) {
                return [
                    $item->name => $item->pivot->weight
                ];
            })  
        ];
    });

    foreach ($criteria_table as $key => $criteria) {
        $transform = $criteria->all();
        foreach ($criteria_names as $name) {
            $missing = array_key_exists($name, $transform);
            // dd($transform);
            if (!$missing) {
                $criteria->prepend($criteria[$key] / $criteria_table[$name][$key], $name);
            }
        }
    }
    
    $criteria_table->transform(function ($criteria) use ($criteria_names) {
        return collect(array_replace(array_flip($criteria_names), $criteria->all()));
    });

    // Add Jumlah column to relation table
    $criteria_table->put(
        'Jumlah', 
        $criterias->map(function ($criteria) use ($criteria_table) {
            return $criteria_table->sum($criteria->name);
        })
    );

    return $criteria_table;
  }

  public function generateTotal($criteria_table, $criterias)
  {
    // Prepare jumlah column for eigen calculation
    $criteria_total = $criterias->mapWithKeys(function ($criteria) use ($criteria_table) {
        return [$criteria->name => $criteria_table->sum($criteria->name)];
    });

    return $criteria_total;
  }

  public function generateEigen($criteria_table, $criteria_total, $criterias)
  {
      // Eigen Calculation
      $criteria_eigen = $criterias->mapWithKeys(function ($criteria, $first) use ($criteria_table, $criteria_total) {
            return [
                $criteria->name => $criteria_table[$criteria->name]->mapWithKeys(function ($item, $key) use ($criteria_total) {
                    return [$key => $item / $criteria_total[$key]];
                })
            ];
        });

        // Pushing jumlah column for eigen
        $criteria_eigen->put(
            'Jumlah',
            $criterias->map(function ($criteria) use ($criteria_eigen) {
                return $criteria_eigen->sum($criteria->name);
            })
        );

        return $criteria_eigen;
  }

  public function generateAverageEigen($criteria_eigen, $criteria_count)
  {
    $avg_eigen = $criteria_eigen->mapWithKeys(function ($criteria, $key) use ($criteria_count) {
        return [$key => $criteria->sum() / $criteria_count];
    });

    $avg_eigen = $avg_eigen->filter(function($item, $key) {
        return $key !== 'Jumlah';
    });

    return $avg_eigen;
  }
}
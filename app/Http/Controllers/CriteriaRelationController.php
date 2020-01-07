<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\CriteriaRelation;
use App\Criteria;
use App\CriteriaTotal;

use App\Http\Controllers\Traits\CalculationTrait;

class CriteriaRelationController extends Controller
{
    use CalculationTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $criteria_relations = CriteriaRelation::all();
        $criterias = Criteria::all();
        $criteria_count = count($criterias);
        $criteria_names = $criterias->pluck('name')->all();
        $hitung = $request->hitung;
        
        if ($request->hitung) {
            $criteria_table = $this->generateTable($criterias, $criteria_names);
    
            $criteria_total = $this->generateTotal($criteria_table, $criterias);
    
            $criteria_eigen = $this->generateEigen($criteria_table, $criteria_total, $criterias);
    
            $avg_eigen = $this->generateAverageEigen($criteria_eigen, $criteria_count);
    
            // Save to total database
            foreach ($criterias as $criteria) {
                if (!isset($criteria->total)) {
                    $total = new CriteriaTotal;
                    $total->criteria_id = $criteria->id;
                    $total->total = $avg_eigen[$criteria->name];
                    $total->save();
                }
                // } else {
                //     $total = CriteriaTotal::find($criteria->total->id);
                //     $total->criteria_id = $criteria->id;
                //     $total->total = $avg_eigen[$criteria->name];
                //     $total->save();
                // }
            }
        }

        return view('criteria_relation', compact('criterias', 'criteria_relations', 'criteria_table', 'criteria_eigen', 'avg_eigen', 'hitung'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_criteria' => 'required',
            'weight' => 'required|numeric',
            'second_criteria' => 'required'
        ]);

        $criteria = Criteria::find($request->first_criteria);

        $search_relation = CriteriaRelation::where('first_criteria_id', $request->first_criteria)->where('second_criteria_id', $request->second_criteria);

        if ($search_relation->exists()) {
            $criteria_relation = $search_relation->first();
            $criteria_relation->first_criteria_id = $request->first_criteria;
            $criteria_relation->second_criteria_id = $request->second_criteria;
            $criteria_relation->weight = $request->weight;
            $criteria_relation->save();
        } else {
            $criteria->first_criteria()->attach($request->second_criteria, ['weight' => $request->weight]);
        }

        return redirect()->route('criteria_relations.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

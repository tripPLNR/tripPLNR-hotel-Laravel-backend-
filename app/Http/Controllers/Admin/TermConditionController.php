<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TermCondition;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTermCondition;
use App\Http\Requests\UpdateTermCondition;

class TermConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $termCondition = TermCondition::where('type','condition')->first();
            if(!$termCondition){
                return redirect(route('term-condition.create'));
            } else{
                return redirect(route('term-condition.edit',$termCondition->id));
            }
            
        }catch(\Exception $e){
            dd($e->getMessage());
            return back()->withErrors('error',$e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = 'Term of use';
        return view('admin.term-condition.add',compact('page_title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTermCondition $request)
    {
        try{
            $conditionObj = new TermCondition();
            $conditionObj->title = $request->title ?? '';
            $conditionObj->conditions = $request->conditions ?? '';
            $conditionObj->type = 'condition';
            $conditionObj->created_by = Auth::user()->id ?? 1;
            if($conditionObj->save()){
                return redirect(route('term-condition.index'))->with('success','New term-condition saved successfully');
            }
        }catch(\Exception $e){
            return back()->withErrors('error',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect(route('user'))->with('error','Function not allowed.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $page_title = 'Term of use';
            $termCondition = TermCondition::where('type','condition')->where('id',$id)->first();
            if(!$termCondition){
                return redirect(route('user'))->with('error','Term condition not exist.');
            }
            return view('admin.term-condition.edit',compact('termCondition','page_title'));
        }catch(\Exception $e){
            return back()->withErrors('error',$e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTermCondition $request, $id)
    {
        try{
            $conditionObj = TermCondition::where('id',$id)->first();
            if(!$conditionObj){
                return back()->with('error','Term-condition not found');
            }
            $conditionObj->title = $request->title ?? '';
            $conditionObj->conditions = $request->conditions ?? '';
            $conditionObj->type = 'condition';
            $conditionObj->created_by = Auth::user()->id ?? 1;
            if($conditionObj->save()){
                return redirect(route('term-condition.index'))->with('success','New term-condition saved successfully');
            }
        }catch(\Exception $e){
            return back()->withErrors('error',$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return redirect(route('user'))->with('error','Function not allowed.');
    }
}

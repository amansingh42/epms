<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $designation = Designation::paginate(5);
        return view('designation.index',compact('designation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('designation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $designation = Designation::where('name',strtolower($request->name))->first();
        
        if($designation && isset($designation->name)){
            return redirect()->route('designation.index')->with('error','Designation already exist');
        } else{
            $desg = Designation::create(['name'=>strtolower($request->name)]);    
        }

        return redirect()->route('designation.index')->with('success','Designation saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function show(Designation $designation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $designation = Designation::find($id);

        return view('designation.edit',compact('designation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $designation = Designation::where('id',$id)->first();
        $designation->name = $request->name;
        $designation->save();

        return redirect()->route('designation.index')->with('success','Designation updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $des = Designation::where('id',$id)->delete();

        if($des){
            return redirect()->route('designation.index')->with('success','Designation deleted successfully');
        }
        return redirect()->route('designation.index')->with('error','No Data found');
    }
}

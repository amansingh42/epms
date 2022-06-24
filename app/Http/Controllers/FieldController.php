<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Field;
use App\Models\Designation;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fields = Field::paginate(5);
        return view('field.index',compact('fields'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::get();
        $designations = Designation::get(); 
        return view('field.create',compact('roles','designations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'role' => 'required',
            'desg' => 'required'
        ]);

        $fields = Field::where('name',$request->name)->where('role_id',$request->role)->get();
        
        if(count($fields) != 0){
            return redirect()->route('field.index')->with('error','Field name is already exists.'); 
        }else{
            $field = Field::create([
                'name' => $request->name,
                'status' => $request->status,
                'role_id' => $request->role,
                'designation_id' => implode(',',$request->desg)
            ]);

            return redirect()->route('field.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function show(Field $field)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $field = Field::find($id);
        $roles = Role::get();
        $designations = Designation::get(); 
        return view('field.edit',compact('field','roles','designations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Field $field)
    {
        $request->validate([
            'name' => 'required',
            'status'  => 'required',
            'role'  => 'required',
            'desg'  => 'required'
        ]);
        
        $fields = Field::where('name',$request->name)->where('role_id',$request->role)->where('id','!=',$field->id)->get();

        if(count($fields) != 0){
            return redirect()->route('field.index')->with('error','Field name is already exists.');
        } else {

            $field->name = $request->name;
            $field->role_id = $request->role;
            $field->designation_id = implode(',',$request->desg);
            $field->status = $request->status;
            $field->save();
    
            return redirect()->route('field.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $field = Field::where('id',$id)->delete();

        return redirect()->route('field.index');
    }
}

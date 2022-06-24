<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    function __construct(){
        $this->middleware('permission:role-list|role-create|role-edit|role-delete',['only'=>['index']]);
        $this->middleware('permission:role-create',['only'=>['create','store']]);
        $this->middleware('permission:role-edit',['only'=>['edit','update']]);
        $this->middleware('permission:role-delete',['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::paginate(10);
        return view('role.index',compact('roles'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::get();

        return view('role.create',compact('permissions'));
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
            'name' => 'required'
        ]);

        $role = Role::create([
            'name' => $request->name
        ]);

        $permissions = $request->permissions;
        if(!empty($permissions)){
            $permissions = Permission::whereIn('id',$permissions)->pluck('id','id');
            
            $role->syncPermissions($permissions);
        }
        
        return redirect()->route('role.index');
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
        $role = Role::findOrFail($id);
        $permissions = Permission::get();

        $rolePermissions = $role->getAllPermissions();
        $haspermissions = [];

        if($rolePermissions && isset($rolePermissions[0])){
            foreach($rolePermissions as $rp){
                $haspermissions[] = $rp->id;
            }
        }

        return view('role.edit',compact('role','permissions','haspermissions'));
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
        $request->validate([
            'name' => 'required'
        ]);

        $role = Role::findOrFail($id);
        $permissions = $request->permissions;
        
        if(!empty($permissions)){
            
            $permissions = Permission::whereIn('id',$permissions)->pluck('id','id');
            
            $role->syncPermissions($permissions);
        }

        return redirect()->route('role.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        if(!empty($role)){
            $haspermissions = $role->getAllPermissions();
    
            $permissions = [];

            if($haspermissions && isset($haspermissions[0])){
                foreach($haspermissions as $permission){
                    $permissions[] = $permission->id;
                }
            }
    
            $role->permissions()->detach($permissions);
            $role->delete();
            
            return redirect()->route('role.index')->with('success','Role deleted successfully.');
        }

        return redirect()->route('role.index')->with('error','Role not found');
    }
}

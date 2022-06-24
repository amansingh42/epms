<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Designation;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    function __construct(){
        $this->middleware('permission:user-list|user-create|user-edit|user-delete',['only'=>['index']]);
        $this->middleware('permission:user-create',['only'=>['create','store']]);
        $this->middleware('permission:user-edit',['only'=>['edit','update']]);
        $this->middleware('permission:user-delete',['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id','desc')->paginate(10);
        
        return view('user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $designations = Designation::all();
        $roles = Role::all();
        return view('user.create',compact('designations','roles'));
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
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'emp_id' => $request->empid,
            'designation_id' => $request->designation,
            'password' => bcrypt($request->password)
        ]);

        $user->assignRole($request->role);

        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // dd('show');
    }
    /**

     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $designations = Designation::all();
        $roles = User::getRoles();
        $userRole = $user->roles->pluck('id');
        
        if($user){
            return view('user.edit',compact('user','designations','roles','userRole'));
        }
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
        // if(!$request->isMethod('PUT')){
        //     return redirect()->route('user.index');
        // }
        $user = User::findOrFail($id);

        $validation = Validator::make($request->all(),[
            'email'  =>  'required|email|unique:users,email,'.$id,
            // 'password'  =>  'required|min:8'
        ]);

        if($validation->fails()){
            return redirect()->route('user.edit',$user->id)
                    ->withInput();
        } else {
            $user->name = $request->name;
            $user->email = $request->email;
            isset($request->password) ? ($user->password = bcrypt($request->password)) : '';
            $user->save();

            return redirect()->route('user.index');
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
        $user = User::findOrFail($id);

        if($user){
            $user->delete();

            return redirect()->route('user.index');
        }
        return redirect()->route('user.index');
    }
}

<?php

namespace App\Models;

use App\Models\Designation;
// use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'designation_id',
        'emp_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */

    function getRoles(){

        if(auth()->user()->roles && auth()->user()->roles[0]->name == 'Admin' ){
            return Role::all();
        }
        return Role::where('name', '!=','admin')->get();
    }

    public function designationName(){

        return $this->belongsTo(Designation::class,'designation_id','id');
        // if(auth()->user()->designation_id != null){
        //     return Designation::where('id',auth()->user()->designation_id)->get();
        // }
        // return false;
    }

    public function empDesg(){
        return $this->belongsTo(Designation::class,'designation_id','id');
    }
}

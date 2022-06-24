<?php

namespace App\Models;

use App\Models\User;
use App\Models\FieldValue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','month','year','admin_deduct_points','admin_remarks','hr_remarks','avg_points'];

    public function ratingValue(){
        return $this->hasMany(FieldValue::class,'report_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}

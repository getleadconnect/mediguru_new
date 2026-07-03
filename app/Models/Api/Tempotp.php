<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class Tempotp extends Model
{
   protected $guarded=[];
	
	protected $table = 'tempotps';  
	 
    protected $fillable = [
        'mobile','otp'
    ];
	
	protected $hidden=['created_at','updated_at'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class State extends Model
{
    use HasFactory;
	
	protected $table='states';
	
    protected $fillable = [
      'state',
    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	
}

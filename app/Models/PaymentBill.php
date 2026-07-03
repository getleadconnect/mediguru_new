<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentBill extends Model
{
    use HasFactory;
	
	protected $table='payment_bills';
	
    protected $fillable = [	'payment_id','student_id','course_unique_id','purchased_package_id',
						'package_id','bill_filename'
					];	

	protected $primaryKey='id';
	
    protected $hidden = [
        'created_at',
		'updated_at',
    ];


	
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class adminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    	
	public function run()
    {
        DB::table('admins')->insert(
		[
        	'name'	=> 'admin',
			'email'	=> 'admin@mediguru.co.in',
			'mobile'	=> '1234567891',
			'role_id'	=> '1',
        	'password'	=> Hash::make('mguru@2022')
			'status'=>1
        ],
		[
        	'name'	=> 'shaji',
			'email'	=> 'shaji@webqua.com',
			'mobile'	=> '1234567890',
			'role_id'	=> '1',
        	'password'	=> Hash::make('12345')
			'status'=>1
        ]);
    }
	
}
